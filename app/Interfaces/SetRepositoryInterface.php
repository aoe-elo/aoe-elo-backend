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

interface SetRepositoryInterface
{
    public function getAllSets();

    public function getAllSetsPaginated();

    public function getSetById($setId);

    public function deleteSet($setId, int $user_id, string $actionlog_summary);

    public function createSet(array $setDetails, int $user_id, string $actionlog_summary);

    public function updateSet($setId, array $newSetDetails, int $user_id, string $actionlog_summary);
}
