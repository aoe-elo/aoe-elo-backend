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

interface TournamentRepositoryInterface
{
    public function getAllTournaments();

    public function getAllTournamentsCount();

    public function getAllTournamentsPaginated();

    public function getTournamentById($tournamentId);

    public function deleteTournament($tournamentId, int $user_id, string $actionlog_summary);

    public function createTournament(array $tournamentDetails, int $user_id, string $actionlog_summary);

    public function updateTournament($tournamentId, array $newTournamentDetails, int $user_id, string $actionlog_summary);
}
