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

interface ReviewRepositoryInterface
{
    public function getAllReviewEntries();

    public function getAllReviewEntriesForEntity($entityId, $entityType);

    public function getReviewEntryById($reviewEntryId);

    public function getReviewEntriesByUserId($userId);

    public function getReviewEntriesByStatus($status);

    public function addCommentToReviewEntry($reviewEntryId, $comment, int $user_id, string $actionlog_summary);

    public function addReviewToQueue($entity, $content, int $user_id, string $actionlog_summary, $comment = null, $status = 'pending');

    public function changeReviewStatus($reviewEntryId, $newStatus, int $user_id, string $actionlog_summary);

    public function approveReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary);

    public function mergeReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary);

    public function deleteReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary);

    public function createReviewEntry(array $reviewDetails, int $user_id, string $actionlog_summary);

    public function updateReviewEntry($reviewEntryId, array $newReviewDetails, int $user_id, string $actionlog_summary);
}
