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
        Schema::connection('sqlite')->create('location_set_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_info_id')->nullable()->default(null)->constrained(
                table: 'set_info',
                indexName: 'set_info_id_idx'
            );
            $table->foreignId('location_id')->nullable()->default(null)->constrained(
                table: 'locations',
                indexName: 'location_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('name_short', 50)->nullable()->default(null);
            $table->text('liquipedia_link')->nullable()->default(null);
            $table->text('aoe2map_link')->nullable()->default(null);
            $table->string('aoe2map_uuid', 50)->nullable()->default(null);
            $table->text('image_path')->nullable()->default(null);
            $table->text('preview_image_path')->nullable()->default(null);
            $table->json('keywords')->nullable()->comment('json array of applicable keywords for auto-categorization to search for, e.g. arabia: ["arab"]');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'name_short', 'image_path', 'preview_image_path']);
        });

        Schema::connection('sqlite')->create('location_location_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->default(null)->constrained(
                table: 'locations',
                indexName: 'location_id_idx'
            );
            $table->foreignId('location_style_id')->nullable()->default(null)->constrained(
                table: 'location_styles',
                indexName: 'location_style_id_idx'
            );
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['location_id', 'location_style_id']);
        });

        Schema::connection('sqlite')->create('location_styles', function (Blueprint $table) {
            $table->id();
            $table->string('style', 100)->comment('"open", "aggressive", "balanced", "closed", "defensive", "hybrid", "water", "nomad"');
            $table->integer('weight')->unsigned()->nullable()->default(10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('locations');
        Schema::connection('sqlite')->dropIfExists('location_set_info');
        Schema::connection('sqlite')->dropIfExists('location_location_styles');
        Schema::connection('sqlite')->dropIfExists('location_styles');
    }
};
