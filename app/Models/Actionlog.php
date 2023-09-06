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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Actionlog
 *
 * @property int|null $id
 * @property int|null $user_id
 * @property string|null $action
 * @property string $summary
 * @property int $loggable_id
 * @property string|null $loggable_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property User|null $user
 * @property Action|null $action
 *
 * @package App\Models
 */
class Actionlog extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'actionlog';

    protected $casts = [
        'user_id' => 'int',
        'action_id' => 'int',
        'loggable_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'action_id',
        'summary',
        'loggable_id',
        'loggable_type'
    ];

    /**
     * Get the parent entity model.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo('loggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
