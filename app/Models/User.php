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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int|null $id
 * @property string|null $name
 * @property string $email
 * @property int $discord_user_id
 * @property int $steam_user_id
 * @property int $twitch_user_id
 * @property int $github_user_id
 * @property int $player_id
 * @property int $country_id
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property DiscordUser $discord_user
 * @property SteamUser $steam_user
 * @property TwitchUser $twitch_user
 * @property GithubUser $github_user
 * @property Player $player
 * @property Country $country
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'discord_user_id',
        'steam_user_id',
        'twitch_user_id',
        'github_user_id',
        'player_id',
        'country_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discord_user_id' => 'int',
        'steam_user_id' => 'int',
        'twitch_user_id' => 'int',
        'github_user_id' => 'int',
        'player_id' => 'int',
        'country_id' => 'int'
    ];

    public function discord_user(): BelongsTo
    {
        return $this->belongsTo(DiscordUser::class);
    }

    public function steam_user(): BelongsTo
    {
        return $this->belongsTo(SteamUser::class);
    }

    public function twitch_user(): BelongsTo
    {
        return $this->belongsTo(TwitchUser::class);
    }

    public function github_user(): BelongsTo
    {
        return $this->belongsTo(GithubUser::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get all of the User's metadata.
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

    public function changes_by_user(): HasMany
    {
        return $this->hasMany(Actionlog::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
