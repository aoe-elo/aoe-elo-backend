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
 * Class LegacyPlayer
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $alias
 * @property int|null $team_id
 * @property string|null $country_key
 * @property int|null $initial_elo_1v1
 * @property int|null $voobly_id
 * @property string|null $steam_id
 * @property string|null $steam_id_failed
 * @property string|null $twitch
 * @property string|null $youtube
 * @property string|null $twitter
 * @property string|null $facebook
 * @property int|null $create_user
 * @property Carbon|null $create_time
 * @property int|null $update_user
 * @property Carbon|null $update_time
 *
 * @package App\Models\Legacy
 */
class LegacyPlayer extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'player';
    public $timestamps = false;

    protected $casts = [
        'team_id' => 'int',
        'initial_elo_1v1' => 'int',
        'voobly_id' => 'int',
        'create_user' => 'int',
        'create_time' => 'datetime',
        'update_user' => 'int',
        'update_time' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'alias',
        'team_id',
        'country_key',
        'initial_elo_1v1',
        'voobly_id',
        'steam_id',
        'steam_id_failed',
        'twitch',
        'youtube',
        'twitter',
        'facebook',
        'create_user',
        'create_time',
        'update_user',
        'update_time'
    ];

    /**
     * Get a migration status for a LegacyPlayer.
     */
    public function migration(): MorphMany
    {
        return $this->morphMany(Migrationlog::class, 'migratory');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(LegacyTeam::class, 'team_id');
    }

    public function create_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'create_user');
    }

    public function update_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'update_user');
    }

    public function infos(): HasMany
    {
        return $this->hasMany(LegacyPlayerInfo::class, 'player');
    }

    public function tournament_results(): HasMany
    {
        return $this->hasMany(LegacyTournamentResult::class, 'player');
    }
}
