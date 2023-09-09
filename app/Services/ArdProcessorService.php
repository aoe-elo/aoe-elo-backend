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
use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Ada\Requests\AoeRefRequest;
use App\Utilities\ProgressBar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArdProcessorService implements DataProcessingInterface
{
    private int $ada_user_id;
    private $pb_width = 70;
    private Collection $player_data;
    private Collection $team_data;
    private PlayerRepositoryInterface $player_repository;
    private TeamRepositoryInterface $team_repository;
    private CountryRepositoryInterface $country_repository;

    public function __construct(PlayerRepositoryInterface $player_repository, TeamRepositoryInterface $team_repository, CountryRepositoryInterface $country_repository)
    {
        $this->player_repository = $player_repository;
        $this->team_repository = $team_repository;
        $this->country_repository = $country_repository;
        $this->ada_user_id = UserRepository::getUserByName('ada')->id;
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
        // https://laravel.com/docs/10.x/collections#method-diffassoc
    }

    public function initialImport(): void
    {
        $data = (new AoeRefRequest())->fetch(); // TODO! Error handling
        $this->player_data = collect($data['players']);
        $this->team_data = collect($data['teams']);

        $players_count = $this->player_data->count();
        $teams_count = $this->team_data->count();

        $pb_count = 0;
        foreach ($this->team_data->toArray() as $team) {
            echo ProgressBar::render($pb_count, $teams_count, 'Adding team: ' . $team['name'], $this->pb_width ?? 50);

            $this->team_repository->createTeam([
                'id' => $team['id'],
                'name' => $team['name'],
            ], $this->ada_user_id, 'Created team ' . $team['name']);

            $pb_count++;
        }

        echo "\rInsertion of teams complete.\n";

        $pb_count = 0;

        foreach ($this->player_data->toArray() as $player) {
            echo ProgressBar::render($pb_count, $players_count, 'Adding player: ' . $player['name'], $this->pb_width ?? 50);

            $country = $player['country'] ?? null;
            if ($country == null) {
                $country_id = null;
            } else {
                // rewrite certain countries to match iso
                $country = match ($country) {
                    'uk' => 'gb',
                    'gb-sct' => 'gb',
                    $country => $country,
                };

                $country_id = $this->country_repository->getCountryByIso2Key(Str::upper($country))->id ?? null;
                if ($country_id == null) {
                    Log::info("Country with iso_3166_2 key $country not found in DB.");
                }
            }

            $created_player = $this->player_repository->createPlayer([
                'id' => $player['id'] ?? null,
                'name' => $player['name'],
                'country_id' => $country_id ?? null,
                'aoeelo_id' => $player['aoeelo'] ?? null,
                'liquipedia_handle' => $player['liquipedia'] ?? null,
                'esports_earnings' => $player['esportsearnings'] ?? null,
                'discord_id' => $player['discord_id'] ?? null,
            ], $this->ada_user_id, 'Created player ' . $player['name']);

            if (isset($player['team'])) {
                $created_player->ard_teams()->attach($player['team']);
            }

            foreach (LookupService::getArdMetadataArray() as $field => $type) {
                if (isset($player[$field])) {
                    if (is_array($player[$field])) {
                        foreach ($player[$field] as $item) {
                            $created_player->metadata()->create([
                                'key' => $field,
                                'type_of_value' => $type,
                                $type => $item,
                                'is_verified' => true,
                            ]);
                        }
                    } else {
                        $created_player->metadata()->create([
                            'key' => $field,
                            'type_of_value' => $type,
                            $type => $item,
                            'is_verified' => true,
                        ]);
                    }
                }
            }

            foreach (LookupService::getArdPlatformMetadataArray() as $field => $type) {
                // we are flattening the ard structure here
                // as we don't really want to work with a sub_key in the DB
                // for such a simple structure
                // so we pull up the platform name and use it as a key instead
                // of using the platform name as a sub_key
                if (isset($player['platforms']['$field'])) {
                    if (is_array($player['platforms'][$field])) {
                        foreach ($player['platforms'][$field] as $item) {
                            $created_player->metadata()->create([
                                'key' => $field,
                                'type_of_value' => $type,
                                $type => $item,
                                'is_verified' => true,
                            ]);
                        }
                    } else {
                        $created_player->metadata()->create([
                            'key' => $field,
                            'type_of_value' => $type,
                            $type => $player['platforms'][$field],
                            'is_verified' => true,
                        ]);
                    }
                }
            }

            $pb_count++;
        }

        echo "\rInsertion of players complete.\n";
    }
}
