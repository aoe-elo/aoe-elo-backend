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

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function getUserByDiscordId(int $discordId)
    {
        return $this->userRepository->getUserByDiscordId($discordId);
    }

    public function getUserBySteamId(int $steamId)
    {
        return $this->userRepository->getUserBySteamId($steamId);
    }

    public function getUserByTwitchId(int $twitchId)
    {
        return $this->userRepository->getUserByTwitchId($twitchId);
    }

    public function getUserByGitHubId(int $gitHubId)
    {
        return $this->userRepository->getUserByGitHubId($gitHubId);
    }
}
