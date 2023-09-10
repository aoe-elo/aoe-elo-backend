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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News
 *
 * @property int|null $id
 * @property string|null $title
 * @property bool|null $pinned
 * @property string $abstract
 * @property string|null $content
 * @property string $description
 * @property string $tags
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class News extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'news';

    protected $casts = [
        'pinned' => 'bool'
    ];

    protected $fillable = [
        'title',
        'pinned',
        'abstract',
        'content',
        'description',
        'tags'
    ];

    /**
     * Get a changelog for a News entry.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get reviews for a News item.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
