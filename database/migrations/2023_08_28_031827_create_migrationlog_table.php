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
        // TODO: Model implementation
        // https://laravel.com/docs/10.x/eloquent-relationships#one-to-many-polymorphic-relations
        Schema::connection('sqlite')->create('migrationlog', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('migratory_id');
            $table->text('migratory_type');
            $table->boolean('save_confirmed')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('migrationlog');
    }
};
