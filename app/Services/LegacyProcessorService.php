<?php

/**
 * SPDX-License-Identifier: AGPL-3.0-or-later
 *
 * AoE-Elo: https://aoe-elo.com
 * Source: https://github.com/aoe-elo
 *
 * (c) The AoE-Elo Team <info@aoe-elo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services;

use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\DataProcessingInterface;
use App\Repositories\MetadataRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\SetRepository;
use App\Repositories\TeamRepository;
use App\Repositories\TournamentRepository;
use App\Models\Legacy\LegacyMatch1v1;
use App\Models\Legacy\LegacyPlayer;
use App\Models\Legacy\LegacyTournament;
use App\Models\Migrationlog;
use App\Models\Player;
use App\Models\Set;
use App\Models\Stage;
use App\Models\Team;
use App\Models\Tournament;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\LegacyMatchRepository;
use App\Repositories\LegacyPlayerRepository;
use App\Repositories\LegacyTeamRepository;
use App\Repositories\LegacyTournamentRepository;
use App\Utilities\ProgressBar;
use DateTimeImmutable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LegacyProcessorService implements DataProcessingInterface
{
    // Counter for iteration
    private $done = 1;
    // Total
    private $total = 0;

    // width of progress bar
    private $pb_width = 70;

    // mapping the legacy_user_id to one of ours
    private $legacy_user_id_lookup = [
        // legacy_user_id => current_user_id
        1 => 4, // mungo
        2 => 5, // uberrushung
        3 => 6, // huleck
        4 => 7, // vale
        5 => 8, // pumukel
        6 => 9, // michaerbse
        7 => 10, // sieste
    ];

    private LookupService $lookup_service;
    private TournamentRepository $tournament_repository;
    private PlayerRepository $player_repository;
    private SetRepository $set_repository;
    private LegacyMatchRepository $legacy_match_repository;
    private LegacyTournamentRepository $legacy_tournament_repository;
    private LegacyPlayerRepository $legacy_player_repository;
    private MetadataRepository $metadata_repository;
    private ArdPlayerRepository $ard_player_repository;
    private CountryRepositoryInterface $country_repository;
    private TeamRepository $team_repository;
    private Migrationlog $migrationlog;

    public function __construct(
        TournamentRepository $tournament_repository,
        PlayerRepository $player_repository,
        SetRepository $set_repository,
        LegacyMatchRepository $legacy_match_repository,
        LegacyTournamentRepository $legacy_tournament_repository,
        LegacyPlayerRepository $legacy_player_repository,
        MetadataRepository $metadata_repository,
        ArdPlayerRepository $ard_player_repository,
        CountryRepositoryInterface $country_repository,
        TeamRepository $team_repository,
        LookupService $lookup_service,
        Migrationlog $migrationlog,
    ) {
        $this->tournament_repository = $tournament_repository;
        $this->player_repository = $player_repository;
        $this->set_repository = $set_repository;
        $this->legacy_match_repository = $legacy_match_repository;
        $this->legacy_tournament_repository = $legacy_tournament_repository;
        $this->legacy_player_repository = $legacy_player_repository;
        $this->metadata_repository = $metadata_repository;
        $this->ard_player_repository = $ard_player_repository;
        $this->country_repository = $country_repository;
        $this->team_repository = $team_repository;
        $this->lookup_service = $lookup_service;
        $this->migrationlog = $migrationlog;
    }

    public function processData(): void
    {
    }

    public function collectData(): void
    {
    }

    public function storeData(): void
    {
    }

    public function diffData(): void
    {
    }

    public function transformData(): void
    {
    }

    public function initialImport(): void
    {
    }

    public function migrateSets(): void
    {
        $this->total = $this->legacy_match_repository->getAllSetsCount();

        $this->done = 1;
        foreach ($this->legacy_match_repository->getAllMatchesCursorWithMigration() as $legacy_match) {
            echo ProgressBar::render($this->done, $this->total, "Migrating match: $legacy_match->id", $this->pb_width ?? 50);

            $set_state = ($legacy_match->migration()->first())->save_confirmed ?? null;

            if ($set_state == false || $set_state == null) {
                $datetime = DateTimeImmutable::createFromFormat('Y-m-d|+', $legacy_match->date) ?? null;

                $played_at = null;
                if ($datetime != false) {
                    $played_at = $datetime;
                }

                // Unguarding the protected fields for mass assignment
                Set::unguard();

                $tournament = $this->tournament_repository->getTournamentById($legacy_match->tournament_id) ?? null;

                $order = Stage::whereId($legacy_match->stage_id)->first()->default_order;

                if (!$tournament->stages()->where('stage_id', $legacy_match->stage_id)->exists() && $order != null) {
                    $tournament->stages()->withTimestamps()->attach($legacy_match->stage_id, [
                        'stage_order' => $order,
                    ]);
                } else {
                    $tournament->stages()->withTimestamps()->syncWithoutDetaching($legacy_match->stage_id);
                }

                $stageable_id = $tournament->stages()->where('stage_id', $legacy_match->stage_id)->first()->stage_connector->id ?? null;

                $new_set = [
                    'id' => $legacy_match->id,
                    'played_at' => $played_at,
                    'use_played_at_dummy' => (isset($played_at)) ? false : true, // we set these as we don't know for older matches
                    'best_of' => $legacy_match->score_1 + $legacy_match->score_2,
                    'created_at' => $legacy_match->create_time,
                    'updated_at' => $legacy_match->update_time,
                ];

                if (isset($stageable_id)) {
                    $new_set['stageable_id'] = $stageable_id;
                }

                $created_set = $this->set_repository->importSet($new_set, $this->legacy_user_id_lookup[$legacy_match->create_user], 'Created set ' . $legacy_match->id, $legacy_match->create_time, $this->legacy_user_id_lookup[$legacy_match->update_user], 'Updated set ' . $legacy_match->id, $legacy_match->update_time);

                $is_winner = ($legacy_match->score_1 > $legacy_match->score_2) ? true : false;

                $this->player_repository->getPlayerById($legacy_match->player_1_id)->set_items()->create([
                    'set_id' => $created_set->id,
                    'score' => $legacy_match->score_1,
                    'is_winner' => $is_winner,
                    'adjusted_score' => $legacy_match->score_1, // we set these as we don't know for older matches
                    'created_at' => $legacy_match->create_time,
                    'updated_at' => $legacy_match->update_time,
                ]);

                $this->player_repository->getPlayerById($legacy_match->player_2_id)->set_items()->create([
                    'set_id' => $created_set->id,
                    'score' => $legacy_match->score_2,
                    'is_winner' => !$is_winner,
                    'adjusted_score' => $legacy_match->score_2, // we set these as we don't know for older matches
                    'created_at' => $legacy_match->create_time,
                    'updated_at' => $legacy_match->update_time,
                ]);
            }

            $this->done++;
        }

        echo "\n";
        echo "Done migrating matches from legacy database.\n";
    }

    public function migrateTournaments(): void
    {
        $this->total = $this->legacy_tournament_repository->getAllTournamentsCount();

        $this->done = 1;
        foreach ($this->legacy_tournament_repository->getAllTournamentsCursorWithMigration() as $legacy_tournament) {
            echo ProgressBar::render($this->done, $this->total, "Migrating tournament: $legacy_tournament->name", $this->pb_width ?? 50);

            $tournament_state = ($legacy_tournament->migration()->first())->save_confirmed ?? null;

            $game_mode = LookupService::getTournamentGameMode('rm'); // default game mode is RM

            if (str_contains($legacy_tournament->name, 'Red Bull')) {
                $game_mode = LookupService::getTournamentGameMode('ew');
            }

            if ($tournament_state == false || $tournament_state == null) {
                // Unguarding the protected fields for mass assignment
                Tournament::unguard();

                $created_tournament = $this->tournament_repository->importTournament([
                    'id' => $legacy_tournament->id,
                    'name' => $legacy_tournament->name,
                    'short_name' => $legacy_tournament->short,
                    'started_at' => $legacy_tournament->start,
                    'ended_at' => $legacy_tournament->end,
                    'weight' => $legacy_tournament->weight,
                    'game_mode' => $game_mode,
                    'event_type' => LookupService::getTournamentType($legacy_tournament->type),
                    'prize_pool' => $legacy_tournament->prizemoney,
                    'structure' => LookupService::getTournamentStructure($legacy_tournament->structure),
                    'evaluation' => $legacy_tournament->evaluation,
                    'website_link' => (!empty($legacy_tournament->website)) ? $legacy_tournament->website : null,
                    'created_at' => $legacy_tournament->create_time,
                    'updated_at' => $legacy_tournament->update_time,
                ], $this->legacy_user_id_lookup[$legacy_tournament->create_user], 'Created tournament ' . $legacy_tournament->name, $legacy_tournament->create_time, $this->legacy_user_id_lookup[$legacy_tournament->update_user], 'Updated tournament ' . $legacy_tournament->name, $legacy_tournament->update_time);

                // move comment column from legacy db:tournament to metadata
                if (isset($legacy_tournament) && !empty($legacy_tournament->comment)) {
                    $created_tournament->metadata()->create([
                        'key' => 'comment',
                        'type_of_value' => 'text_value',
                        'text_value' => $legacy_tournament->comment,
                        'created_at' => $legacy_tournament->create_time,
                    ]);
                }

                // move tournament_info from legacy db:tournament_info to metadata
                foreach ($legacy_tournament->tournament_info()->cursor() as $tournament_info) {
                    // handle wrongly attributed liquipedia links
                    if (str_contains($tournament_info->value, 'https://liquipedia.net/ageofempires/')) {
                        $created_tournament->update([
                            'liquipedia_link' => $tournament_info->value,
                        ]);

                        continue;
                    }

                    $created_tournament->metadata()->create([
                        'key' => LookupService::getTournamentInfoType($tournament_info->type),
                        'type_of_value' => 'text_value',
                        'text_value' => $tournament_info->value,
                        'created_at' => $tournament_info->create_time,
                    ]);
                }

                // migrate tournament results
                foreach ($legacy_tournament->tournament_results()->cursor() as $tournament_result) {
                    $this->player_repository->getPlayerById($tournament_result->player)->tournament_results()->create([
                        'type' => $tournament_result->type,
                        'prize_amount' => $tournament_result->money,
                        'source' => $tournament_result->source,
                        'created_at' => $tournament_result->create_time,
                        'tournament_id' => $created_tournament->id,
                    ]);

                    $created_tournament->action_logs()->create([
                        'user_id' => $this->legacy_user_id_lookup[$tournament_result->create_user],
                        'action_id' => $this->lookup_service->getActionId('create'),
                        'summary' => 'Created tournament result',
                        'created_at' => $tournament_result->create_time,
                    ]);
                }

                $legacy_tournament->migration()->create([
                    'save_confirmed' => true,
                ]);
            }
            // for our progress bar
            $this->done++;
        }

        echo "\n";
        echo "Done migrating tournaments, info and results from legacy database.\n";
    }

    public function migratePlayersAndTeams(): void
    {
        $this->total = $this->legacy_player_repository->getAllPlayersCount();

        $this->done = 1;
        foreach ($this->legacy_player_repository->getAllPlayersCursorWithTeamAndMigration() as $legacy_player) {
            echo ProgressBar::render($this->done, $this->total, "Migrating player: $legacy_player->name", $this->pb_width ?? 50);

            $player_legacy_team = $legacy_player->team()->first();
            // States
            $player_state = ($legacy_player->migration()->first())->save_confirmed ?? null;

            $team_state = null;

            if (isset($player_legacy_team)) {
                $migration = $player_legacy_team->migration()->first();
                if (isset($migration)) {
                    $team_state = $migration->save_confirmed ?? null;
                }
            }
            $relation_state = $this->migrationlog->where('migratory_id', $legacy_player->id)->where('migratory_type', 'App\Models\PlayerTeam')->first()->save_confirmed ?? null;

            // lookup aoc-reference-data player via aoeelo_id
            $ard_player = $this->ard_player_repository->getAoeEloPlayerByAoeEloId($legacy_player->id) ?? null;

            // split string into array at commas
            $aliases = explode(',', $legacy_player->alias) ?? null;

            $ard_player_metadata_array = null;

            if (isset($ard_player)) {
                $ard_player_metadata_array = $this->metadata_repository->getMetadataArrayForEntity($ard_player) ?? null;

                // deduplicate aliases
                if (array_key_exists('aka', $ard_player_metadata_array)) {
                    $ard_alias = (is_array($ard_player_metadata_array['aka'])) ? $ard_player_metadata_array['aka'] : [$ard_player_metadata_array['aka']];
                    $aliases = array_unique(array_merge($aliases, $ard_alias), SORT_REGULAR);
                }
            }

            // filter out null values from array
            if (count($aliases) == 0 || (count($aliases) == 1 && $aliases[0] == '')) {
                $aliases = null;
            }

            // lookup aoc-reference-data team via ard_team_id
            if (isset($ard_player)) {
                $ard_team = $ard_player->ard_teams()->latest()->first();
            } else {
                $ard_team = null;
            }

            // collect countries from legacy db and aoc-reference-data
            $country = $legacy_country = $legacy_player->country_key ?? null;
            $ard_country = ((isset($ard_player)) ? ($ard_player->country()->first())->iso_3166_2 : null);

            // limit string length to iso_3166_2
            $country = substr($country, 0, 2);
            $ard_country = substr($ard_country, 0, 2);

            // deduplicate countries
            if ($ard_country != null) {
                $countries = array_unique(array_merge([$legacy_country], [$ard_country]), SORT_REGULAR);

                if (count($countries) == 1) {
                    $country = $countries[0];
                } elseif ($legacy_country != null) {
                    $country = $legacy_country;
                } else {
                    $country = $ard_country;
                }
            }

            if ($country == null) {
                $country_id = null;
            } else {
                // rewrite certain countries to match iso
                $country = match ($country) {
                    'uk' => 'gb',
                    $country => $country,
                };

                $country_id = $this->country_repository->getCountryByIso2Key(Str::upper($country))->id ?? null;
                if ($country_id == null) {
                    Log::info("Country with iso_3166_2 key $country not found in DB.");
                }
            }

            if ($player_state == false || $player_state == null) {
                Log::info("Player with id $legacy_player->id doesn't exist in new db.");

                $twitch_handle = null;
                if (isset($ard_player_metadata_array)) {
                    $twitch_handle = $ard_player_metadata_array['twitch'] ?? null;
                }

                // Unguarding the protected fields for mass assignment
                Player::unguard();

                $created_player = $this->player_repository->importPlayer([
                    'id' => $legacy_player->id,
                    'name' => $legacy_player->name,
                    'country_id' => $country_id,
                    'base_elo' => $legacy_player->initial_elo_1v1,
                    // TODO: We do need to set relic_link_id_main
                    // For this we need to have a script running through the metadata of the
                    // connected ArdPlayer and check with aoe2net or something similar where
                    // the last match has been played on
                    'voobly_id_main' => $legacy_player->voobly_id,
                    'steam_id_main' => $legacy_player->steam_id_failed,
                    'liquipedia_handle' => $ard_player['liquipedia_handle'] ?? null,
                    'discord_handle' => $ard_player['discord_id'] ?? null,
                    'twitch_handle' => $twitch_handle ?? null,
                    'aoe_reference_data_player_id' => $ard_player['id'] ?? null,
                    'created_at' => $legacy_player->create_time,
                    'updated_at' => $legacy_player->update_time,
                ], $this->legacy_user_id_lookup[$legacy_player->create_user], 'Created player ' . $legacy_player->name, $legacy_player->create_time, $this->legacy_user_id_lookup[$legacy_player->update_user], 'Updated player ' . $legacy_player->name, $legacy_player->update_time);

                // create metadata entries from ArdPlayer
                if (isset($ard_player)) {
                    foreach ($ard_player->metadata()->cursor() as $metadata) {
                        if (in_array($metadata->key, ['aka', 'twitch'])) {
                            // aka: are handled on the top when it comes to aliases
                            // twitch: is handled above, and goes directly into the twitch_handle
                            // if someone owns more than one Twitch handle (unlikely) this could fail
                            // as this is only at the migration step, we can safely ignore this
                            continue;
                        }
                        $type = $metadata->type_of_value;
                        $created_player->metadata()->create([
                            'key' => $metadata->key,
                            'type_of_value' => $type,
                            $type => $metadata->$type,
                            'is_verified' => true,
                        ]);
                    }
                }

                if (isset($aliases)) {
                    foreach ($aliases as $alias) {
                        $created_player->metadata()->create([
                            'key' => 'alias',
                            'type_of_value' => 'str50_value',
                            'str50_value' => $alias,
                            'is_verified' => true,
                        ]);
                    }
                }

                $legacy_player->migration()->create([
                    'save_confirmed' => true,
                ]);
            }

            if (($team_state == false || $team_state == null) && isset($player_legacy_team)) {
                // Unguarding the protected fields for mass assignment
                Team::unguard();

                $team_id = $this->team_repository->importTeam([
                    'id' => $player_legacy_team->id,
                    'name' => $player_legacy_team->name,
                    'tag' => $player_legacy_team->tag,
                    'primary_color' => $player_legacy_team->primary_color,
                    'secondary_color' => $player_legacy_team->secondary_color,
                    'aoe_reference_data_team_id' => $ard_team->id ?? null,
                    'created_at' => $player_legacy_team->create_time,
                    'updated_at' => $player_legacy_team->update_time,
                ], $this->legacy_user_id_lookup[$player_legacy_team->create_user], 'Created team ' . $player_legacy_team->name, $player_legacy_team->create_time, $this->legacy_user_id_lookup[$player_legacy_team->update_user], 'Updated team ' . $player_legacy_team->name, $player_legacy_team->update_time);

                $player_legacy_team->migration()->create([
                    'save_confirmed' => true,
                ]);

                if (($relation_state == false || $relation_state == null)) {
                    $created_player->teams()->attach($team_id) ?? null;
                }
            }
            // for our progress bar
            $this->done++;
        }

        echo "\n";
        echo "Done migrating players and their teams from legacy database.\n";
    }
}
