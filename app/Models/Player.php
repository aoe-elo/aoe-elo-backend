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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Player
 *
 * @property int|null $id
 * @property string $name
 * @property int|null $current_elo
 * @property int|null $base_elo
 * @property int|null $current_atp
 * @property int|null $base_atp
 * @property string|null $voobly_id_main
 * @property string|null $relic_link_id_main
 * @property string|null $steam_id_main
 * @property string|null $liquipedia_handle
 * @property string|null $discord_handle
 * @property string|null $twitch_handle
 * @property int|null $aoe_reference_data_player_id
 * @property int|null $country_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property ArdPlayer $ard_player
 * @property Country $country
 *
 * @package App\Models
 */
class Player extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'players';

    protected $casts = [
        'current_elo' => 'int',
        'base_elo' => 'int',
        'current_atp' => 'int',
        'base_atp' => 'int',
        'aoe_reference_data_player_id' => 'int',
        'country_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'current_elo',
        'base_elo',
        'current_atp',
        'base_atp',
        'voobly_id_main',
        'relic_link_id_main',
        'steam_id_main',
        'liquipedia_handle',
        'discord_handle',
        'twitch_handle',
        'aoe_reference_data_player_id',
        'country_id'
    ];

    /**
     * Get all of the player's metadata.
     */
    public function metadata(): MorphMany
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }

    /**
     * Get a changelog for a Player.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get reviews for a Player.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function set_items(): MorphMany
    {
        return $this->morphMany(SetInfo::class, 'participatory');
    }

    /**
     * Get a tournament results for a Team.
     */
    public function tournament_results(): MorphMany
    {
        return $this->morphMany(TournamentResult::class, 'participatory');
    }

    /**
     * Get a achievements for a Team.
     */
    public function achievements(): MorphToMany
    {
        return $this->morphToMany(Achievement::class, 'achievable')->withPivot('hidden');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->using(PlayerTeam::class)->as('teams')->withTimestamps();
    }

    public function ard_player(): BelongsTo
    {
        return $this->belongsTo(ArdPlayer::class, 'aoe_reference_data_player_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
