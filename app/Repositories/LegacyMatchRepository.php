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

use App\Models\Legacy\LegacyMatch1v1;
use App\Interfaces\SetRepositoryInterface;

class LegacyMatchRepository implements SetRepositoryInterface
{
    public function getAllSets()
    {
        return LegacyMatch1v1::all(['*']);
    }

    public function getSetById($setId)
    {
        return LegacyMatch1v1::findOrFail($setId);
    }

    public function getAllMatchesCursorWithMigration()
    {
        return LegacyMatch1v1::with(['tournament', 'stage', 'migration', 'player1', 'player2'])->cursor();
    }

    public function deleteSet($setId, int $user_id, string $actionlog_summary)
    {
    }

    public function createSet(array $setDetails, int $user_id, string $actionlog_summary)
    {
    }

    public function updateSet($setId, array $newSetDetails, int $user_id, string $actionlog_summary)
    {
    }
}
