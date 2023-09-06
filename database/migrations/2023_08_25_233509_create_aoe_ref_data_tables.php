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
        Schema::connection('sqlite')->create('ard_players', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('name');
            $table->foreignId('country_id')->nullable()->default(null)->constrained(
                table: 'countries',
                indexName: 'country_id_idx'
            );
            $table->integer('aoeelo_id')->nullable()->default(null)->unique();
            // TODO!: We would need to add our players first in the seeder to make that work, worth?
            // $table->foreignId('aoeelo_id')->nullable()->default(null)->constrained(
            //     table: 'players',
            //     indexName: 'aoeelo_id_idx'
            // );
            $table->integer('esports_earnings')->nullable()->default(null)->unique();
            $table->string('liquipedia_handle')->nullable()->default(null)->unique();
            $table->text('discord_id')->nullable()->default(null)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('ard_player_ard_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ard_player_id')->nullable()->default(null)->constrained(
                table: 'ard_players',
                indexName: 'ard_player_id_idx'
            )->index();
            $table->foreignId('ard_team_id')->nullable()->default(null)->constrained(
                table: 'ard_teams',
                indexName: 'ard_team_id_idx'
            );
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['ard_team_id', 'ard_player_id']);
        });

        Schema::connection('sqlite')->create('ard_teams', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('ard_players');
        Schema::connection('sqlite')->dropIfExists('ard_player_team');
        Schema::connection('sqlite')->dropIfExists('ard_teams');
    }
};
