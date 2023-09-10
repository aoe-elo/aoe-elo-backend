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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('sqlite')->create('discord_users', function (Blueprint $table) {
            $table->id();
            $table->string('discord_id')->unique();
            $table->string('nickname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->nullable()->default(null)->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'discord_id']);
        });

        Schema::connection('sqlite')->create('steam_users', function (Blueprint $table) {
            $table->id();
            $table->string('steam_id')->unique();
            $table->string('nickname')->nullable();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->nullable()->default(null)->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'steam_id']);
        });

        Schema::connection('sqlite')->create('twitch_users', function (Blueprint $table) {
            $table->id();
            $table->string('twitch_id')->unique();
            $table->string('nickname')->nullable()->comment('same as name');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->nullable()->default(null)->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'twitch_id']);
        });

        Schema::connection('sqlite')->create('github_users', function (Blueprint $table) {
            $table->id();
            $table->string('github_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('github_token')->nullable();
            $table->string('github_refresh_token')->nullable();
            $table->foreignId('user_id')->nullable()->default(null)->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'github_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('discord_users');
        Schema::connection('sqlite')->dropIfExists('steam_users');
        Schema::connection('sqlite')->dropIfExists('twitch_users');
        Schema::connection('sqlite')->dropIfExists('github_users');
    }
};
