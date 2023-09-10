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
 * Class GithubUser
 *
 * @property int|null $id
 * @property string|null $github_id
 * @property string $name
 * @property string $email
 * @property string $github_token
 * @property string $github_refresh_token
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class GithubUser extends Model
{
    use SoftDeletes;
    protected $table = 'github_users';

    protected $casts = [
        'user_id' => 'int'
    ];

    protected $hidden = [
        'github_token',
        'github_refresh_token'
    ];

    protected $fillable = [
        'github_id',
        'name',
        'email',
        'github_token',
        'github_refresh_token',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
