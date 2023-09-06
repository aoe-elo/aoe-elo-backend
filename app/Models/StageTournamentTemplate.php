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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StageTournamentTemplate
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $short_name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class StageTournamentTemplate extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'stage_tournament_templates';

    protected $fillable = [
        'name',
        'short_name',
        'description'
    ];

    /**
     * Get a changelog for a StageTournamentTemplate.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get stages for a StageTournamentTemplate.
     */
    public function stages(): MorphToMany
    {
        return $this->morphToMany(Stage::class, Stageable::class, 'stageable')->withPivot('stage_order');
    }

    /**
     * Get reviews for a StageTournamentTemplate.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
