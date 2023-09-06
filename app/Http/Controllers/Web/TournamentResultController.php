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

namespace App\Http\Controllers\Web;

use App\Models\TournamentsResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentResultRequest;
use App\Http\Requests\UpdateTournamentResultRequest;

class TournamentResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentsResult $tournamentResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TournamentsResult $tournamentResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentResultRequest $request, TournamentsResult $tournamentResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TournamentsResult $tournamentResult)
    {
        //
    }
}
