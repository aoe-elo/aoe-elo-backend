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
        Schema::connection('sqlite')->create('cache_most_visited', function (Blueprint $table) {
            $table->id();
            $table->string('page', 100);
            $table->integer('entity_id', unsigned: true)->nullable();
            $table->integer('visits', unsigned: true);
            $table->timestamps();
        });

        // TODO: Ask mungo what this table is for
        Schema::connection('sqlite')->create('meta_cache', function (Blueprint $table) {
            $table->id();
            $table->integer('name');
            $table->integer('value_int');
            $table->float('value_float');
            $table->text('value_str');
        });

        Schema::connection('sqlite')->create('elo_1v1_cache', function (Blueprint $table) {
            $table->id();
            $table->string('type', 255)->default('match');
            $table->integer('elo_before', unsigned: true);
            $table->integer('elo_after', unsigned: true);
            $table->dateTime('match_time')->comment('redundant'); // was `date` type before
            $table->foreignId('player_id')->constrained(
                table: 'players',
                indexName: 'player_id_idx'
            );
            $table->foreignId('tournament_id')->nullable()->default(null)->constrained(
                table: 'tournaments',
                indexName: 'tournament_id_idx'
            );
            $table->foreignId('set_id')->nullable()->default(null)->constrained(
                table: 'sets',
                indexName: 'set_id_idx'
            );
            $table->timestamps(); // was included in `created` before
        });

        Schema::connection('sqlite')->create('extern_de_cache', function (Blueprint $table) {
            $table->id();
            $table->string('relic_link_id', 30)->nullable()->default(null); // was steam_id before
            $table->integer('rating', unsigned: true);
            $table->integer('rank', unsigned: true);
            $table->timestamps();
        });

        Schema::connection('sqlite')->create('extern_voobly_cache', function (Blueprint $table) {
            $table->id();
            $table->integer('voobly_id', unsigned: true);
            $table->integer('ladder', unsigned: true)->default(1)->comment('1: rm 1v1');
            $table->integer('rating', unsigned: true);
            $table->integer('rank', unsigned: true)->nullable()->default(null);
            $table->timestamps();
        });

        Schema::connection('sqlite')->create('extern_voobly_player_cache', function (Blueprint $table) {
            $table->id();
            $table->integer('voobly_id', unsigned: true);
            $table->integer('rm_1v1', unsigned: true);
            $table->integer('rm_tg', unsigned: true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('cache_most_visited');
        Schema::connection('sqlite')->dropIfExists('meta_cache');
        Schema::connection('sqlite')->dropIfExists('elo_1v1_cache');
        Schema::connection('sqlite')->dropIfExists('extern_de_cache');
        Schema::connection('sqlite')->dropIfExists('extern_voobly_cache');
        Schema::connection('sqlite')->dropIfExists('extern_voobly_player_cache');
    }
};
