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

use Illuminate\Support\Facades\Http;

class LiquipediaRequest
{
    private $api_key = env('LP_API_KEY', null);

    public $base_url = 'https://api.liquipedia.net/api/';

    public $endpoint_lookup = [
        'players' => 'v3/player',
    ];

    public $user_agent = 'AoE-Elo.com Crawler (info@aoe-elo.com)';
    public $wait_secs = 30;
    public $page_size = 200;
    public $conditions;
    public $properties = [
        'Has id',
        'Has team',
        'Has twitch stream',
        'Has youtube channel'
    ];
    public $output = [];
    public $cache = false;
    private $debug = false;
    public $export_data = [];

    public function __construct($debug = null, $cache = null, $game = 'aoe2')
    {
        if ($debug === true) {
            $this->debug = true;
        } else {
            $this->debug = false;
        }

        if ($cache === true) {
            $this->cache = true;
        } else {
            $this->cache = false;
        }

        if ($game == 'aoe2') {
            $this->conditions = [
                'Category:Age of Empires II Players',
                'Is player::true'
            ];
        }
    }

    public function fetch()
    {
        $offset = 0;

        while (true) {
            echo "querying liquipedia at offset $offset\n";

            $resp = Http::withToken('Apikey ' . $this->api_key)
                ->withHeader('User-Agent', $this->user_agent)
                ->get($this->base_url, [
                    'wiki' => 'ageofempires',
                    'query' => [
                        'action' => 'askargs',
                        'format' => 'json',
                        'conditions' => implode('|', $this->conditions),
                        'printouts' => implode('|', $this->properties),
                        'parameters' => implode('&', ["offset=$offset", "limit={$this->page_size}"])
                    ],
                ])->object();

            if ($this->debug) {
                echo 'Request url: ' . $this->base_url . '?' . http_build_query([
                    'action' => 'askargs',
                    'format' => 'json',
                    'conditions' => implode('|', $this->conditions),
                    'printouts' => implode('|', $this->properties),
                    'parameters' => implode('&', ["offset=$offset", "limit={$this->page_size}"])
                ]) . "\n";
            }

            try {
                $data = json_decode($resp, true);
            } catch (\Error $e) {
                // TODO!: Handle this error
                echo 'failed to fetch: ' . $resp . "\n";

                return;
            }

            foreach ($data['query']['results'] as $result) {
                $record = $result['printouts'];
                $team = isset($record['Has team'][0]['fulltext']) ? $record['Has team'][0]['fulltext'] : null;
                $name = $record['Has id'][0];
                $twitch = isset($record['Has twitch stream'][0]) ? $record['Has twitch stream'][0] : null;
                $youtube = isset($record['Has youtube channel'][0]) ? $record['Has youtube channel'][0] : null;

                // TODO: Query for Facebook Gaming as well
                $facebook_gaming = null;

                $this->output[] = [
                    'name' => strtolower($name),
                    'liquipedia' => $name,
                    'team' => $team,
                    'twitch' => $twitch,
                    'youtube' => $youtube,
                    'facebook_gaming' => $facebook_gaming
                ];
            }

            $offset = $data['query-continue-offset'] ?? null;

            if (!$offset) {
                break;
            }

            sleep($this->wait_secs);
        }

        if ($this->cache) {
            $this->export_data = $this->output;
        }
    }
}
