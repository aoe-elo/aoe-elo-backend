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

use App\Models\Migrationlog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class LegacyTournamentResult
 *
 * @property int|null $id
 * @property int|null $tournament
 * @property int|null $player
 * @property int|null $type
 * @property int|null $money
 * @property string|null $source
 * @property Carbon|null $create_time
 * @property int|null $create_user
 *
 * @package App\Models\Legacy
 */
class LegacyTournamentResult extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'tournament_result';
    public $timestamps = false;

    protected $casts = [
        'tournament' => 'int',
        'player' => 'int',
        'type' => 'int',
        'money' => 'int',
        'create_time' => 'datetime',
        'create_user' => 'int'
    ];

    protected $fillable = [
        'tournament',
        'player',
        'type',
        'money',
        'source',
        'create_time',
        'create_user'
    ];

    /**
     * Get a migration status for a LegacyTeam.
     */
    public function migration(): MorphMany
    {
        return $this->morphMany(Migrationlog::class, 'migratory');
    }

    public function create_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'create_user');
    }

    public function update_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'update_user');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(LegacyTournament::class, 'tournament');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(LegacyPlayer::class, 'player');
    }
}
