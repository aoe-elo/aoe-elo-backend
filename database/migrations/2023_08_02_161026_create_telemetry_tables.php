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

// TODO: What is really needed? DSGVO-conformity!
// CREATE TABLE `page_ip_info` (
//   `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
//   `time` datetime NOT NULL,
//   `ip` bigint DEFAULT NULL,
//   `data` text,
//   `longitude` double DEFAULT NULL,
//   `latitude` double DEFAULT NULL,
//   `country` varchar(100) DEFAULT NULL,
//   `country_code` varchar(10) DEFAULT NULL,
//   `city` text,
//   `error` text
// );

// CREATE TABLE `page_visits` (
//   `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
//   `time` datetime NOT NULL,
//   `session_key` varchar(255) DEFAULT NULL,
//   `hash` varchar(100) DEFAULT NULL,
//   `user` int UNSIGNED DEFAULT NULL,
//   `ip` bigint DEFAULT NULL,
//   `ip_info` int UNSIGNED DEFAULT NULL,
//   `domain` varchar(100) DEFAULT NULL,
//   `path` text,
//   `page` varchar(255) DEFAULT NULL,
//   `entity_id` int UNSIGNED DEFAULT NULL
// );

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('sqlite')->create('telemetry', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlite')->dropIfExists('telemetry');
    }
};
