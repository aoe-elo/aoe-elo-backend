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

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyCountry
 *
 * @property int|null $id
 * @property string|null $iso_key
 * @property string|null $name
 *
 * @package App\Models\Legacy
 */
class LegacyCountry extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'country';
    public $timestamps = false;

    protected $fillable = [
        'iso_key',
        'name'
    ];
}
