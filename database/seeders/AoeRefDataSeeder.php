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

namespace Database\Seeders;

use App\Models\Metadata;
use App\Repositories\ActionlogRepository;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\ArdTeamRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MetadataRepository;
use App\Repositories\UserRepository;
use App\Services\Ada\AoeRefRequest;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Str;
use App\Utilities\ProgressBar;

class AoeRefDataSeeder extends Seeder
{
    private $pb_width = 70;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $req = new AoeRefRequest();
        $data = $req->fetch();

        $players = $data['players'];
        $teams = $data['teams'];

        $player_repository = new ArdPlayerRepository();
        $team_repository = new ArdTeamRepository();
        $user_id = UserRepository::getUserByName('ada')->id;

        $players_count = count($players);
        $teams_count = count($teams);
        $pb_count = 0;
        foreach ($teams as $team) {
            $pb = ProgressBar::render($pb_count, $teams_count, 'Adding team: ' . $team['name'], $this->pb_width ?? 50);
            echo $pb;

            $team_repository->createTeam([
                'id' => $team['id'],
                'name' => $team['name'],
            ], $user_id, 'Created team ' . $team['name']);

            $pb_count++;
        }

        echo "\rInsertion of teams complete.\n";
        $country_repo = new CountryRepository();
        $pb_count = 0;
        foreach ($players as $player) {
            $pb = ProgressBar::render($pb_count, $players_count, 'Adding player: ' . $player['name'], $this->pb_width ?? 50);
            echo $pb;

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

                $country_id = $country_repo->getCountryByIso2Key(Str::upper($country))->id ?? null;
                if ($country_id == null) {
                    Log::info("Country with iso_3166_2 key $country not found in DB.");
                }
            }

            $created_player = $player_repository->createPlayer([
                'id' => $player['id'] ?? null,
                'name' => $player['name'],
                'country_id' => $country_id ?? null,
                'aoeelo_id' => $player['aoeelo'] ?? null,
                'liquipedia_handle' => $player['liquipedia'] ?? null,
                'esports_earnings' => $player['esportsearnings'] ?? null,
                'discord_id' => $player['discord_id'] ?? null,
            ], $user_id, 'Created player ' . $player['name']);

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
                if (isset($player['platforms'][$field])) {
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
