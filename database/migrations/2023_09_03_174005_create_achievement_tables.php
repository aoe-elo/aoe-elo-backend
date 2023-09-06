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
        Schema::connection('sqlite')->create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('name_short', 50)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->text('image_path')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'name_short', 'image_path']);
        });

        Schema::connection('sqlite')->create('achievables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievable_id')->comment('the id of the model of the metadata item');
            $table->string('achievable_type', 255)->comment('the model class of the metadata item');
            $table->foreignId('achievement_id')->nullable()->default(null)->constrained(
                table: 'achievements',
                indexName: 'achievement_id_idx'
            );
            $table->boolean('hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['achievement_id', 'achievable_id', 'achievable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('achievements');
        Schema::connection('sqlite')->dropIfExists('achievables');
    }
};
