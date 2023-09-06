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
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Team
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $tag
 * @property int|null $current_elo
 * @property int|null $base_elo
 * @property int|null $current_atp
 * @property int|null $base_atp
 * @property string|null $primary_color
 * @property string|null $secondary_color
 * @property int|null $aoe_reference_data_team_id
 * @property int|null $country_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property ArdTeam $ard_team
 * @property Country $country
 *
 * @package App\Models
 */
class Team extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'teams';

    protected $casts = [
        'current_elo' => 'int',
        'base_elo' => 'int',
        'current_atp' => 'int',
        'base_atp' => 'int',
        'aoe_reference_data_team_id' => 'int',
        'country_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'tag',
        'current_elo',
        'base_elo',
        'current_atp',
        'base_atp',
        'primary_color',
        'secondary_color',
        'aoe_reference_data_team_id',
        'country_id'
    ];

    /**
     * Get a changelog for a Team.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get all of the team's played sets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function set_items(): MorphMany
    {
        return $this->morphMany(SetInfo::class, 'participatory');
    }

    /**
     * Get a tournament results for a Team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tournament_results(): MorphMany
    {
        return $this->morphMany(TournamentResult::class, 'participatory');
    }

    /**
     * Get a achievements for a Player.
     */
    public function achievements(): MorphToMany
    {
        return $this->morphToMany(Achievement::class, 'achievable')->withPivot('hidden');
    }

    /**
     * Get the Players for a Team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->using(PlayerTeam::class)->as('players')->withTimestamps();
    }

    /**
     * Get the ArdTeam for a Team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ard_team(): BelongsTo
    {
        return $this->belongsTo(ArdTeam::class, 'aoe_reference_data_team_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get reviews for a Team.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
