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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SetInfo
 *
 * @property int|null $id
 * @property int|null $score
 * @property bool|null $is_winner
 * @property int|null $adjusted_score
 * @property int|null $participatory_id
 * @property string|null $participatory_type
 * @property int|null $set_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Set|null $set
 *
 * @package App\Models
 */
class SetInfo extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'set_info';

    protected $casts = [
        'score' => 'int',
        'is_winner' => 'bool',
        'adjusted_score' => 'int',
        'participatory_id' => 'int',
        'set_id' => 'int'
    ];

    protected $fillable = [
        'score',
        'is_winner',
        'adjusted_score',
        'participatory_id',
        'participatory_type',
        'set_id'
    ];

    /**
     * Get the parent saved model.
     */
    public function participatory(): MorphTo
    {
        return $this->morphTo('participatory');
    }

    /**
     * Get a changelog for a SetInfo.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'set_id');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_set_info')->as('locations')->withTimestamps();
    }

    /**
     * Get reviews for a SetInfo.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
