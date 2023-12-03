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

use App\Repositories\ActionlogRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_users = ['admin', 'ada', 'sudo'];
        $editor_users = ['mungo', 'uberrushung', 'huleck', 'vale', 'pumukel', 'michaerbse', 'sieste', 'simonsan', 'ghostmonkey', 'lucho'];

        // concatenate arrays

        $initial_users = array_merge($system_users, $editor_users);

        // set up system users
        foreach ($initial_users as $user_name) {
            $user_id = UserRepository::createUser([
                'name' => $user_name,
                'email' => $user_name . '@aoe-elo.com' // TODO! Setup email forwarding
            ]);

            // set roles
            $user = UserRepository::getUserByName($user_name);

            // if username is in ['admin', 'ada', 'sudo'] then assign role $user_name
            // else assign role 'editor'
            if (in_array($user_name, $system_users)) {
                $user->assignRole($user_name);
            } else {
                $user->assignRole('editor');
            }

            // no actionlog for this, due to no user still existing an keeping the
            // foreign key constraint for user_id in actionlog table
        }
    }
}
