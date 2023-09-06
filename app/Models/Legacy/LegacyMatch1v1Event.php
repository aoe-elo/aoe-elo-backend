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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class LegacyMatch1v1Event
 *
 * @property int|null $id
 * @property Carbon|null $date
 * @property Carbon|null $time
 * @property int|null $tournament_id
 * @property int|null $stage_id
 * @property int|null $player_1_id
 * @property int|null $player_2_id
 * @property int|null $bo
 * @property int|null $create_user
 * @property Carbon|null $create_time
 * @property int|null $update_user
 * @property Carbon|null $update_time
 *
 * @package App\Models\Legacy
 */
class LegacyMatch1v1Event extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'match_1v1_event';
    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
        'time' => 'datetime',
        'tournament_id' => 'int',
        'stage_id' => 'int',
        'player_1_id' => 'int',
        'player_2_id' => 'int',
        'bo' => 'int',
        'create_user' => 'int',
        'create_time' => 'datetime',
        'update_user' => 'int',
        'update_time' => 'datetime'
    ];

    protected $fillable = [
        'date',
        'time',
        'tournament_id',
        'stage_id',
        'player_1_id',
        'player_2_id',
        'bo',
        'create_user',
        'create_time',
        'update_user',
        'update_time'
    ];

    /**
     * Get a migration status for a LegacyTeam.
     */
    public function migration(): MorphMany
    {
        return $this->morphMany(Migrationlog::class, 'saved');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(LegacyTournament::class, 'tournament_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(LegacyTournament::class, 'stage_id');
    }

    public function player1(): BelongsTo
    {
        return $this->belongsTo(LegacyPlayer::class, 'player_1_id');
    }

    public function player2(): BelongsTo
    {
        return $this->belongsTo(LegacyPlayer::class, 'player_2_id');
    }

    public function create_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'create_user');
    }

    public function update_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'update_user');
    }
}
