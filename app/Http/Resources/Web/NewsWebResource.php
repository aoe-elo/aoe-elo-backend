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

namespace App\Http\Resources\Web;

use App\Repositories\MetadataRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsWebResource extends JsonResource
{
    private $metadata_repo = null;

    public function __construct()
    {
        $this->metadata_repo = new MetadataRepository();

        parent::__construct(...func_get_args());
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
