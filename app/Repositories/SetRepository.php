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

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Set;
use App\Interfaces\SetRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class SetRepository implements SetRepositoryInterface
{
    private LookupService $lookupService;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllSets()
    {
        return Set::all(['*']);
    }

    public function getAllSetsPaginated()
    {
        return Set::paginate();
    }

    public function getSetById($setId)
    {
        return Set::findOrFail($setId);
    }

    public function deleteSet($setId, int $user_id, string $actionlog_summary)
    {
        $set = Set::findOrFail($setId);

        $set->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Set::destroy($setId);
    }

    public function createSet(array $setDetails, int $user_id, string $actionlog_summary)
    {
        $set = Set::create($setDetails);

        $set->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $set;
    }

    public function getAllSetsCursorWithRelations()
    {
        return Set::orderBy('played_at', 'asc')->with(['action_logs', 'set_items', 'stageable'])->cursor();
    }

    public function importSet(array $setDetails, int $create_user_id, string $create_actionlog_summary, DateTime $create_time, int $update_user_id, string $update_actionlog_summary, DateTime $update_time)
    {
        $set = Set::create($setDetails);

        $set->action_logs()->create([
            'user_id' => $create_user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $create_actionlog_summary,
            'created_at' => $create_time,
        ]);

        $set->action_logs()->create([
            'user_id' => $update_user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $update_actionlog_summary,
            'updated_at' => $update_time,
        ]);

        return $set;
    }

    public function updateSet($setId, array $newSetDetails, int $user_id, string $actionlog_summary)
    {
        $set = Set::whereId($setId)->update($newSetDetails);

        $set->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $set;
    }
}
