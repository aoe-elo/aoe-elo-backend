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

namespace App\Providers;

use App\Repositories\ActionlogRepository;
use App\Repositories\TeamRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StageRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\TournamentRepository;
use App\Interfaces\TeamRepositoryInterface;
use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\TournamentRepositoryInterface;
use App\Interfaces\StageRepositoryInterface;
use App\Interfaces\ActionlogRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\LocationRepositoryInterface;
use App\Interfaces\MetadataRepositoryInterface;
use App\Interfaces\ReviewRepositoryInterface;
use App\Interfaces\SetRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CountryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\MetadataRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SetRepository;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ActionlogRepositoryInterface::class, ActionlogRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(MetadataRepositoryInterface::class, MetadataRepository::class);
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(SetRepositoryInterface::class, SetRepository::class);
        $this->app->bind(StageRepositoryInterface::class, StageRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(TournamentRepositoryInterface::class, TournamentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
