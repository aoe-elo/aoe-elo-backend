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

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public static function getAllUsers();

    public static function getUserById($userId);

    public static function getUserByName($userName);

    public static function deleteUser($userId);

    public static function createUser(array $userDetails);

    public static function updateUser($userId, array $newUserDetails);
}
