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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

// TODO!: https://www.cloudways.com/blog/social-login-in-laravel-using-socialite/

class SocialAuthenticationController extends Controller
{
    public function redirectToSocialProvider($socialProvider): void
    {
        match ($socialProvider) {
            'github' => $this->redirectToGitHubProvider(),
            'discord' => $this->redirectToDiscordProvider(),
            'steam' => $this->redirectToSteamProvider(),
            'twitch' => $this->redirectToTwitchProvider(),
            default => abort(404),
        };
    }

    public function handleSocialProviderCallback($socialProvider)
    {
        match ($socialProvider) {
            'github' => $this->handleGitHubProviderCallback(),
            'discord' => $this->handleDiscordProviderCallback(),
            'steam' => $this->handleSteamProviderCallback(),
            'twitch' => $this->handleTwitchProviderCallback(),
            default => abort(404),
        };
    }

    public function redirectToGitHubProvider(): void
    {
        Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect();
    }

    public function redirectToDiscordProvider(): void
    {
        Socialite::driver('discord')->scopes(['identify'])->redirect();
    }

    public function redirectToSteamProvider(): void
    {
        Socialite::driver('steam')->redirect();
    }

    public function redirectToTwitchProvider(): void
    {
        Socialite::driver('twitch')->scopes(['user:read:email'])->redirect();
    }

    public function handleTwitchProviderCallback()
    {
        $user = Socialite::driver('twitch')->user();

        $twitchUser = TwitchUser::updateOrCreate(
            ['twitch_id' => $user->getId()],
            [
                'nickname' => $user->getName(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
            ]
        );

        Auth::login($twitchUser, true);

        return redirect()->route('dashboard');
    }

    public function handleSteamProviderCallback()
    {
        $user = Socialite::driver('steam')->user();

        $steamUser = SteamUser::updateOrCreate(
            ['steam_id' => $user->getId()],
            [
                'nickname' => $user->getNickname(),
                'name' => $user->getName(),
                'avatar' => $user->getAvatar(),
            ]
        );

        Auth::login($steamUser, true);

        return redirect()->route('dashboard');
    }

    public function handleDiscordProviderCallback()
    {
        $user = Socialite::driver('discord')->user();

        $discordUser = DiscordUser::updateOrCreate(
            ['discord_id' => $user->getId()],
            [
                'nickname' => $user->getNickname(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
            ]
        );

        Auth::login($discordUser, true);

        return redirect()->route('dashboard');
    }

    public function handleGitHubProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        $githubUser = GitHubUser::updateOrCreate(
            ['github_id' => $user->getId()],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'github_token' => $user->token,
                'github_refresh_token' => $user->refreshToken,
            ]
        );

        // TODO: User details can also be retrieved from a token, if already available:
        // https://laravel.com/docs/10.x/socialite#retrieving-user-details-from-a-token-oauth2
        // $user = Socialite::driver('github')->userFromToken($token);

        Auth::login($githubUser, true);

        return redirect()->route('dashboard');
    }
}
