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

use App\Models\Legacy\LegacyTournament;
use App\Interfaces\TournamentRepositoryInterface;

class LegacyTournamentRepository implements TournamentRepositoryInterface
{
    public function getAllTournaments()
    {
        return LegacyTournament::all(['*']);
    }

    public function getAllTournamentsCount(): int
    {
        return LegacyTournament::count();
    }

    public function getAllTournamentsPaginated()
    {
        throw new \Exception('Not implemented');
    }

    public function getTournamentById($tournamentId)
    {
        return LegacyTournament::findOrFail($tournamentId);
    }

    public function getAllTournamentsCursorWithMigration()
    {
        return LegacyTournament::with(['parent', 'children', 'migration', 'legacy_tournament_info', 'legacy_tournament_results'])->cursor();
    }

    public function deleteTournament($tournamentId, int $user_id, string $actionlog_summary)
    {
        throw new \Exception('Not implemented');
    }

    public function createTournament(array $tournamentDetails, int $user_id, string $actionlog_summary)
    {
        throw new \Exception('Not implemented');
    }

    public function updateTournament($tournamentId, array $newTournamentDetails, int $user_id, string $actionlog_summary)
    {
        throw new \Exception('Not implemented');
    }
}
