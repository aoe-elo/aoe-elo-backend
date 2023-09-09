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

use App\Models\Legacy\LegacyMatch1v1;
use App\Models\Set;
use App\Models\Stage;
use App\Repositories\LegacyMatchRepository;
use App\Repositories\SetRepository;
use App\Services\LegacyProcessorService;
use App\Services\LookupService;
use DateTimeImmutable;
use Illuminate\Support\Facades\Cache;

ini_set('memory_limit', '2048M');

use App\Models\Legacy\LegacyTournament;
use App\Models\Tournament;
use App\Repositories\MetadataRepository;
use App\Utilities\ProgressBar;
use ErrorException;
use App\Models\Migrationlog;
use App\Models\Legacy\LegacyPlayer;
use App\Models\Player;
use App\Models\Team;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\CountryRepository;
use App\Repositories\LegacyPlayerRepository;
use App\Repositories\LegacyTournamentRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\TeamRepository;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Repositories\TournamentRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

// use Illuminate\Database\ConnectionInterface;
// use Illuminate\Database\QueryException;

class LegacyDatabaseSeeder extends Seeder
{
    /**
     * Migrate the legacy data to our new database.
     */
    public function run(array $options): void
    {
        $processor = app()->make(LegacyProcessorService::class);

        match ($options) {
            ['pte' => true, 'to' => false, 'se' => false] => $processor->migratePlayersAndTeams(),
            ['pte' => false, 'to' => true, 'se' => false] => $processor->migrateTournaments(),
            ['pte' => false, 'to' => false, 'se' => true] => $processor->migrateSets(),
            ['pte' => true, 'to' => true, 'se' => true] || ['all' => true] => $processor->migratePlayersAndTeams() && $processor->migrateTournaments() && $processor->migrateSets(),
        };
    }
}
