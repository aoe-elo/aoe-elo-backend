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
 * Class Location
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $name_short
 * @property string|null $liquipedia_link
 * @property string|null $aoe2map_link
 * @property string|null $aoe2map_uuid
 * @property string|null $image_path
 * @property string|null $preview_image_path
 * @property string|null $keywords
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Location extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'locations';

    protected $fillable = [
        'name',
        'name_short',
        'liquipedia_link',
        'aoe2map_link',
        'aoe2map_uuid',
        'image_path',
        'preview_image_path',
        'keywords'
    ];

    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function location_styles()
    {
        return $this->belongsToMany(LocationStyle::class, 'location_location_styles')->as('location_styles')->withTimestamps();
    }

    public function set_info(): BelongsToMany
    {
        return $this->belongsToMany(SetInfo::class, 'location_set_info')->as('set_info')->withTimestamps();
    }

    /**
     * Get reviews for a Location.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
