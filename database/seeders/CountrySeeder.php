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

use App\Models\Country;
use App\Repositories\ActionlogRepository;
use App\Repositories\UserRepository;
use App\Services\LookupService;
use Illuminate\Database\Seeder;
use Webpatser\Countries\Countries;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries_model = new Countries();
        $user_id = UserRepository::getUserByName('ada')->id;
        $actionlog = new ActionlogRepository();
        $lookup_service = new LookupService();

        // Empty the countries table
        $country_model = new Country();
        $country_model->delete();

        // Get all of the countries
        $countries = $countries_model->getList();
        foreach ($countries as $countryId => $country) {
            $country_model->insert([
                'id' => $countryId,
                'capital' => $country['capital'] ?? null,
                'citizenship' => $country['citizenship'] ?? null,
                'country_code' => $country['country-code'],
                'currency' => $country['currency'] ?? null,
                'currency_code' => $country['currency_code'] ?? null,
                'currency_sub_unit' => $country['currency_sub_unit'] ?? null,
                'currency_decimals' => $country['currency_decimals'] ?? null,
                'full_name' => $country['full_name'] ?? null,
                'iso_3166_2' => $country['iso_3166_2'],
                'iso_3166_3' => $country['iso_3166_3'],
                'name' => $country['name'],
                'region_code' => $country['region-code'],
                'sub_region_code' => $country['sub-region-code'],
                'eea' => (bool) $country['eea'],
                'calling_code' => $country['calling_code'],
                'currency_symbol' => $country['currency_symbol'] ?? null,
                'flag' => $country['flag'] ?? null,
            ]);

            $actionlog->createActionlogEntry([
                'user_id' => $user_id,
                'action_id' => $lookup_service->getActionId('create'),
                'summary' => 'Created country ' . $country['name'],
                'loggable_id' => $countryId,
                'loggable_type' => 'App\Models\Country',
            ]);
        }
    }
}
