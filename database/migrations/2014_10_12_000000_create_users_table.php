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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('sqlite')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            // TODO! Merge users with same email from different platforms
            $table->foreignId('discord_user_id')->nullable()->default(null)->constrained(
                table: 'discord_users',
                indexName: 'discord_user_id_idx'
            );
            $table->foreignId('steam_user_id')->nullable()->default(null)->constrained(
                table: 'steam_users',
                indexName: 'steam_user_id_idx'
            );
            $table->foreignId('twitch_user_id')->nullable()->default(null)->constrained(
                table: 'twitch_users',
                indexName: 'twitch_user_id_idx'
            );
            $table->foreignId('github_user_id')->nullable()->default(null)->constrained(
                table: 'github_users',
                indexName: 'github_user_id_idx'
            );
            $table->foreignId('player_id')->nullable()->default(null)->constrained(
                table: 'players',
                indexName: 'player_id_idx'
            );
            $table->foreignId('country_id')->nullable()->default(null)->constrained(
                table: 'countries',
                indexName: 'country_id_idx'
            );
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('users');
    }
};
