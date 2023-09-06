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
 * Class LegacyPlayerInfo
 *
 * @property int|null $id
 * @property int|null $player
 * @property string|null $type
 * @property int|null $value_int
 * @property string|null $value_str
 * @property Carbon|null $create_time
 * @property int|null $create_user
 *
 * @package App\Models\Legacy
 */
class LegacyPlayerInfo extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'player_info';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'player' => 'int',
        'value_int' => 'int',
        'create_time' => 'datetime',
        'create_user' => 'int'
    ];

    protected $fillable = [
        'id',
        'player',
        'type',
        'value_int',
        'value_str',
        'create_time',
        'create_user'
    ];

    /**
     * Get a migration status for a LegacyPlayerInfo.
     */
    public function migration(): MorphMany
    {
        return $this->morphMany(Migrationlog::class, 'migratory');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(LegacyPlayer::class, 'player');
    }

    public function create_user(): BelongsTo
    {
        return $this->belongsTo(LegacyUser::class, 'create_user');
    }
}
