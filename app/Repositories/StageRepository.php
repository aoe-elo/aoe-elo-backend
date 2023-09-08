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
use App\Models\Stage;
use App\Interfaces\StageRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class StageRepository implements StageRepositoryInterface
{
    private LookupService $lookupService;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllStages()
    {
        return Stage::all(['*']);
    }

    public function getAllStagesPaginated()
    {
        return Stage::paginate();
    }

    public function getStageById($stageId)
    {
        return Stage::findOrFail($stageId);
    }

    public function deleteStage($stageId, int $user_id, string $actionlog_summary)
    {
        $stage = Stage::findOrFail($stageId);

        $stage->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Stage::destroy($stageId);
    }

    public function createStage(array $stageDetails, int $user_id, string $actionlog_summary)
    {
        $stage = Stage::create($stageDetails);

        $stage->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $stage;
    }

    public function getAllStagesCursorWithRelations()
    {
        return Stage::orderBy('played_at', 'asc')->with(['action_logs', 'tournaments', 'templates', 'reviews'])->cursor();
    }

    public function importStage(array $stageDetails, int $create_user_id, string $create_actionlog_summary, DateTime $create_time, int $update_user_id, string $update_actionlog_summary, DateTime $update_time)
    {
        $stage = Stage::create($stageDetails);

        $stage->action_logs()->create([
            'user_id' => $create_user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $create_actionlog_summary,
            'created_at' => $create_time,
        ]);

        $stage->action_logs()->create([
            'user_id' => $update_user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $update_actionlog_summary,
            'updated_at' => $update_time,
        ]);

        return $stage;
    }

    public function updateStage($stageId, array $newStageDetails, int $user_id, string $actionlog_summary)
    {
        $stage = Stage::whereId($stageId)->update($newStageDetails);

        $stage->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $stage;
    }
}
