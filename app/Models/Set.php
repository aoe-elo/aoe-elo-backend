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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Set
 *
 * @property int|null $id
 * @property bool|null $is_tie
 * @property bool|null $has_admin_win
 * @property Carbon $played_at
 * @property bool|null $use_played_at_dummy
 * @property int|null $best_of
 * @property string|null $aoe2cm2_civ_draft_link
 * @property string|null $aoe2cm2_map_draft_link
 * @property int $stageable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Stageable $stageable
 *
 * @package App\Models
 */
class Set extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'sets';

    protected $casts = [
        'is_tie' => 'bool',
        'has_admin_win' => 'bool',
        'played_at' => 'datetime',
        'use_played_at_dummy' => 'bool',
        'best_of' => 'int',
        'stageable_id' => 'int'
    ];

    protected $fillable = [
        'is_tie',
        'has_admin_win',
        'played_at',
        'use_played_at_dummy',
        'best_of',
        'aoe2cm2_civ_draft_link',
        'aoe2cm2_map_draft_link',
        'stageable_id'
    ];

    /**
     * Get a changelog for a Set.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function set_items(): HasMany
    {
        return $this->hasMany(SetInfo::class, 'set_id');
    }

    public function stageable(): BelongsTo
    {
        return $this->belongsTo(Stageable::class);
    }

    /**
     * Get reviews for a Set.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
