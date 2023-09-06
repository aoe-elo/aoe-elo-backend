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
 * Class LegacyExternDeCache
 *
 * @property int|null $id
 * @property string|null $steam_id
 * @property Carbon|null $time
 * @property int|null $rating
 * @property int|null $rank
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyExternDeCache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'extern_de_cache';
    public $timestamps = false;

    protected $casts = [
        'time' => 'datetime',
        'rating' => 'int',
        'rank' => 'int'
    ];

    protected $fillable = [
        'steam_id',
        'time',
        'rating',
        'rank'
    ];
}
