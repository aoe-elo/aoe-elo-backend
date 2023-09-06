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
 * Class LegacyPageIpInfo
 *
 * @property int|null $id
 * @property Carbon|null $time
 * @property int $ip
 * @property string $data
 * @property float $longitude
 * @property float $latitude
 * @property string $country
 * @property string $country_code
 * @property string $city
 * @property string $error
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyPageIpInfo extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'page_ip_info';
    public $timestamps = false;

    protected $casts = [
        'time' => 'datetime',
        'ip' => 'int',
        'longitude' => 'float',
        'latitude' => 'float'
    ];

    protected $fillable = [
        'time',
        'ip',
        'data',
        'longitude',
        'latitude',
        'country',
        'country_code',
        'city',
        'error'
    ];
}
