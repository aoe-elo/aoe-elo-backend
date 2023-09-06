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

namespace App\Repositories;

use App\Models\Country;
use App\Interfaces\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    public function getAllCountries()
    {
        return Country::all(['*']);
    }

    public function getCountryById($countryId)
    {
        return Country::findOrFail($countryId);
    }

    public function getCountryByIso2Key($countryIsoKey)
    {
        return Country::where('iso_3166_2', $countryIsoKey)->first();
    }

    public function getCountryByName($countryName)
    {
        return Country::where('name', $countryName)->firstOrFail();
    }

    public function deleteCountry($countryId)
    {
        Country::destroy($countryId);
    }

    public function createCountry(array $countryDetails)
    {
        return Country::create($countryDetails);
    }

    public function updateCountry($countryId, array $newCountryDetails)
    {
        return Country::whereId($countryId)->update($newCountryDetails);
    }
}
