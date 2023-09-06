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

use App\Models\ArdTeam;
use App\Interfaces\TeamRepositoryInterface;
use App\Services\LookupService;

class ArdTeamRepository implements TeamRepositoryInterface
{
    private $lookupService = null;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllTeams()
    {
        return ArdTeam::all(['*']);
    }

    public function getTeamById($teamId)
    {
        return ArdTeam::findOrFail($teamId);
    }

    public function deleteTeam($teamId, int $user_id, string $actionlog_summary)
    {
        $team = ArdTeam::findOrFail($teamId);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        ArdTeam::destroy($teamId);
    }

    public function createTeam(array $teamDetails, int $user_id, string $actionlog_summary)
    {
        $team = ArdTeam::create($teamDetails);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $team;
    }

    public function updateTeam($teamId, array $newTeamDetails, int $user_id, string $actionlog_summary)
    {
        $team = ArdTeam::whereId($teamId)->update($newTeamDetails);

        $team->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $team;
    }
}
