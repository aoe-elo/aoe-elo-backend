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
        Schema::connection('sqlite')->create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('sub_key')->nullable()->default(null);
            $table->enum('type_of_value', ['boolean_value', 'integer_value', 'smallint_value', 'datetime_value', 'str50_value', 'str100_value', 'str255_value', 'text_value', 'json_value']);
            $table->boolean('boolean_value')->nullable()->default(null);
            $table->integer('integer_value')->nullable()->default(null);
            $table->smallInteger('smallint_value')->nullable()->default(null);
            $table->dateTime('datetime_value')->nullable()->default(null);
            $table->string('str50_value', 50)->nullable()->default(null);
            $table->string('str100_value', 100)->nullable()->default(null);
            $table->string('str255_value', 255)->nullable()->default(null);
            $table->text('text_value')->nullable()->default(null);
            $table->json('json_value')->nullable()->default(null);
            $table->unsignedBigInteger('metadatable_id')->comment('the id of the model of the metadata item');
            $table->string('metadatable_type', 255)->comment('the model class of the metadata item');
            $table->boolean('is_verified')->default(false)->comment('whether the metadata item has been verified by the team');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['metadatable_id', 'metadatable_type', 'key', 'sub_key', 'type_of_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('metadata');
    }
};
