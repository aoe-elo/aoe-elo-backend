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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class AtpCategory
 *
 * @property int|null $id
 * @property int|null $category
 * @property string|null $sub_category
 * @property int $base_value
 * @property int|null $modifier
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AtpCategory extends Model
{
    protected $connection = 'sqlite';
    protected $table = 'atp_categories';

    protected $casts = [
        'category' => 'int',
        'base_value' => 'int',
        'modifier' => 'int'
    ];

    protected $fillable = [
        'category',
        'sub_category',
        'base_value',
        'modifier'
    ];

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class, 'category_id');
    }

    /**
     * Get a changelog for an AtpCategory.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }
}
