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

use Illuminate\Support\Collection;

interface DataProcessingInterface
{
    /**
     * @param Collection $data
     * @return void
     */
    public function processData(): void;

    public function collectData(): void;

    public function storeData(): void;

    public function transformData(): void;
}
