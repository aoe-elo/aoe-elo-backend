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

use App\Interfaces\LiquipediaRequestServiceInterface;
use Liquipedia\Client\Configuration;
use Liquipedia\Client\Api\V3Api;
use Exception;

class LiquipediaRequestService implements LiquipediaRequestServiceInterface
{
    private $api_config = Configuration::getDefaultConfiguration()->setApiKey('authorization', 'Apikey ' . env('LP_API_KEY', null));

    private $client = null;
    public $user_agent = 'AoE-Elo.com Crawler (info@aoe-elo.com)';

    public $wiki = 'ageofempires';

    private $limit = 200;

    private $offset = 0;

    public function __construct()
    {
        $this->client = new V3Api(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // client: new GuzzleHttp\Client(),
            config: $this->api_config
        );
    }

    public function getPlayerByLiquipediaId($liquipediaPlayerId)
    {
        // TODO!: Implement API request
        $wiki = $this->wiki; // string | The wikis you want data from. Pipe-separate multiple wikis for multiwiki requests.  **Example:** `dota2`, `dota2|counterstrike`
        $conditions = implode('|', [
            'Category:Age of Empires II Players',
            'Is player::true'
        ]); // string | The filters you want to apply to the request.  **Example:** `[[pagename::Some/Liquipedia/Page]] AND [[namespace::0]]`
        $query = 'query_example'; // string | The datapoints you want to query.  **Example:** `pagename, pageid, namespace`
        $limit = $this->limit; // int | The amount of results you want.  **Example:** `20`
        $offset = $this->offset; // int | This can be used for pagination.  **Example:** `20`
        $order = 'order_example'; // string | The order you want your result in.  **Example:** `pagename ASC`
        $groupby = 'groupby_example'; // string | What you want your results grouped by (this can be helpful when using aggregate functions).  **Example:** `pagename ASC`

        try {
            $result = $this->client->broadcastersGet($wiki, $conditions, $query, $limit, $offset, $order, $groupby);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling V3Api->broadcastersGet: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getLocationByLiquipediaLocationId($liquipediaLocationId)
    {
    }

    public function getTeamByLiquipediaId($liquipediaTeamId)
    {
    }

    public function getTournamentByLiquipediaId($liquipediaTournamentId)
    {
    }

    public function getSetByLiquipediaId($liquipediaSetId)
    {
    }
}
