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

interface StageRepositoryInterface
{
    public function getAllStages();

    public function getAllStagesPaginated();

    public function getStageById($stageId);

    public function deleteStage($stageId, int $user_id, string $actionlog_summary);

    public function createStage(array $stageDetails, int $user_id, string $actionlog_summary);

    public function updateStage($stageId, array $newStageDetails, int $user_id, string $actionlog_summary);
}
