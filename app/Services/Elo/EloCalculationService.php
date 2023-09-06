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

namespace App\Services\Elo;

use App\Repositories\SetRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class EloCalculationService
{
    public function run()
    {
        $sets_repo = new SetRepository();

        $skipped_sets = 0;
        // Get all sets with a datetime
        foreach ($sets_repo->getAllSetsCursorWithRelations() as $set) {
            // skip sets without a datetime
            if (!isset($set->played_at)) {
                Log::debug($set->id . ' has no played_at' . PHP_EOL);
                $skipped_sets++;

                continue;
            }

            $set_items = $set->set_items()->get()->toArray();

            // skip sets without set_items
            if (count($set_items) === 0) {
                Log::debug($set->id . ' has no set_items' . PHP_EOL);
                $skipped_sets++;

                continue;
            }

            // skip sets with less than 2 set_items
            if (count($set_items) < 2) {
                Log::debug($set->id . ' has less than 2 set_items' . PHP_EOL);
                $skipped_sets++;

                continue;
            }

            // skip sets with more than 2 set_items
            if (count($set_items) > 2) {
                Log::debug($set->id . ' has more than 2 set_items' . PHP_EOL);
                $skipped_sets++;

                continue;
            }
        }

        Log::info('Skipped sets during Elo calculation: ' . $skipped_sets . PHP_EOL);

        // Add to cache
        // Cache::add('key', $value, $ttl);
    }

    private function calculateElo()
    {
    }
}
