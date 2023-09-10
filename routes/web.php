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

use App\Http\Controllers\Web\PlayerWebController;
use App\Http\Controllers\Web\TeamWebController;
use App\Http\Controllers\Web\TournamentWebController;
use App\Http\Controllers\Web\ReviewWebController;
use App\Http\Controllers\Web\NewsWebController;
use App\Http\Controllers\Web\SetWebController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Web\HomeWebController;
use App\Http\Controllers\Web\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TODO: Generate API tokens in Dashboard in Settings Dropdown
// TODO: Use token abilities (OAuth scopes): https://laravel.com/docs/10.x/sanctum#token-abilities
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

// TODO!: Implement authentication with social providers first
// Route::post('/sanctum/token', function (Request $request) {

// $request->validate([
//     'email' => 'required|email',
//     'password' => 'required',
//     'device_name' => 'required',
// ]);

// $user = User::where('email', $request->email)->first();

// if (! $user || ! Hash::check($request->password, $user->password)) {
//     throw ValidationException::withMessages([
//         'email' => ['The provided credentials are incorrect.'],
//     ]);
// }

// return $user->createToken($request->device_name)->plainTextToken;
// });

// TODO: Use gates/policies for authorization to resources:
// https://laravel.com/docs/10.x/authorization#authorizing-actions-via-gates
Route::group(
    ['prefix' => 'v1', 'as' => 'web.v1.', 'middleware' => ['auth:sanctum']],
    function () {
        Route::apiResources([
            '/players' => PlayerWebController::class,
            '/teams' => TeamWebController::class,
            '/tournaments' => TournamentWebController::class,
            '/sets' => SetWebController::class,
            '/reviews' => ReviewWebController::class,
            '/news' => NewsWebController::class,
        ]);
    });

// Dashboard
// Route::get('/dashboard', function () {
// })->middleware(['auth', 'verified'])->name('dashboard');

// Auth

Route::
        namespace('Web')->middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

require __DIR__ . '/auth.php';