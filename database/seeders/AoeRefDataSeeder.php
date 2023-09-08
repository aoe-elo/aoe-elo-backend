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

use App\Models\Metadata;
use App\Repositories\ActionlogRepository;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\ArdTeamRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MetadataRepository;
use App\Repositories\UserRepository;
use App\Services\Ada\Requests\AoeRefRequest;
use App\Services\ArdProcessorService;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Str;
use App\Utilities\ProgressBar;

class AoeRefDataSeeder extends Seeder
{
    private $pb_width = 70;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_processor = new ArdProcessorService(new ArdPlayerRepository(), new ArdTeamRepository(), new CountryRepository());
        $data_processor->initialImport();
    }
}
