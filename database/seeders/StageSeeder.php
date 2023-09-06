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

use App\Models\Stage;
use App\Repositories\ActionlogRepository;
use App\Repositories\UserRepository;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'name' => 'Group Stage',
                'bracket' => 1,
                'default_order' => 2,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'K.O. Phase',
                'bracket' => 1,
                'default_order' => 3,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'K.O. (Loser Bracket)',
                'bracket' => 3,
                'default_order' => 11,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'Quarter-Finals',
                'bracket' => 1,
                'default_order' => 4,
                'weight' => 10,
                'importance' => 2,
            ],

            [
                'name' => 'Semi-Finals',
                'bracket' => 1,
                'default_order' => 5,
                'weight' => 10,
                'importance' => 3,
            ],

            [
                'name' => 'Finale',
                'bracket' => 1,
                'default_order' => 17,
                'weight' => 10,
                'importance' => 4,
            ],

            [
                'name' => 'Grand Finale',
                'bracket' => 1,
                'default_order' => 17,
                'weight' => 10,
                'importance' => 4,
            ],

            [
                'name' => 'First RO4 (Loser Bracket)',
                'bracket' => 3,
                'default_order' => 12,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'Second RO4 (Loser Bracket)',
                'bracket' => 3,
                'default_order' => 13,
                'weight' => 10,
                'importance' => 2,
            ],

            [
                'name' => 'Semi-Finale (Loser Bracket)',
                'bracket' => 3,
                'default_order' => 14,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'Finale (Loser Bracket)',
                'bracket' => 3,
                'default_order' => 15,
                'weight' => 10,
                'importance' => 3,
            ],

            [
                'name' => 'Bronze-Match',
                'bracket' => 1,
                'default_order' => 16,
                'weight' => 10,
                'importance' => 3,
            ],

            [
                'name' => 'Finale (Winner Bracket)',
                'bracket' => 2,
                'default_order' => 10,
                'weight' => 10,
                'importance' => 3,
            ],

            [
                'name' => 'K.O. (Winner Bracket)',
                'bracket' => 2,
                'default_order' => 7,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'Quarter-Finals (Winner Bracket)',
                'bracket' => 2,
                'default_order' => 8,
                'weight' => 10,
                'importance' => 1,
            ],

            [
                'name' => 'Semi-Finals (Winner Bracket)',
                'bracket' => 2,
                'default_order' => 9,
                'weight' => 10,
                'importance' => 1,
            ],
        ];

        $user_id = UserRepository::getUserByName('ada')->id;
        $lookup_service = new LookupService();
        $action = $lookup_service->getActionId('create');

        foreach ($stages as $stage) {
            $stage = Stage::create($stage);
            $stage->action_logs()->create([
                'user_id' => $user_id,
                'action_id' => $action,
                'summary' => 'Created stage ' . $stage->name,
            ]);
        }
    }
}
