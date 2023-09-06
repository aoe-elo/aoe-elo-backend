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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Performance: SQLITE Speedup for Telescope
        // Read: https://medium.com/swlh/laravel-optimizing-sqlite-to-dangerous-speeds-ff04111b1f22
        // Don't kill the app if the database hasn't been created.
        try {
            DB::connection('sqlite')->statement(
                'PRAGMA synchronous = OFF;'
            );
        } catch (\Throwable $throwable) {
            return;
        }
    }
}
