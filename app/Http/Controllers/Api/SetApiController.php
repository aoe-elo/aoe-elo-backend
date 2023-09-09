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
use App\Http\Resources\Api\SetApiCollection;
use App\Http\Resources\Api\SetApiResource;
use App\Models\Set;
use Illuminate\Http\Request;

class SetApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SetApiCollection(Set::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Set $set)
    {
        return new SetApiResource(Set::with(['set_items', 'stageable'])->findOrFail($set->id, ['*']));
    }
}
