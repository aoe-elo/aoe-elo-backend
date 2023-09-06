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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LocationStyle
 *
 * @property int|null $id
 * @property string|null $style
 * @property int $weight
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class LocationStyle extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'location_styles';

    protected $casts = [
        'weight' => 'int'
    ];

    protected $fillable = [
        'style',
        'weight'
    ];

    /**
     * Get a changelog for a Country.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_location_styles')->as('locations')->withTimestamps();
    }
}
