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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SteamUser
 *
 * @property int|null $id
 * @property string|null $steam_id
 * @property string $nickname
 * @property string $name
 * @property string $avatar
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class SteamUser extends Model
{
    use SoftDeletes;
    protected $table = 'steam_users';

    protected $casts = [
        'user_id' => 'int'
    ];

    protected $fillable = [
        'steam_id',
        'nickname',
        'name',
        'avatar',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}