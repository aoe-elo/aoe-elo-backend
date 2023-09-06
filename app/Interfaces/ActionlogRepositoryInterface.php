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

interface ActionlogRepositoryInterface
{
    public function getAllActionlogEntries();

    public function getAllActionlogEntriesForEntity($entityId, $entityType);

    public function getActionlogEntryById($actionlogEntryId);

    public function getActionlogEntriesByUserId($userId);

    public function getActionlogEntriesByAction($actionName);

    public function deleteActionlogEntry($actionlogEntryId);

    public function createActionlogEntry(array $actionlogDetails);

    public function updateActionlogEntry($actionlogEntryId, array $newActionlogDetails);
}
