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

namespace App\Models\Legacy;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlayerCache
 *
 * @property int $id
 * @property int $player_id
 * @property int|null $num_matches
 * @property int|null $num_wins
 * @property int|null $num_games
 * @property string|null $tournament_ids
 * @property int|null $last_match
 * @property Carbon|null $last_match_time
 * @property int|null $rank
 * @property int|null $elo
 * @property Carbon|null $elo_update
 * @property int|null $elo_peak
 * @property int|null $de_elo
 * @property int|null $de_rank
 * @property Carbon|null $de_update
 * @property int|null $voobly_elo
 * @property int|null $voobly_rank
 * @property Carbon|null $voobly_update
 *
 * @package App\Models\Legacy
 */
class LegacyPlayerCache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'player_cache';
    public $timestamps = false;

    protected $casts = [
        'player_id' => 'int',
        'num_matches' => 'int',
        'num_wins' => 'int',
        'num_games' => 'int',
        'last_match' => 'int',
        'last_match_time' => 'datetime',
        'rank' => 'int',
        'elo' => 'int',
        'elo_update' => 'datetime',
        'elo_peak' => 'int',
        'de_elo' => 'int',
        'de_rank' => 'int',
        'de_update' => 'datetime',
        'voobly_elo' => 'int',
        'voobly_rank' => 'int',
        'voobly_update' => 'datetime'
    ];

    protected $fillable = [
        'player_id',
        'num_matches',
        'num_wins',
        'num_games',
        'tournament_ids',
        'last_match',
        'last_match_time',
        'rank',
        'elo',
        'elo_update',
        'elo_peak',
        'de_elo',
        'de_rank',
        'de_update',
        'voobly_elo',
        'voobly_rank',
        'voobly_update'
    ];
}
