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
use App\Http\Resources\Api\TeamApiCollection;
use App\Http\Resources\Api\TeamApiResource;
use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamApiController extends Controller
{
    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TeamApiCollection($this->teamRepository->getAllTeamsPaginated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return new TeamApiResource($this->teamRepository->getTeamById($team->id));
    }
}
