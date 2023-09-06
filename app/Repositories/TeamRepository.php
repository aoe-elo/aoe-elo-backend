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

use App\Models\Team;
use App\Interfaces\TeamRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class TeamRepository implements TeamRepositoryInterface
{
    private $lookupService = null;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllTeams()
    {
        return Team::all(['*']);
    }

    public function getTeamById($teamId)
    {
        return Team::findOrFail($teamId);
    }

    public function deleteTeam($teamId, int $user_id, string $actionlog_summary)
    {
        $team = Team::findOrFail($teamId);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Team::destroy($teamId);
    }

    public function importTeam(array $teamDetails, int $create_user_id, string $create_actionlog_summary, DateTime $create_time, int $update_user_id, string $update_actionlog_summary, DateTime $update_time)
    {
        $team = Team::create($teamDetails);

        $team->action_logs()->create([
            'user_id' => $create_user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $create_actionlog_summary,
            'created_at' => $create_time,
        ]);

        $team->action_logs()->create([
            'user_id' => $update_user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $update_actionlog_summary,
            'updated_at' => $update_time,
        ]);

        return $team;
    }

    public function createTeam(array $teamDetails, int $user_id, string $actionlog_summary)
    {
        $team = Team::create($teamDetails);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $team;
    }

    public function updateTeam($teamId, array $newTeamDetails, int $user_id, string $actionlog_summary)
    {
        $team = Team::whereId($teamId)->update($newTeamDetails);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $team;
    }
}
