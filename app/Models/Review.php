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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Review
 *
 * @property int|null $id
 * @property string|null $changes
 * @property string $status
 * @property int|null $reviewable_id
 * @property string|null $reviewable_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $casts = [
        'reviewable_id' => 'int'
    ];

    protected $fillable = [
        'changes',
        'status',
        'reviewable_id',
        'reviewable_type'
    ];

    /**
     * Get a changelog for a Player.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    /**
     * Get the reviewable model.
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo('reviewable');
    }

    /**
     * Get all of the review's metadata.
     *
     * TODO!: This should store things like `comments`
     */
    public function metadata(): MorphMany
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }
}
