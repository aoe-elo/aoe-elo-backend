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
        // Model implementation
        // https://laravel.com/docs/10.x/eloquent-relationships#one-to-many-polymorphic-relations
        Schema::connection('sqlite')->create('set_info', function (Blueprint $table) {
            $table->id();
            $table->integer('score', unsigned: true);
            $table->boolean('is_winner')->default(false);
            $table->integer('adjusted_score', unsigned: true)->comment('the real score without admin win');
            $table->unsignedBigInteger('participatory_id')->comment('the player or team id');
            $table->string('participatory_type', 255)->comment('the model class of Player or Team');
            $table->foreignId('set_id')->constrained(
                table: 'sets',
                indexName: 'set_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['set_id', 'participatory_id', 'participatory_type']);
        });

        Schema::connection('sqlite')->create('sets', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_tie')->default(false);
            $table->boolean('has_admin_win')->default(false);
            $table->dateTime('played_at')->nullable()->default(null)->comment('when this set was played (null=auto from tournament), this is date from old DB');
            $table->boolean('use_played_at_dummy')->default(false); // if we don't have a played at date, we need to derive a date from e.g. tournament date
            $table->integer('best_of', unsigned: true)->nullable()->default(null);
            $table->text('aoe2cm2_civ_draft_link')->nullable()->default(null)->unique();
            $table->text('aoe2cm2_map_draft_link')->nullable()->default(null)->unique();
            $table->foreignId('stageable_id')->nullable()->default(null)->constrained(
                table: 'stageables',
                indexName: 'stageable_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('players', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('current_elo', unsigned: true)->nullable()->default(null);
            $table->integer('base_elo', unsigned: true)->default(1800);
            $table->integer('current_atp', unsigned: true)->nullable()->default(null);
            $table->integer('base_atp', unsigned: true)->default(1800);
            $table->string('voobly_id_main', 25)->nullable()->default(null)->unique();
            $table->string('relic_link_id_main', 30)->nullable()->default(null)->unique();
            $table->string('steam_id_main', 40)->nullable()->default(null)->unique();
            $table->text('liquipedia_handle')->nullable()->default(null)->unique()->comment('e.g. "TheViper" we can use that to collate a player with their login');
            $table->text('discord_handle')->nullable()->default(null)->unique()->comment('e.g. "MembTV" we can use that to collate a player with their login');
            $table->text('twitch_handle')->nullable()->default(null)->unique()->comment('twitch.tv/<twitch_handle> we can use that to collate a player with their login');
            $table->foreignId('aoe_reference_data_player_id')->nullable()->default(null)->constrained(
                table: 'ard_players',
                indexName: 'aoe_reference_data_player_id_idx'
            );
            $table->foreignId('country_id')->nullable()->default(null)->constrained(
                table: 'countries',
                indexName: 'country_id_idx'
            )->comment('was country_key and not foreign');
            $table->foreignId('user_id')->nullable()->default(null)->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'user_id', 'country_id', 'relic_link_id_main', 'steam_id_main']);
        });

        // Table to connect players to teams (many-to-many)
        Schema::connection('sqlite')->create('player_team', function (Blueprint $table) {
            $table->id();
            $table->dateTime('joined_at')->nullable()->default(null);
            $table->dateTime('left_at')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(true);
            $table->foreignId('player_id')->constrained(
                table: 'players',
                indexName: 'player_id_idx'
            );
            $table->foreignId('team_id')->constrained(
                table: 'teams',
                indexName: 'team_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['player_id', 'team_id', 'joined_at', 'left_at']);
        });

        Schema::connection('sqlite')->create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('bracket', unsigned: true)->default(1);
            $table->integer('default_order', unsigned: true)->default(1);
            $table->integer('weight')->default(10)->comment('was float before, convert * 10');
            $table->integer('importance', unsigned: true)->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'bracket', 'default_order', 'weight', 'importance']);
        });

        Schema::connection('sqlite')->create('stageables', function (Blueprint $table) {
            $table->id();
            $table->integer('stage_order', unsigned: true)->nullable()->comment('the order of the stage in the corresponding tournament');
            $table->unsignedBigInteger('stageable_id')->comment('the id of the model');
            $table->string('stageable_type', 255)->comment('the model class');
            $table->foreignId('stage_id')->constrained(
                table: 'stages',
                indexName: 'stage_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['stage_id', 'stageable_id', 'stageable_type']);
        });

        Schema::connection('sqlite')->create('stage_tournament_templates', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('short_name', 100);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'short_name']);
        });

        Schema::connection('sqlite')->create('teams', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('tag', 60);
            $table->integer('current_elo', unsigned: true)->nullable()->default(null);
            $table->integer('base_elo', unsigned: true)->default(1800);
            $table->integer('current_atp', unsigned: true)->nullable()->default(null);
            $table->integer('base_atp', unsigned: true)->default(1800);
            $table->string('primary_color', 30)->nullable()->default(null);
            $table->string('secondary_color', 30)->nullable()->default(null);
            $table->foreignId('aoe_reference_data_team_id')->nullable()->default(null)->constrained(
                table: 'ard_teams',
                indexName: 'aoe_reference_data_team_id_idx'
            );
            $table->foreignId('country_id')->nullable()->default(null)->constrained(
                table: 'countries',
                indexName: 'country_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'tag']);
        });

        Schema::connection('sqlite')->create('atp_categories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category', unsigned: true)->comment("1: 'prize_pool', 2: 'participants', 3: 'invitational', 4: 'settings_restrictions', 5: 'game_mode', 6: 'base_points'");
            $table->text('sub_category');
            $table->integer('base_value', unsigned: true)->nullable()->default(null)->comment('base value for the basepoint sub-categories');
            $table->integer('modifier', unsigned: false)->default(10)->comment('base 10, to not deal with floats, so all values need to be divided by 10, 10 ^= 1.0');
            $table->unique(['category', 'sub_category']);
            $table->timestamps();
        });

        Schema::connection('sqlite')->create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('short_name', 100);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->integer('weight', unsigned: true)->default(1);
            $table->tinyInteger('game_mode', unsigned: true)->default(1)->comment("1: 'rm', 2: 'dm', 3: 'ew', 4: 'other'");
            $table->tinyInteger('format_type', unsigned: true)->default(1)->comment("1: 'duel', 2: 'team', 3: 'mixed', 4: 'other'");
            $table->tinyInteger('event_type', unsigned: true)->default(1)->comment("1: 'cup', 2: 'qualifier', 3: 'other'");
            $table->bigInteger('prize_pool', unsigned: true)->nullable()->default(null)->comment('prize pool amount  in smallest value to circumvent dealing with floats');
            $table->tinyInteger('prize_currency')->default(1)->comment('1: USD, 2: EUR, 3: GBP, 4: Bitcoin, 5: other');
            $table->tinyInteger('structure', unsigned: true)->default(1)->comment("1: 'single elimination', 2: 'double elimination', 3: 'round robin', 4: 'swiss', 5: 'league', 6: 'group', 7: 'group-ko', 8: 'other'");
            $table->string('evaluation', 30)->nullable()->default(null);
            $table->text('website_link')->nullable()->default(null);
            $table->text('liquipedia_link')->nullable()->default(null);
            $table->foreignId('atp_category_id')->nullable()->default(null)->constrained(
                table: 'atp_categories',
                indexName: 'atp_category_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'atp_category_id', 'liquipedia_link', 'short_name']);
        });

        // Special cases for tournaments for tournaments that don't have a normal result
        Schema::connection('sqlite')->create('tournament_results', function (Blueprint $table) {
            $table->id();
            $table->integer('type', unsigned: true)->nullable()->default(null)->comment('1: win, ..., 5: semi-finals, null: other');
            $table->integer('prize_amount')->nullable()->default(null)->comment('money in smallest value to circumvent dealing with floats');
            $table->tinyInteger('prize_currency')->default(1)->comment('1: USD, 2: EUR, 3: GBP, 4: Bitcoin, 5: other');
            $table->text('source')->nullable()->default(null);
            $table->unsignedBigInteger('participatory_id')->comment('the player or team id');
            $table->string('participatory_type', 255)->comment('the model class of Player or Team');
            $table->foreignId('tournament_id')->constrained(
                table: 'tournaments',
                indexName: 'tournament_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('rating_deltas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id')->comment('the player or team id');
            $table->string('participant_type', 255)->comment('the model class of Player or Team');
            $table->foreignId('set_id')->constrained(
                table: 'sets',
                indexName: 'set_id_idx'
            );
            $table->integer('rating_delta', unsigned: false)->default(0);
            $table->dateTime('date_delta');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['participant_id', 'participant_type', 'set_id']);
        });

        Schema::connection('sqlite')->create('rating_checkpoints', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('participant_id')->comment('the player or team id');
            $table->string('participant_type', 255)->comment('the model class of Player or Team');
            $table->integer('rating', unsigned: true)->default(0);
            $table->dateTime('valid_period_start');
            $table->dateTime('valid_period_end');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['participant_id', 'participant_type', 'valid_period_start', 'valid_period_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('sets');
        Schema::connection('sqlite')->dropIfExists('set_info');
        Schema::connection('sqlite')->dropIfExists('players');
        Schema::connection('sqlite')->dropIfExists('player_team');
        Schema::connection('sqlite')->dropIfExists('stages');
        Schema::connection('sqlite')->dropIfExists('teams');
        Schema::connection('sqlite')->dropIfExists('atp_categories');
        Schema::connection('sqlite')->dropIfExists('tournaments');
        Schema::connection('sqlite')->dropIfExists('tournament_results');
        Schema::connection('sqlite')->dropIfExists('rating_deltas');
        Schema::connection('sqlite')->dropIfExists('rating_checkpoints');
        Schema::connection('sqlite')->dropIfExists('stageables');
        Schema::connection('sqlite')->dropIfExists('stage_tournament_templates');
    }
};
