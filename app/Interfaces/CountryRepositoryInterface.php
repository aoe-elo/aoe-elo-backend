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

namespace App\Interfaces;

interface CountryRepositoryInterface
{
    public function getAllCountries();

    public function getCountryById($countryId);

    public function getCountryByIso2Key($countryIsoKey);

    public function getCountryByName($countryName);

    public function deleteCountry($countryId);

    public function createCountry(array $countryDetails);

    public function updateCountry($countryId, array $newCountryDetails);
}
