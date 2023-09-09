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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// TODO: Add openapi docs for spec: https://vyuldashev.github.io/laravel-openapi/paths/operations.html

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(
    [
        'v1/news' => \App\Http\Controllers\Api\NewsApiController::class,
        'v1/players' => \App\Http\Controllers\Api\PlayerApiController::class,
        'v1/sets' => \App\Http\Controllers\Api\SetApiController::class,
        'v1/teams' => \App\Http\Controllers\Api\TeamApiController::class,
        'v1/tournaments' => \App\Http\Controllers\Api\TournamentApiController::class,
        // 'v1/leaderboards' => \App\Http\Controllers\Api\LeaderboardApiController::class, // TODO!: Implement
    ],
    ['only' => ['index', 'show'], 'as' => 'api']
);

Route::apiResources([
    // 'v1/search' => \App\Http\Controllers\Api\SearchApiController::class, // TODO!: Implement
], ['only' => ['index'], 'as' => 'api']);
