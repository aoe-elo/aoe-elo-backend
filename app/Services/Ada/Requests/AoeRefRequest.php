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

namespace App\Services\Ada\Requests;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Http;

class AoeRefRequest
{
    private string $url_players = 'https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/players.yaml';
    private string $url_teams = 'https://raw.githubusercontent.com/SiegeEngineers/aoc-reference-data/master/data/teams.json';

    public function fetch(): array
    {
        $players = Yaml::parse(Http::get($this->url_players)->body());
        $teams = Http::get($this->url_teams)->object();

        return [
            'players' => $players,
            'teams' => $teams
        ];
    }
}
