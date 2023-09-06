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

namespace App\Console\Commands;

use Database\Seeders\AoeRefDataSeeder;
use Illuminate\Console\Command;

class ImportAoeRefDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-aoe-ref-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from aoe-ref-data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('down');
        (new AoeRefDataSeeder())->run();
        $this->call('up');

        return 0;
    }
}
