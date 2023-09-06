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

use App\Models\Location;
use App\Interfaces\LocationRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class LocationRepository implements LocationRepositoryInterface
{
    private $lookupService = null;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllLocations()
    {
        return Location::all(['*']);
    }

    public function getLocationById($locationId)
    {
        return Location::findOrFail($locationId);
    }

    public function getLocationByName($locationName)
    {
        return Location::where('name', $locationName)->firstOrFail();
    }

    public function deleteLocation($locationId, int $user_id, string $actionlog_summary)
    {
        $location = Location::findOrFail($locationId);

        $location->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Location::destroy($locationId);
    }

    public function createLocation(array $locationDetails, int $user_id, string $actionlog_summary)
    {
        $location = Location::create($locationDetails);

        $location->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $location;
    }

    public function updateLocation($locationId, array $newLocationDetails, int $user_id, string $actionlog_summary)
    {
        $location = Location::whereId($locationId)->update($newLocationDetails);

        $location->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $location;
    }
}
