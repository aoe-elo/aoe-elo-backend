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

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentResource;
use App\Interfaces\TournamentRepositoryInterface;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    private TournamentRepositoryInterface $tournamentRepository;

    public function __construct(TournamentRepositoryInterface $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TournamentResource::collection($this->tournamentRepository->getAllTournamentsPaginated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TournamentResource($this->tournamentRepository->getTournamentById($id));
    }
}
