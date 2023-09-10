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
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property int $country_id
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
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
        'country_id' => 'int'
    ];

    public function discord_user(): HasOne
    {
        return $this->hasOne(DiscordUser::class);
    }

    public function steam_user(): HasOne
    {
        return $this->hasOne(SteamUser::class);
    }

    public function twitch_user(): HasOne
    {
        return $this->hasOne(TwitchUser::class);
    }

    public function github_user(): HasOne
    {
        return $this->hasOne(GithubUser::class);
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
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
