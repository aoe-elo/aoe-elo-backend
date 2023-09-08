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

use App\Models\ArdPlayer;
use App\Interfaces\PlayerRepositoryInterface;
use App\Services\LookupService;

class ArdPlayerRepository implements PlayerRepositoryInterface
{
    private $lookupService = null;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllPlayersPaginated()
    {
        throw new \Exception('Not implemented');
    }

    public function getAllPlayers()
    {
        return ArdPlayer::all(['*']);
    }

    public function getPlayerById($playerId)
    {
        return ArdPlayer::findOrFail($playerId);
    }

    public function getAoeEloPlayerByAoeEloId($aoeEloPlayerId)
    {
        return ArdPlayer::with(['ard_teams', 'player', 'country', 'metadata'])->where('aoeelo_id', $aoeEloPlayerId)->first(['*']);
    }

    public function deletePlayer($playerId, int $user_id, string $actionlog_summary)
    {
        $player = ArdPlayer::findOrFail($playerId);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        ArdPlayer::destroy($playerId);
    }

    public function createPlayer(array $playerDetails, int $user_id, string $actionlog_summary)
    {
        $player = ArdPlayer::create($playerDetails);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $player;
    }

    public function updatePlayer($playerId, array $newPlayerDetails, int $user_id, string $actionlog_summary)
    {
        $player = ArdPlayer::whereId($playerId)->update($newPlayerDetails);

        $player->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $player;
    }
}
