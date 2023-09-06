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

use DateTime;

interface LocationRepositoryInterface
{
    public function getAllLocations();

    public function getLocationById($locationId);

    public function getLocationByName($locationName);

    public function deleteLocation($locationId, int $user_id, string $actionlog_summary);

    public function createLocation(array $locationDetails, int $user_id, string $actionlog_summary);

    public function updateLocation($locationId, array $newLocationDetails, int $user_id, string $actionlog_summary);
}
