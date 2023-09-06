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

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public static function getAllUsers()
    {
        return User::all(['*']);
    }

    public static function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public static function getUserByName($userName)
    {
        return User::where('name', $userName)->firstOrFail();
    }

    public static function deleteUser($userId)
    {
        User::destroy($userId);
    }

    public static function createUser(array $UserDetails)
    {
        return User::create($UserDetails);
    }

    public static function updateUser($userId, array $newUserDetails)
    {
        return User::whereId($userId)->update($newUserDetails);
    }
}
