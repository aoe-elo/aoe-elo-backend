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

use App\Models\Legacy\LegacyPlayer;
use App\Interfaces\PlayerRepositoryInterface;

class LegacyPlayerRepository implements PlayerRepositoryInterface
{
    public function getAllPlayers()
    {
        return LegacyPlayer::all(['*']);
    }

    public function getAllPlayersPaginated()
    {
    }

    public function getAllPlayersCursorWithTeamAndMigration()
    {
        return LegacyPlayer::with(['team', 'migration'])->cursor();
    }

    public function getPlayerById($playerId)
    {
        return LegacyPlayer::findOrFail($playerId);
    }

    public function deletePlayer($playerId, int $user_id, string $actionlog_summary)
    {
    }

    public function createPlayer(array $playerDetails, int $user_id, string $actionlog_summary)
    {
    }

    public function updatePlayer($playerId, array $newPlayerDetails, int $user_id, string $actionlog_summary)
    {
    }
}
