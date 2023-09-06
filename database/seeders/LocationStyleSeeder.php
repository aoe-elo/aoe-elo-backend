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

use App\Models\LocationStyle;
use App\Repositories\ActionlogRepository;
use App\Repositories\UserRepository;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id = UserRepository::getUserByName('ada')->id;
        $lookup_service = new LookupService();

        $location_styles = [
            ['style' => 'open', 'weight' => 10],
            ['style' => 'offensive', 'weight' => 10],
            ['style' => 'balanced', 'weight' => 10],
            ['style' => 'closed', 'weight' => 10],
            ['style' => 'defensive', 'weight' => 10],
            ['style' => 'hybrid', 'weight' => 10],
            ['style' => 'water', 'weight' => 10],
            ['style' => 'land', 'weight' => 10],
            ['style' => 'nomad', 'weight' => 10],
            ['style' => 'stone_walls', 'weight' => 10],
            ['style' => 'palisade_walls', 'weight' => 10],
            ['style' => 'no_walls', 'weight' => 10],
        ];

        foreach ($location_styles as $location_style) {
            $created_style = LocationStyle::create($location_style);
            $created_style->action_logs()->create([
                'user_id' => $user_id,
                'action_id' => $lookup_service->getActionId('create'),
                'summary' => 'Created all style ' . $location_style['style'] . ' with weight ' . $location_style['weight'] . '.',
            ]);
        }
    }
}
