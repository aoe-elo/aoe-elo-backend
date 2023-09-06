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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Aoe2MapRms
 *
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $version
 * @property string|null $url
 * @property string|null $file
 * @property string|null $description
 * @property string|null $authors
 * @property Carbon|null $created
 * @property Carbon|null $updated
 * @property string|null $information
 * @property string|null $changelog
 * @property string|null $original_filename
 * @property bool|null $archived
 * @property int $mod_id
 * @property string|null $id
 * @property string $newer_version_id
 *
 * @property Aoe2MapRms $mapsapp_rm
 *
 * @package App\Models
 */
class Aoe2MapRms extends Model
{
    use HasUuids;

    protected $connection = 'aoe2map_sqlite';
    protected $table = 'mapsapp_rms';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'archived' => 'bool',
        'mod_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'version',
        'url',
        'file',
        'description',
        'authors',
        'created',
        'updated',
        'information',
        'changelog',
        'original_filename',
        'archived',
        'mod_id',
        'id',
        'newer_version_id'
    ];

    public function newer_version(): BelongsTo
    {
        return $this->belongsTo(self::class, 'newer_version_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(self::class, 'newer_version_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Aoe2MapTag::class, 'mapsapp_rms_tags', 'rms_id', 'tag_id')->as('tags');
    }
}
