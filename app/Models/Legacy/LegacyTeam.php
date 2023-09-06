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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class LegacyTeam
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $tag
 * @property string|null $primary_color
 * @property string|null $secondary_color
 * @property int|null $create_user
 * @property Carbon|null $create_time
 * @property int|null $update_user
 * @property Carbon|null $update_time
 *
 * @package App\Models\Legacy
 */
class LegacyTeam extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'team';
    public $timestamps = false;

    protected $casts = [
        'create_user' => 'int',
        'create_time' => 'datetime',
        'update_user' => 'int',
        'update_time' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'tag',
        'primary_color',
        'secondary_color',
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

    public function players(): HasMany
    {
        return $this->hasMany(LegacyTeamPlayer::class, 'team_id');
    }
}
