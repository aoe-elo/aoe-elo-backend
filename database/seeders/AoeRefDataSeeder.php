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

namespace Database\Seeders;

use App\Services\ArdProcessorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AoeRefDataSeeder extends Seeder
{
    private $pb_width = 70;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->make(ArdProcessorService::class)->initialImport();
    }
}
