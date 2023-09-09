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

use App\Models\Metadata;
use App\Interfaces\MetadataRepositoryInterface;
use App\Models\MetadataItem;
use App\Services\LookupService;
use ErrorException;
use Illuminate\Database\Eloquent\Collection;
use Nette\Utils\Arrays;

class MetadataRepository implements MetadataRepositoryInterface
{
    private LookupService $lookupService;

    public function __construct()
    {
        $this->lookupService = new LookupService();
    }

    public function getAllMetadataEntries()
    {
        return Metadata::all(['*']);
    }

    public function getAllMetadataEntriesForEntity($entity): Collection
    {
        $entityId = $entity->id;
        $entityType = $entity->getMorphClass();

        return Metadata::where('metadatable_id', $entityId)->where('metadatable_type', $entityType)->get();
    }

    public function getMetadataArrayForEntity($entity): array
    {
        $metadataArray = [];
        $metadataEntries = $this->getAllMetadataEntriesForEntity($entity);
        $key_count = MetadataRepository::getKeyCountMap($metadataEntries);
        foreach ($metadataEntries as $metadataEntry) {
            if ($key_count[$metadataEntry->key] > 1) {
                $metadataArray[$metadataEntry->key][] = $metadataEntry[$metadataEntry->type_of_value];
            } else {
                $metadataArray[$metadataEntry->key] = $metadataEntry[$metadataEntry->type_of_value];
            }
        }

        return $metadataArray;
    }

    public static function getKeyCountMap(Collection $collection): array
    {
        $key_count = [];
        foreach ($collection as $collection_item) {
            $key = $collection_item->key;
            if (array_key_exists($key, $key_count)) {
                $key_count[$key] += 1;
            } else {
                $key_count[$key] = 1;
            }
        }

        return $key_count;
    }

    public function getMetadataEntryById($metadataEntryId)
    {
        return Metadata::findOrFail($metadataEntryId);
    }

    public function deleteMetadataEntry($metadataEntryId, int $user_id, string $actionlog_summary)
    {
        $metadataEntry = $this->getMetadataEntryById($metadataEntryId);

        $metadataEntry->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('delete'),
            'summary' => $actionlog_summary,
        ]);

        Metadata::destroy($metadataEntryId);
    }

    public function createMetadataEntry(array $metadataDetails, int $user_id, string $actionlog_summary)
    {
        $metadataEntry = Metadata::create($metadataDetails);

        $metadataEntry->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('create'),
            'summary' => $actionlog_summary,
        ]);

        return $metadataEntry;
    }

    public function updateMetadataEntry($metadataEntryId, array $newMetadataDetails, int $user_id, string $actionlog_summary)
    {
        $metadataEntry = Metadata::whereId($metadataEntryId)->update($newMetadataDetails);

        $metadataEntry->action_logs()->create([
            'user_id' => $user_id,
            'action_id' => $this->lookupService->getActionId('update'),
            'summary' => $actionlog_summary,
        ]);

        return $metadataEntry;
    }
}
