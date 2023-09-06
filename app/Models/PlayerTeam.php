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

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlayerTeam
 *
 * @property int|null $id
 * @property Carbon $joined_at
 * @property Carbon $left_at
 * @property bool|null $is_active
 * @property int|null $player_id
 * @property int|null $team_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Player|null $player
 * @property Team|null $team
 *
 * @package App\Models
 */
class PlayerTeam extends Pivot
{
    use SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    protected $connection = 'sqlite';
    protected $table = 'player_team';

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'is_active' => 'bool',
        'player_id' => 'int',
        'team_id' => 'int'
    ];

    protected $fillable = [
        'joined_at',
        'left_at',
        'is_active',
        'player_id',
        'team_id'
    ];

    /**
     * Get a migration status for a PlayerTeam relation.
     */
    public function migration(): MorphMany
    {
        return $this->morphMany(Migrationlog::class, 'migratory');
    }

    /**
     * Get a changelog for a PlayerTeam relation.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
