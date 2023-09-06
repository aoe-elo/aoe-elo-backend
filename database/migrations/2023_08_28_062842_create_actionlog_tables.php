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
        Schema::connection('sqlite')->create('actionlog', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'user_id_idx'
            );
            $table->foreignId('action_id')->constrained(
                table: 'actions',
                indexName: 'action_id_idx'
            );
            $table->text('summary')->nullable()->default(null);
            $table->unsignedBigInteger('loggable_id')->nullable()->comment('the id of the model that was acted upon');
            $table->string('loggable_type', 255)->comment('the model class that was acted upon');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'loggable_id', 'loggable_type', 'created_at', 'updated_at']);
        });

        Schema::connection('sqlite')->create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description', 255)->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('actionlog');
        Schema::connection('sqlite')->dropIfExists('actions');
    }
};
