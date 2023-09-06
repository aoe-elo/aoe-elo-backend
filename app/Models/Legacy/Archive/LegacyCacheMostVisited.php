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

namespace App\Models\Legacy\Archive;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyCacheMostVisited
 *
 * @property int|null $id
 * @property Carbon|null $day
 * @property string|null $page
 * @property int $entity_id
 * @property int|null $visits
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyCacheMostVisited extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'cache_most_visited';
    public $timestamps = false;

    protected $casts = [
        'day' => 'datetime',
        'entity_id' => 'int',
        'visits' => 'int'
    ];

    protected $fillable = [
        'day',
        'page',
        'entity_id',
        'visits'
    ];
}
