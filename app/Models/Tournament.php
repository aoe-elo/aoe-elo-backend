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
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tournament
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $short_name
 * @property Carbon $started_at
 * @property Carbon $ended_at
 * @property int|null $weight
 * @property int|null $game_mode
 * @property int|null $format_type
 * @property int|null $event_type
 * @property int $prize_pool
 * @property int|null $prize_currency
 * @property int|null $structure
 * @property string $evaluation
 * @property string $website_link
 * @property string $liquipedia_link
 * @property int|null $atp_category_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property AtpCategory|null $atp_category
 *
 * @package App\Models
 */
class Tournament extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'tournaments';

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'weight' => 'int',
        'game_mode' => 'int',
        'format_type' => 'int',
        'event_type' => 'int',
        'prize_pool' => 'int',
        'prize_currency' => 'int',
        'structure' => 'int',
        'atp_category_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'short_name',
        'started_at',
        'ended_at',
        'weight',
        'game_mode',
        'format_type',
        'event_type',
        'prize_pool',
        'prize_currency',
        'structure',
        'evaluation',
        'website_link',
        'liquipedia_link',
        'atp_category_id'
    ];

    /**
     * Get all of the Tournament's metadata.
     */
    public function metadata(): MorphMany
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }

    /**
     * Get a changelog for a Tournament.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get stages for a Tournament.
     */
    public function stages(): MorphToMany
    {
        return $this->morphToMany(Stage::class, 'stageable')->withPivot(['id', 'stage_order'])->as('stage_connector');
    }

    public function atp_category(): BelongsTo
    {
        return $this->belongsTo(AtpCategory::class, 'atp_category_id');
    }

    // TODO!: Has many players/teams, how to get all players of a tournament?

    public function results(): HasMany
    {
        return $this->hasMany(TournamentResult::class, 'tournament_id');
    }

    /**
     * Get reviews for a Tournament.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
