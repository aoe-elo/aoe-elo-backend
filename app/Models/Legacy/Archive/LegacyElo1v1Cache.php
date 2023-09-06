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

namespace App\Models\Legacy\Archive;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyElo1v1Cache
 *
 * @property int|null $id
 * @property Carbon|null $created
 * @property string|null $type
 * @property int $match_id
 * @property int|null $player_id
 * @property int|null $elo_before
 * @property int|null $elo_after
 * @property Carbon|null $match_time
 * @property int $tournament_id
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyElo1v1Cache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'elo_1v1_cache';
    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime',
        'match_id' => 'int',
        'player_id' => 'int',
        'elo_before' => 'int',
        'elo_after' => 'int',
        'match_time' => 'datetime',
        'tournament_id' => 'int'
    ];

    protected $fillable = [
        'created',
        'type',
        'match_id',
        'player_id',
        'elo_before',
        'elo_after',
        'match_time',
        'tournament_id'
    ];
}
