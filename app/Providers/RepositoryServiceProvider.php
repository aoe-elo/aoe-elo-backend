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

use App\Interfaces\ActionlogRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\LocationRepositoryInterface;
use App\Interfaces\MetadataRepositoryInterface;
use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\ReviewRepositoryInterface;
use App\Interfaces\SetRepositoryInterface;
use App\Interfaces\StageRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Interfaces\TournamentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ActionlogRepository;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\ArdTeamRepository;
use App\Repositories\CountryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\MetadataRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SetRepository;
use App\Repositories\StageRepository;
use App\Repositories\TeamRepository;
use App\Repositories\TournamentRepository;
use App\Repositories\UserRepository;
use App\Services\ArdProcessorService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        ActionlogRepositoryInterface::class => ActionlogRepository::class,
        CountryRepositoryInterface::class => CountryRepository::class,
        LocationRepositoryInterface::class => LocationRepository::class,
        MetadataRepositoryInterface::class => MetadataRepository::class,
        PlayerRepositoryInterface::class => PlayerRepository::class,
        ReviewRepositoryInterface::class => ReviewRepository::class,
        SetRepositoryInterface::class => SetRepository::class,
        StageRepositoryInterface::class => StageRepository::class,
        TeamRepositoryInterface::class => TeamRepository::class,
        TournamentRepositoryInterface::class => TournamentRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        TeamRepositoryInterface::class => ArdTeamRepository::class,
        PlayerRepositoryInterface::class => ArdPlayerRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ArdProcessorService::class)
            ->needs(TeamRepositoryInterface::class)
            ->give(ArdTeamRepository::class);

        $this->app->when(ArdProcessorService::class)
            ->needs(PlayerRepositoryInterface::class)
            ->give(ArdPlayerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
