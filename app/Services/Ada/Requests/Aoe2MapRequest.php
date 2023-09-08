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

namespace App\Services\Ada\Requests;

use Illuminate\Support\Facades\Http;

class Aoe2MapRequest
{
    private string $url_maps = 'https://aoe2map.net/api/allmaps';

    public function fetch(): object
    {
        $maps = Http::get($this->url_maps)->object();

        return $maps;
    }
}
