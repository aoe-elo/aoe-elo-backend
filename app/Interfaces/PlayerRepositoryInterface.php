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

interface PlayerRepositoryInterface
{
    public function getAllPlayers();

    public function getAllPlayersPaginated();

    public function getPlayerById($playerId);

    public function deletePlayer($playerId, int $user_id, string $actionlog_summary);

    public function createPlayer(array $playerDetails, int $user_id, string $actionlog_summary);

    public function updatePlayer($playerId, array $newPlayerDetails, int $user_id, string $actionlog_summary);
}
