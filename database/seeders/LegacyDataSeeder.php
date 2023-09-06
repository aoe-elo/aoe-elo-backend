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

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class LegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds to import legacy data.
     */
    public function run(): void
    {
        $sql = database_path('export_202308022054.sql');

        // $db = [
        //     'username' => env('DB_USERNAME'),
        //     'password' => env('DB_PASSWORD'),
        //     'host' => env('DB_HOST'),
        //     'database' => env('DB_DATABASE')
        // ];

        $db = database_path('database.sqlite');

        // exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql");
        exec('sqlite3.exe ' . $db . ' < ' . $sql);

        Log::info('SQL Import Done');
    }
}
