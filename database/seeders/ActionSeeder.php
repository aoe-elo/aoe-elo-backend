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

use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            [
                'name' => 'create',
                'description' => 'Create a new entry.'
            ],
            [
                'name' => 'update',
                'description' => 'Update an existing entry.'
            ],
            [
                'name' => 'delete',
                'description' => 'Delete an existing entry.'
            ],
            [
                'name' => 'review',
                'description' => 'Review an existing entry.'
            ],
            [
                'name' => 'merge',
                'description' => 'Merge review changes to an existing entry.'
            ],
            [
                'name' => 'status_change',
                'description' => 'Change the status of an existing review entry.'
            ],
            [
                'name' => 'approve',
                'description' => 'Approve review changes to an existing entry.'
            ],
            [
                'name' => 'other',
                'description' => 'Other action.'
            ],
        ];

        foreach ($actions as $action) {
            Action::create($action);
        }
    }
}
