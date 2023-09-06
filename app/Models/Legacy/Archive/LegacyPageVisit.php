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
 * Class LegacyPageVisit
 *
 * @property int|null $id
 * @property Carbon|null $time
 * @property string $session_key
 * @property string $hash
 * @property int $user
 * @property int $ip
 * @property int $ip_info
 * @property string $domain
 * @property string $path
 * @property string $page
 * @property int $entity_id
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyPageVisit extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'page_visit';
    public $timestamps = false;

    protected $casts = [
        'time' => 'datetime',
        'user' => 'int',
        'ip' => 'int',
        'ip_info' => 'int',
        'entity_id' => 'int'
    ];

    protected $fillable = [
        'time',
        'session_key',
        'hash',
        'user',
        'ip',
        'ip_info',
        'domain',
        'path',
        'page',
        'entity_id'
    ];
}
