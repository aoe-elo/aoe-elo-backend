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

use App\Models\Actionlog;
use App\Interfaces\ActionlogRepositoryInterface;

class ActionlogRepository implements ActionlogRepositoryInterface
{
    public function getAllActionlogEntries()
    {
        return Actionlog::all(['*']);
    }

    public function getAllActionlogEntriesForEntity($entityId, $entityType)
    {
        return Actionlog::where('loggable_id', $entityId)->where('loggable_type', $entityType)->get();
    }

    public function getActionlogEntryById($actionlogEntryId)
    {
        return Actionlog::findOrFail($actionlogEntryId);
    }

    public function getActionlogEntriesByUserId($userId)
    {
        return Actionlog::where('user_id', $userId)->get();
    }

    public function getActionlogEntriesByAction($actionName)
    {
        return Actionlog::where('action', $actionName)->get();
    }

    public function deleteActionlogEntry($actionlogEntryId)
    {
        Actionlog::destroy($actionlogEntryId);
    }

    public function createActionlogEntry(array $actionlogDetails)
    {
        return Actionlog::create($actionlogDetails);
    }

    public function updateActionlogEntry($actionlogEntryId, array $newActionlogDetails)
    {
        return Actionlog::whereId($actionlogEntryId)->update($newActionlogDetails);
    }
}
