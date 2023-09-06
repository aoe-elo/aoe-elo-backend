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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Stage
 *
 * @property int|null $id
 * @property string|null $name
 * @property int|null $bracket
 * @property int|null $default_order
 * @property int|null $weight
 * @property int|null $importance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Stage extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'stages';

    protected $casts = [
        'bracket' => 'int',
        'default_order' => 'int',
        'weight' => 'int',
        'importance' => 'int'
    ];

    protected $fillable = [
        'name',
        'bracket',
        'default_order',
        'weight',
        'importance'
    ];

    /**
     * Get a changelog for a Stage.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get all of the Tournaments that have this stage.
     */
    public function tournaments(): MorphToMany
    {
        return $this->morphedByMany(Tournament::class, Stageable::class, 'stageable')->withPivot('stage_order');
    }

    /**
     * Get all of the templates that have this stage.
     */
    public function templates(): MorphToMany
    {
        return $this->morphedByMany(StageTournamentTemplate::class, Stageable::class, 'stageable')->withPivot('stage_order');
    }

    /**
     * Get reviews for a Stage.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
