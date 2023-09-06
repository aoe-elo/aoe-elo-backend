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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class LegacyTournament
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $short
 * @property Carbon|null $start
 * @property Carbon|null $end
 * @property int|null $weight
 * @property string|null $type
 * @property int|null $prizemoney
 * @property int|null $parent_id
 * @property string|null $structure
 * @property string|null $evaluation
 * @property string|null $website
 * @property string|null $comment
 * @property int|null $create_user
 * @property Carbon|null $create_time
 * @property int|null $update_user
 * @property Carbon|null $update_time
 *
 * @package App\Models\Legacy
 */
class LegacyTournament extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'tournament';
    public $timestamps = false;

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'weight' => 'int',
        'prizemoney' => 'int',
        'parent_id' => 'int',
        'create_user' => 'int',
        'create_time' => 'datetime',
        'update_user' => 'int',
        'update_time' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'short',
        'start',
        'end',
        'weight',
        'type',
        'prizemoney',
        'parent_id',
        'structure',
        'evaluation',
        'website',
        'comment',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(LegacyTournament::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(LegacyTournament::class, 'parent_id');
    }

    public function tournament_info(): HasMany
    {
        return $this->hasMany(LegacyTournamentInfo::class, 'tournament_id');
    }

    public function tournament_results(): HasMany
    {
        return $this->hasMany(LegacyTournamentResult::class, 'tournament');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(LegacyMatch1v1::class, 'tournament_id');
    }
}
