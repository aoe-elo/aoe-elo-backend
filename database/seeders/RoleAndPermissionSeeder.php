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
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds to create roles and permissions.
     */
    public function run(): void
    {
        $permissions = [
            // SuperAdmin permission
            ['name' => 'admin:super'],

            // Debug scoped permissions
            ['name' => 'debug:create'],
            ['name' => 'debug:read'],
            ['name' => 'debug:update'],
            ['name' => 'debug:delete'],

            // User scoped permissions
            ['name' => 'user:create'],
            ['name' => 'user:read'],
            ['name' => 'user:update'],
            ['name' => 'user:delete'],

            // Dashboard scoped permissions
            ['name' => 'dashboard:create'],
            ['name' => 'dashboard:read'],
            ['name' => 'dashboard:update'],
            ['name' => 'dashboard:delete'],

            // Profile scoped permissions
            ['name' => 'profile:create'],
            ['name' => 'profile:read'],
            ['name' => 'profile:update'],
            ['name' => 'profile:delete'],

            // Player scoped permissions
            ['name' => 'player:create'],
            ['name' => 'player:read'],
            ['name' => 'player:update'],
            ['name' => 'player:delete'],

            // Team scoped permissions
            ['name' => 'team:create'],
            ['name' => 'team:read'],
            ['name' => 'team:update'],
            ['name' => 'team:delete'],

            // Tournament scoped permissions
            ['name' => 'tournament:create'],
            ['name' => 'tournament:read'],
            ['name' => 'tournament:update'],
            ['name' => 'tournament:delete'],

            // Match scoped permissions
            ['name' => 'match:create'],
            ['name' => 'match:read'],
            ['name' => 'match:update'],
            ['name' => 'match:delete'],

            // Statistics scoped permissions
            ['name' => 'statistics:create'],
            ['name' => 'statistics:read'],
            ['name' => 'statistics:update'],
            ['name' => 'statistics:delete'],

            // Review scoped permissions
            ['name' => 'review:create'],
            ['name' => 'review:read'],
            ['name' => 'review:update'],
            ['name' => 'review:delete'],

            // News scoped permissions
            ['name' => 'news:create'],
            ['name' => 'news:read'],
            ['name' => 'news:update'],
            ['name' => 'news:delete']
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Super Administrator - No checks.
        $sudoRole = Role::create(['name' => 'sudo']);

        // Administrator - Works directly with the webapp developers and is responsible for overall data integrity and user management.
        $adminRole = Role::create(['name' => 'admin']);

        // Automatic Data Aggregation - A script or bot that pulls data from third-party websites. It's non-human but integral to the system.
        $adaRole = Role::create(['name' => 'ada']);

        // Editor - Journalist with expertise in the AoE II scene. Responsible for adding review, editing player profiles, and ensuring the accuracy of content.
        $editorRole = Role::create(['name' => 'editor']);

        // User - Registered user of the webapp. Uses the dashboard to update their profile and propose changes to the datasets.
        $userRole = Role::create(['name' => 'user']);

        // Tournament Organizer - Organizes local and international AoE II tournaments. Uses the dashboard to update tournament details and results.
        $organizerRole = Role::create(['name' => 'organizer']);

        // Player - Professional AoE II player. Uses the dashboard to update their profile, view their stats and check opponents stats.
        $playerRole = Role::create(['name' => 'player']);

        $sudoRole->givePermissionTo(['admin:super']);

        $adminRole->givePermissionTo([
            'debug:create',
            'debug:read',
            'debug:update',
            'debug:delete',
            'user:create',
            'user:read',
            'user:update',
            'user:delete',
            'player:create',
            'player:read',
            'player:update',
            'player:delete',
            'dashboard:create',
            'dashboard:read',
            'dashboard:update',
            'dashboard:delete',
            'profile:create',
            'profile:read',
            'profile:update',
            'profile:delete',
            'team:create',
            'team:read',
            'team:update',
            'team:delete',
            'tournament:create',
            'tournament:read',
            'tournament:update',
            'tournament:delete',
            'match:create',
            'match:read',
            'match:update',
            'match:delete',
            'review:create',
            'review:read',
            'review:update',
            'review:delete',
            'statistics:create',
            'statistics:read',
            'statistics:update',
            'statistics:delete',
            'news:create',
            'news:read',
            'news:update',
            'news:delete',
        ]);

        $adaRole->givePermissionTo([
            'review:create',
            'review:read',
            'review:update',
            'review:delete', // self
        ]);

        $editorRole->givePermissionTo([
            'dashboard:read',
            'statistics:read',
            'news:read',
            'profile:read', // self
            'profile:update', // self
            'profile:delete', // self
            'player:create',
            'player:read',
            'player:update',
            'player:delete',
            'team:create',
            'team:read',
            'team:update',
            'team:delete',
            'tournament:create',
            'tournament:read',
            'tournament:update',
            'tournament:delete',
            'match:create',
            'match:read',
            'match:update',
            'match:delete',
            'review:create',
            'review:read',
            'review:update',
            'review:delete',
        ]);

        $userRole->givePermissionTo([
            'review:create',
            'player:read',
            'dashboard:read',
            'team:read',
            'tournament:read',
            'match:read',
            'statistics:read',
            'news:read',
            'profile:read', // self
            'profile:update', // self
            'profile:delete', // self
        ]);

        $organizerRole->givePermissionTo([
            'review:create',
            'player:read',
            'dashboard:read',
            'team:read',
            'tournament:create',
            'tournament:read',
            'match:create',
            'match:read',
            'statistics:read',
            'news:read',
            'profile:read', // self
            'profile:update', // self
            'profile:delete', // self
        ]);

        $playerRole->givePermissionTo([
            'review:create',
            'player:create', // self
            'player:read',
            'player:update', // self
            'dashboard:read',
            'team:read',
            'tournament:read',
            'match:read',
            'statistics:read',
            'news:read',
            'profile:read', // self
            'profile:update', // self
            'profile:delete', // self
        ]);

        // no actionlog for this, due to no user still existing an keeping the
        // foreign key constraint for user_id in actionlog table
    }
}
