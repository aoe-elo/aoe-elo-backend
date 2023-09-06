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
 * Class Stageable
 *
 * @property int|null $id
 * @property int $stage_order
 * @property int|null $stageable_id
 * @property string|null $stageable_type
 * @property int|null $stage_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Stage|null $stage
 *
 * @package App\Models
 */
class Stageable extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'stageables';

    protected $casts = [
        'stage_order' => 'int',
        'stageable_id' => 'int',
        'stage_id' => 'int'
    ];

    protected $fillable = [
        'stage_order',
        'stageable_id',
        'stageable_type',
        'stage_id'
    ];

    /**
     * Get a changelog for a Set.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'entity');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Get the stageable's entity.
     *
     * This can be either a Tournament or a StageTournamentTemplate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stageable(): MorphTo
    {
        return $this->morphTo('stageable');
    }
}
