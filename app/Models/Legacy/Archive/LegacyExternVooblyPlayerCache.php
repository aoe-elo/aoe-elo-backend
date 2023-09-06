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
 * Class LegacyExternVooblyPlayerCache
 *
 * @property int|null $id
 * @property int|null $voobly_id
 * @property int|null $rm_1v1
 * @property int|null $rm_tg
 * @property Carbon|null $time
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyExternVooblyPlayerCache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'extern_voobly_player_cache';
    public $timestamps = false;

    protected $casts = [
        'voobly_id' => 'int',
        'rm_1v1' => 'int',
        'rm_tg' => 'int',
        'time' => 'datetime'
    ];

    protected $fillable = [
        'voobly_id',
        'rm_1v1',
        'rm_tg',
        'time'
    ];
}
