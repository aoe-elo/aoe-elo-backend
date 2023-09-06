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
 * Class LegacyExternVooblyCache
 *
 * @property int|null $id
 * @property int|null $voobly_id
 * @property int|null $ladder
 * @property int|null $rating
 * @property int $ranking
 * @property Carbon|null $time
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyExternVooblyCache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'extern_voobly_cache';
    public $timestamps = false;

    protected $casts = [
        'voobly_id' => 'int',
        'ladder' => 'int',
        'rating' => 'int',
        'ranking' => 'int',
        'time' => 'datetime'
    ];

    protected $fillable = [
        'voobly_id',
        'ladder',
        'rating',
        'ranking',
        'time'
    ];
}
