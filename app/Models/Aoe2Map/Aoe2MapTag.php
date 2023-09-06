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

namespace App\Models\Aoe2Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Aoe2MapTag
 *
 * @property int|null $id
 * @property string|null $name
 *
 * @package App\Models
 */
class Aoe2MapTag extends Model
{
    protected $connection = 'aoe2map_sqlite';
    protected $table = 'mapsapp_tag';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function maps(): BelongsToMany
    {
        return $this->belongsToMany(Aoe2MapRms::class, 'mapsapp_rms_tags', 'tag_id', 'rms_id')->as('maps');
    }
}
