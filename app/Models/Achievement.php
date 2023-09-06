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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Achievement
 *
 * @property int|null $id
 * @property string|null $name
 * @property string $name_short
 * @property string $description
 * @property string $image_path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Achievement extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'achievements';

    protected $fillable = [
        'name',
        'name_short',
        'description',
        'image_path'
    ];

    /**
     * Get all of the Players that are assigned to this achievement.
     */
    public function players(): MorphToMany
    {
        return $this->morphedByMany(Player::class, 'achievable')->withPivot('hidden');
    }

    /**
     * Get all of the Teams that are assigned to this achievement.
     */
    public function teams(): MorphToMany
    {
        return $this->morphedByMany(Team::class, 'achievable')->withPivot('hidden');
    }

    /**
     * Get reviews for an Achievement.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
