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

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Database\Seeders\LegacyDatabaseSeeder;

class MigrateLegacyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy-data {--pte} {--to} {--se} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from the old database to the new one';

    /**
     * Execute the console command.
     */
    public function handle($function = null)
    {
        $this->call('down');
        (new LegacyDatabaseSeeder())->run([
            'pte' => $this->option('pte') || $this->option('all'),
            'to' => $this->option('to') || $this->option('all'),
            'se' => $this->option('se') || $this->option('all'),
        ]);
        $this->call('up');

        return 0;
    }
}
