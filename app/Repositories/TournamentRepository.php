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

use App\Models\Tournament;
use App\Interfaces\TournamentRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class TournamentRepository implements TournamentRepositoryInterface
{
    private LookupService $lookupService;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllTournaments()
    {
        return Tournament::all(['*']);
    }

    public function getAllTournamentsPaginated()
    {
        return Tournament::paginate();
    }

    public function getTournamentById($tournamentId)
    {
        return Tournament::with(['metadata', 'atp_category', 'results'])->findOrFail($tournamentId, ['*']);
    }

    public function importTournament(array $tournamentDetails, int $create_user_id, string $create_actionlog_summary, DateTime $create_time, int $update_user_id, string $update_actionlog_summary, DateTime $update_time)
    {
        $tournament = Tournament::create($tournamentDetails);

        $tournament->action_logs()->create([
            'user_id' => $create_user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $create_actionlog_summary,
            'created_at' => $create_time,
        ]);

        $tournament->action_logs()->create([
            'user_id' => $update_user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $update_actionlog_summary,
            'updated_at' => $update_time,
        ]);

        return $tournament;
    }

    public function deleteTournament($tournamentId, int $user_id, string $actionlog_summary)
    {
        $tournament = Tournament::findOrFail($tournamentId);

        $tournament->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Tournament::destroy($tournamentId);
    }

    public function createTournament(array $tournamentDetails, int $user_id, string $actionlog_summary)
    {
        $tournament = Tournament::create($tournamentDetails);

        $tournament->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $tournament;
    }

    public function updateTournament($tournamentId, array $newTournamentDetails, int $user_id, string $actionlog_summary)
    {
        $tournament = Tournament::whereId($tournamentId)->update($newTournamentDetails);

        $tournament->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $tournament;
    }
}
