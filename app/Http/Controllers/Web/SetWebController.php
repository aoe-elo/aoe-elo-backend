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

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SetWebCollection;
use App\Http\Resources\Web\SetWebResource;
use App\Interfaces\SetRepositoryInterface;
use App\Models\Set;
use App\Http\Requests\StoreSetRequest;
use App\Http\Requests\UpdateSetRequest;

class SetWebController extends Controller
{
    private SetRepositoryInterface $setRepository;

    public function __construct(SetRepositoryInterface $setRepository)
    {
        $this->setRepository = $setRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SetWebCollection($this->setRepository->getAllSets());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Set $set)
    {
        return new SetWebResource($this->setRepository->getSetById($set->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSetRequest $request, Set $set)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Set $set)
    {
        //
    }
}
