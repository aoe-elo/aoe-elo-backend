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

use App\Models\Legacy\LegacyTeam;
use App\Interfaces\TeamRepositoryInterface;

class LegacyTeamRepository implements TeamRepositoryInterface
{
    public function getAllTeams()
    {
        return LegacyTeam::all(['*']);
    }

    public function getAllTeamsPaginated()
    {
        throw new \Exception('Not implemented');
    }

    public function getTeamById($teamId)
    {
        return LegacyTeam::findOrFail($teamId);
    }

    public function deleteTeam($teamId)
    {
        throw new \Exception('Not implemented');
    }

    public function createTeam(array $teamDetails)
    {
        throw new \Exception('Not implemented');
    }

    public function updateTeam($teamId, array $newTeamDetails)
    {
        throw new \Exception('Not implemented');
    }
}
