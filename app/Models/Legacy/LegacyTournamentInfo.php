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
 * Class LegacyTournamentInfo
 *
 * @property int|null $id
 * @property int|null $create_user
 * @property Carbon|null $create_time
 * @property int|null $tournament_id
 * @property int|null $type
 * @property string|null $description
 * @property string|null $value
 *
 * @package App\Models\Legacy
 */
class LegacyTournamentInfo extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'tournament_info';
    public $timestamps = false;

    protected $casts = [
        'create_user' => 'int',
        'create_time' => 'datetime',
        'tournament_id' => 'int',
        'type' => 'int'
    ];

    protected $fillable = [
        'create_user',
        'create_time',
        'tournament_id',
        'type',
        'description',
        'value'
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
        return $this->belongsTo(LegacyTournament::class, 'tournament_id');
    }
}
