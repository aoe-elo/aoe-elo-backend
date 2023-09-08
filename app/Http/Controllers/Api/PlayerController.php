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
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayerCollection;
use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    private PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PlayerCollection($this->playerRepository->getAllPlayersPaginated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new PlayerResource($this->playerRepository->getPlayerById($id));
    }
}
