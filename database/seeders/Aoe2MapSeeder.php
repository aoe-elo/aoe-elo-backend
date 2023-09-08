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

namespace Database\Seeders;

use App\Models\Aoe2Map\Aoe2MapRms;
use App\Models\Location;
use App\Models\LocationStyle;
use App\Models\Metadata;
use App\Repositories\ActionlogRepository;
use App\Repositories\ArdPlayerRepository;
use App\Repositories\ArdTeamRepository;
use App\Repositories\CountryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\MetadataRepository;
use App\Repositories\UserRepository;
use App\Services\Ada\Requests\Aoe2MapRequest;
use App\Services\Ada\AoeRefRequest;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Str;
use App\Utilities\ProgressBar;
use Illuminate\Support\Collection;

class Aoe2MapSeeder extends Seeder
{
    private $pb_width = 70;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Old approach using aoe2map.net
        // $req = new Aoe2MapRequest();
        // $maps = ($req->fetch())['allmaps'];
        $maps = Aoe2MapRms::with(['tags'])->cursor();

        $lookup_service = new LookupService();

        $location_repo = new LocationRepository();
        $user_id = UserRepository::getUserByName('ada')->id;

        $maps_count = $maps->count();

        $pb_count = 0;
        foreach ($maps as $map) {
            $pb = ProgressBar::render($pb_count, $maps_count, 'Adding map: ' . $map->name, $this->pb_width ?? 50);
            echo $pb;

            $map_name_lowercase = strtolower($map->name);

            $styles = [];
            $tags = $map->tags->pluck('name');

            $location = $location_repo->createLocation([
                'name' => $map->name,
                // 'name_short' => $map['name_short'],
                // 'liquipedia_link' => $map['liquipedia_link'],
                'aoe2map_link' => 'https://aoe2map.net/map/' . $map->uuid,
                'aoe2map_uuid' => $map->uuid,
                'keywords' => json_encode($tags),
            ], $user_id, 'Added map: ' . $map->name . ' from aoe2map.net');

            $tag_collection = collect($tags);

            $tag_collection->map(function ($tag) {
                return strtolower($tag);
            });

            if ($tag_collection->contains('closed')) {
                array_push($styles, 'closed');
            }

            if ($tag_collection->contains('open')) {
                array_push($styles, 'open');
            }

            if ($tag_collection->contains('hybrid')) {
                array_push($styles, 'hybrid');
            }

            if ($tag_collection->contains('land')) {
                array_push($styles, 'land');
            }

            if ($tag_collection->contains('water')) {
                array_push($styles, 'water');
            }

            if ($tag_collection->contains('nomad') || $tag_collection->contains('migration')) {
                array_push($styles, 'nomad');
            }

            if ($tag_collection->contains('lake')) {
                array_push($styles, 'hybrid');
            }

            if ($tag_collection->contains('arena') || $tag_collection->contains('fortress')) {
                array_push($styles, 'closed', 'defensive', 'land', 'stone_walls');
            }

            if ($tag_collection->contains('aggressive')) {
                array_push($styles, 'offensive');
            }

            if (
                str_contains($map_name_lowercase, 'nomad')
                || str_contains($map_name_lowercase, 'steppe')
                || str_contains($map_name_lowercase, 'migration')
            ) {
                array_push($styles, 'nomad');
            }

            if (str_contains($map_name_lowercase, 'arabia')) {
                array_push($styles, 'open', 'offensive', 'land', 'no_walls');
            } elseif (
                str_contains($map_name_lowercase, 'hideout')
                || str_contains($map_name_lowercase, 'palisade')
            ) {
                array_push($styles, 'closed', 'defensive', 'land', 'palisade_walls');
            } elseif (
                str_contains($map_name_lowercase, 'arena')
                || str_contains($map_name_lowercase, 'fortress')
            ) {
                array_push($styles, 'stone_walls', 'defensive', 'closed', 'land');
            }

            if (str_contains($map_name_lowercase, 'land')) {
                array_push($styles, 'land');
            }

            if (
                str_contains($map_name_lowercase, 'water')
                || str_contains($map_name_lowercase, 'island')
            ) {
                array_push($styles, 'water');
            }

            if (
                str_contains($map_name_lowercase, 'hybrid')
                || str_contains($map_name_lowercase, 'pond')
                || str_contains($map_name_lowercase, 'lake')
                || str_contains($map_name_lowercase, 'shallow')
            ) {
                array_push($styles, 'hybrid');
            }

            $styles = array_unique($styles, SORT_STRING);

            foreach ($styles as $style) {
                $location->location_styles()->attach($lookup_service->getLocationStyleId($style));
            }

            $pb_count++;
        }

        echo "\rInsertion of maps complete.\n";
    }
}
