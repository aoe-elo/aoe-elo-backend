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
     * Run the migrations for the review queue.
     */
    public function up(): void
    {
        Schema::connection('sqlite')->create('reviews', function (Blueprint $table) {
            $table->id();
            $table->json('changes')->comment('JSON encoded content of the changes: ["column": "value", "column2": "value2"]');
            $table->enum('status', ['approved', 'pending', 'flagged', 'wip', 'merged', 'rejected', 'closed', 'draft', 'open', 'stale'])->nullable()->default('open');
            $table->unsignedBigInteger('reviewable_id')->comment('the id of the model of the review item');
            $table->string('reviewable_type', 255)->comment('the model class of the review item');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('reviews');
    }
};
