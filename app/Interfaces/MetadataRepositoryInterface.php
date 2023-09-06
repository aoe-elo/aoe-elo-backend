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

interface MetadataRepositoryInterface
{
    public function getAllMetadataEntries();

    public function getAllMetadataEntriesForEntity($entity);

    public function getMetadataEntryById($metadataEntryId);

    public function deleteMetadataEntry($metadataEntryId, int $user_id, string $actionlog_summary);

    public function createMetadataEntry(array $metadataDetails, int $user_id, string $actionlog_summary);

    public function updateMetadataEntry($metadataEntryId, array $newMetadataDetails, int $user_id, string $actionlog_summary);
}
