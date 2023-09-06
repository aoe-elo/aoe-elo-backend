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

use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyMetaCache
 *
 * @property int $id
 * @property int $name
 * @property int $value_int
 * @property float $value_float
 * @property string $value_str
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyMetaCache extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'meta_cache';
    public $timestamps = false;

    protected $casts = [
        'name' => 'int',
        'value_int' => 'int',
        'value_float' => 'float'
    ];

    protected $fillable = [
        'name',
        'value_int',
        'value_float',
        'value_str'
    ];
}
