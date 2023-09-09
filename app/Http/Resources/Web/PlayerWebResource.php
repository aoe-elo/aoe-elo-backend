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
use Nette\Utils\Arrays;

class PlayerWebResource extends JsonResource
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
        $metadata = $this->metadata_repo->getMetadataArrayForEntity($this);

        Arrays::renameKey($metadata, 'alias', 'aliases');

        Arrays::insertBefore($metadata, 'youtube', ['liquipedia' => $this->liquipedia_handle,
            'twitch' => $this->twitch_handle]);

        // $youtube = $this->metadata()->where('key', 'youtube')->first();
        // $yt_link = null;
        // if ($youtube) {
        //     $yt_link = $youtube[$youtube->type_of_value];
        // }

        // $aliases = $this->metadata()->where('key', 'alias')->get();
        // $alias_list = array();
        // foreach ($aliases as $alias) {
        //     $alias_list[] = $alias[$alias->type_of_value];
        // }

        $country = $this->country()->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'aliases' => (! empty($alias_list)) ? $alias_list : null,
            'current_elo' => $this->current_elo,
            'current_atp' => $this->current_atp,
            'country' => (isset($country)) ? [
                'name' => $country['full_name'],
                'iso_3166_2' => $country['iso_3166_2'],
            ] : null,
            'metadata' => $metadata,
        ];
    }
}
