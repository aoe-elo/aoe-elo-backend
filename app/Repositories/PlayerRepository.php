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

use App\Models\Player;
use App\Interfaces\PlayerRepositoryInterface;
use App\Services\LookupService;
use DateTime;

class PlayerRepository implements PlayerRepositoryInterface
{
    private $lookupService = null;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllPlayersPaginated()
    {
        return Player::paginate();
    }

    public function getAllPlayers()
    {
        return Player::all(['*']);
    }

    public function getPlayerById($playerId)
    {
        return Player::with(['metadata', 'teams', 'tournament_results', 'set_items', 'country'])->findOrFail($playerId, ['*']);
    }

    public function deletePlayer($playerId, int $user_id, string $actionlog_summary)
    {
        $player = Player::findOrFail($playerId);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Player::destroy($playerId);
    }

    public function createPlayer(array $playerDetails, int $user_id, string $actionlog_summary)
    {
        $player = Player::create($playerDetails);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $player;
    }

    public function importPlayer(array $playerDetails, int $create_user_id, string $create_actionlog_summary, DateTime $create_time, int $update_user_id, string $update_actionlog_summary, DateTime $update_time)
    {
        $player = Player::create($playerDetails);

        $player->action_logs()->create([
            'user_id' => $create_user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $create_actionlog_summary,
            'created_at' => $create_time,
        ]);

        $player->action_logs()->create([
            'user_id' => $update_user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $update_actionlog_summary,
            'updated_at' => $update_time,
        ]);

        return $player;
    }

    public function updatePlayer($playerId, array $newPlayerDetails, int $user_id, string $actionlog_summary)
    {
        $player = Player::whereId($playerId)->update($newPlayerDetails);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $player;
    }
}
