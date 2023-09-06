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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArdPlayer
 *
 * @property int|null $id
 * @property string|null $name
 * @property int|null $country_id
 * @property int|null $aoeelo_id
 * @property int|null $esports_earnings
 * @property string|null $liquipedia_handle
 * @property string|null $discord_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property Country $country
 *
 * @package App\Models
 */
class ArdPlayer extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'ard_players';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'country_id' => 'int',
        'aoeelo_id' => 'int',
        'esports_earnings' => 'int'
    ];

    protected $fillable = [
        'id',
        'name',
        'country_id',
        'aoeelo_id',
        'esports_earnings',
        'liquipedia_handle',
        'discord_id'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'aoeelo_id');
    }

    public function ard_teams(): BelongsToMany
    {
        return $this->belongsToMany(ArdTeam::class)->using(ArdPlayerTeam::class)->as('ard_teams')->withTimestamps();
    }

    /**
     * Get all of the ArdPlayer's metadata.
     */
    public function metadata(): MorphMany
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }

    /**
     * Get a changelog for an ArdPlayer.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }
}
