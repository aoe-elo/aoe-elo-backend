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

use App\Models\AtpCategory;
use App\Repositories\ActionlogRepository;
use App\Repositories\UserRepository;
use App\Services\LookupService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtpCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id = UserRepository::getUserByName('ada')->id;
        $lookup_service = new LookupService();

        $atp_categories = [
            // Prize Pool
            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $100k',
                'base_value' => null,
                'modifier' => intval(10 * 1.2),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $75k',
                'base_value' => null,
                'modifier' => intval(10 * 1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $50k',
                'base_value' => null,
                'modifier' => intval(10 * 0.8),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $30k',
                'base_value' => null,
                'modifier' => intval(10 * 0.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $15k',
                'base_value' => null,
                'modifier' => intval(10 * 0.4),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Greater than $5k',
                'base_value' => null,
                'modifier' => intval(10 * 0.2),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Less than $4k',
                'base_value' => null,
                'modifier' => intval(10 * -0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Less than $1k',
                'base_value' => null,
                'modifier' => intval(10 * -0.4),
            ],

            [
                'category' => LookupService::getAtpCategoryId('prize_pool'),
                'sub_category' => 'Less than $500',
                'base_value' => null,
                'modifier' => intval(10 * -0.8),
            ],

            // Participants

            [
                'category' => LookupService::getAtpCategoryId('participants'),
                'sub_category' => '128 or more',
                'base_value' => null,
                'modifier' => intval(10 * 0.2),
            ],

            [
                'category' => LookupService::getAtpCategoryId('participants'),
                'sub_category' => '64 or more',
                'base_value' => null,
                'modifier' => intval(10 * 0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('participants'),
                'sub_category' => '32 or more',
                'base_value' => null,
                'modifier' => intval(10 * 0),
            ],

            [
                'category' => LookupService::getAtpCategoryId('participants'),
                'sub_category' => '17 or more',
                'base_value' => null,
                'modifier' => intval(10 * -0.4),
            ],

            [
                'category' => LookupService::getAtpCategoryId('participants'),
                'sub_category' => '16 or less',
                'base_value' => null,
                'modifier' => intval(10 * -0.8),
            ],

            // Invitational

            [
                'category' => LookupService::getAtpCategoryId('invitational'),
                'sub_category' => 'No Invites',
                'base_value' => null,
                'modifier' => intval(10 * 0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('invitational'),
                'sub_category' => 'Results',
                'base_value' => null,
                'modifier' => intval(10 * -0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('invitational'),
                'sub_category' => 'Half Invites',
                'base_value' => null,
                'modifier' => intval(10 * -0.3),
            ],

            [
                'category' => LookupService::getAtpCategoryId('invitational'),
                'sub_category' => 'More than Half Invites',
                'base_value' => null,
                'modifier' => intval(10 * -0.5),
            ],

            // Settings & Restrictions

            [
                'category' => LookupService::getAtpCategoryId('settings_restrictions'),
                'sub_category' => 'Single Map',
                'base_value' => null,
                'modifier' => intval(10 * -0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('settings_restrictions'),
                'sub_category' => 'Region Restricted',
                'base_value' => null,
                'modifier' => intval(10 * -0.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('settings_restrictions'),
                'sub_category' => 'Elo Restricted',
                'base_value' => null,
                'modifier' => intval(10 * -0.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('settings_restrictions'),
                'sub_category' => 'Other Restrictions',
                'base_value' => null,
                'modifier' => intval(10 * -0.6),
            ],

            // Game Mode

            [
                'category' => LookupService::getAtpCategoryId('game_mode'),
                'sub_category' => 'Empire Wars',
                'base_value' => null,
                'modifier' => intval(10 * -0.1),
            ],

            [
                'category' => LookupService::getAtpCategoryId('game_mode'),
                'sub_category' => 'Deathmatch',
                'base_value' => null,
                'modifier' => intval(10 * -0.3),
            ],

            // Base Points

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => 'Won',
                'base_value' => 1000,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => 'Rup',
                'base_value' => 750,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => 'SF',
                'base_value' => 500,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => '5-8th',
                'base_value' => 300,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => '9-16th',
                'base_value' => 200,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => '17-32nd',
                'base_value' => 100,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => '33-64th',
                'base_value' => 50,
                'modifier' => intval(10 * 1.6),
            ],

            [
                'category' => LookupService::getAtpCategoryId('base_points'),
                'sub_category' => '65-128th',
                'base_value' => 20,
                'modifier' => intval(10 * 1.6),
            ]
        ];

        foreach ($atp_categories as $atp_category) {
            $created_category = AtpCategory::create($atp_category);
            $created_category->action_logs()->create([
                'user_id' => $user_id,
                'action_id' => $lookup_service->getActionId('create'),
                'summary' => 'Created ATP category ' . $atp_category['category'] . ' with sub-category ' . $atp_category['sub_category'] . ' with base value ' . $atp_category['base_value'] . ' and modifier ' . $atp_category['modifier'] . '.',
            ]);
        }
    }
}
