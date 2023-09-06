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
 * Class LegacyStage
 *
 * @property int|null $id
 * @property string|null $name
 * @property int|null $bracket
 * @property int|null $index
 * @property float|null $weight
 * @property int|null $importance
 *
 * @package App\Models\Legacy
 */
class LegacyStage extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'stage';
    public $timestamps = false;

    protected $casts = [
        'bracket' => 'int',
        'index' => 'int',
        'weight' => 'float',
        'importance' => 'int'
    ];

    protected $fillable = [
        'name',
        'bracket',
        'index',
        'weight',
        'importance'
    ];
}
