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

interface TeamRepositoryInterface
{
    public function getAllTeams();

    public function getTeamById($teamId);

    public function deleteTeam($teamId, int $user_id, string $actionlog_summary);

    public function createTeam(array $teamDetails, int $user_id, string $actionlog_summary);

    public function updateTeam($teamId, array $newTeamDetails, int $user_id, string $actionlog_summary);
}
