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

use App\Models\DiscordUser;
use App\Models\GithubUser;
use App\Models\SteamUser;
use App\Models\TwitchUser;
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

    public static function getUserByDiscordId($discordId)
    {
        return DiscordUser::where('discord_id', $discordId)->firstOrFail()->user;
    }

    public static function getUserBySteamId($steamId)
    {
        return SteamUser::where('steam_id', $steamId)->firstOrFail()->user;
    }

    public static function getUserByTwitchId($twitchId)
    {
        return TwitchUser::where('twitch_id', $twitchId)->firstOrFail()->user;
    }

    public static function getUserByGitHubId($githubId)
    {
        return GithubUser::where('github_id', $githubId)->firstOrFail()->user;
    }

    // TODO!: https://laravel.com/docs/10.x/eloquent#upserts
    public static function createNewUserFromDiscordId()
    {
    }

    public static function createNewUserFromGithubId()
    {
    }

    public static function createNewUserFromTwitchId()
    {
    }

    public static function createNewUserFromSteamId()
    {
    }
}
