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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TournamentResult
 *
 * @property int|null $id
 * @property int $type
 * @property int $prize_amount
 * @property int|null $prize_currency
 * @property string|null $source
 * @property int|null $participatory_id
 * @property string|null $participatory_type
 * @property int|null $tournament_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Tournament|null $tournament
 *
 * @package App\Models
 */
class TournamentResult extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'tournament_results';

    protected $casts = [
        'type' => 'int',
        'prize_amount' => 'int',
        'prize_currency' => 'int',
        'participatory_id' => 'int',
        'tournament_id' => 'int'
    ];

    protected $fillable = [
        'type',
        'prize_amount',
        'prize_currency',
        'source',
        'participatory_id',
        'participatory_type',
        'tournament_id'
    ];

    /**
     * Get the parent entity model.
     */
    public function participatory(): MorphTo
    {
        return $this->morphTo('participatory');
    }

    /**
     * Get a changelog for a TournamentResult.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    /**
     * Get reviews for a TournamentResult.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
