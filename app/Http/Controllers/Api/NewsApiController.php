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
use App\Http\Resources\Api\NewsApiCollection;
use App\Http\Resources\Api\NewsApiResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new NewsApiCollection(News::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return new NewsApiResource(News::with(['action_log'])->findOrFail($news->id, ['*']));
    }
}