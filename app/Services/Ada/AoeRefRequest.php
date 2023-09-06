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

namespace App\Services\Ada;

use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

class AoeRefRequest
{
    private string $url_players = 'https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/players.yaml';
    private string $url_teams = 'https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/teams.json';

    public function fetch(): array
    {
        $client = new Client();
        $players_response = $client->get($this->url_players);
        $teams_response = $client->get($this->url_teams);

        $players_yaml = $players_response->getBody()->getContents();
        $teams_json = $teams_response->getBody()->getContents();

        $players = Yaml::parse($players_yaml);
        $teams = json_decode($teams_json, true);

        return [
            'players' => $players,
            'teams' => $teams
        ];
    }
}
