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

use App\Models\Review;
use App\Interfaces\ReviewRepositoryInterface;
use App\Services\LookupService;

class ReviewRepository implements ReviewRepositoryInterface
{
    private LookupService $lookupService;

    public function __construct(LookupService $lookupService)
    {
        $this->lookupService = $lookupService;
    }

    public function getAllReviewEntries()
    {
        return Review::all(['*']);
    }

    public function getAllReviewEntriesForEntity($entityId, $entityType)
    {
        return Review::where('reviewable_id', $entityId)->where('reviewable_type', $entityType)->get();
    }

    public function getReviewEntryById($reviewEntryId)
    {
        return Review::with(['metadata', 'action_logs'])->findOrFail($reviewEntryId);
    }

    public function getReviewEntriesByUserId($userId)
    {
        // TODO: Implement getReviewEntriesByUserId() method.
        // user is saved in actionlogs table
        // return Review::where('user_id', $userId)->get();
    }

    public function getReviewEntriesByStatus($status)
    {
        return Review::where('status', $status)->get();
    }

    public function addCommentToReviewEntry($reviewEntryId, $comment, int $user_id, string $actionlog_summary)
    {
        $review = $this->getReviewEntryById($reviewEntryId);

        $type = 'text_value';
        $review->metadata()->create([
            'key' => 'comment',
            'type_of_value' => $type,
            $type => $comment,
        ]);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);
    }

    public function addReviewToQueue($entity, $content, int $user_id, string $actionlog_summary, $comment = null, $status = 'open')
    {
        $review = $entity->reviews()->create([
            'changes' => json_encode($content),
            'status' => $status,
        ]);

        if ($comment) {
            $type = 'text_value';
            $review->metadata()->create([
                'key' => 'comment',
                'type_of_value' => $type,
                $type => $comment,
            ]);
        }

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $review;
    }

    public function approveReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary)
    {
        $review = $this->getReviewEntryById($reviewEntryId);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('approve'),
            'summary' => $actionlog_summary,
        ]);

        $review->reviewable->update($review->changes);

        $this->changeReviewStatus($reviewEntryId, 'approved', $user_id, $actionlog_summary);
    }

    public function mergeReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary)
    {
        $review = $this->getReviewEntryById($reviewEntryId);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('merge'),
            'summary' => $actionlog_summary,
        ]);

        $review->reviewable->update($review->changes);

        $this->changeReviewStatus($reviewEntryId, 'merged', $user_id, $actionlog_summary);
    }

    public function changeReviewStatus($reviewEntryId, $newStatus, int $user_id, string $actionlog_summary)
    {
        $review = $this->getReviewEntryById($reviewEntryId);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('status_change'),
            'summary' => $actionlog_summary,
        ]);

        $review->update(['status' => $newStatus]);
    }

    public function deleteReviewEntry($reviewEntryId, int $user_id, string $actionlog_summary)
    {
        $review = $this->getReviewEntryById($reviewEntryId);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        $review->metadata()->delete();

        Review::destroy($reviewEntryId);
    }

    public function createReviewEntry(array $reviewDetails, int $user_id, string $actionlog_summary)
    {
        $review = Review::create($reviewDetails);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('review'),
            'summary' => $actionlog_summary,
        ]);

        return $review;
    }

    public function updateReviewEntry($reviewEntryId, array $newReviewDetails, int $user_id, string $actionlog_summary)
    {
        $review = Review::whereId($reviewEntryId)->update($newReviewDetails);

        $review->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $review;
    }
}
