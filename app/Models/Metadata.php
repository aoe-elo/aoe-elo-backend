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

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Str;

/**
 * Class Metadata
 *
 * @property int|null $id
 * @property string|null $key
 * @property string|null $sub_key
 * @property string|null $type_of_value
 * @property bool|null $boolean_value
 * @property int|null $integer_value
 * @property int|null $smallint_value
 * @property Carbon|null $datetime_value
 * @property string|null $str50_value
 * @property string|null $str100_value
 * @property string|null $str255_value
 * @property string|null $text_value
 * @property string|null $json_value
 * @property int|null $metadatable_id
 * @property string|null $metadatable_type
 * @property bool|null $is_verified
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Metadata extends Model
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'metadata';

    protected $casts = [
        'boolean_value' => 'bool',
        'integer_value' => 'int',
        'smallint_value' => 'int',
        'datetime_value' => 'datetime',
        'metadatable_id' => 'int',
        'is_verified' => 'bool',
    ];

    protected $fillable = [
        'key',
        'sub_key',
        'type_of_value',
        'boolean_value',
        'integer_value',
        'smallint_value',
        'datetime_value',
        'str50_value',
        'str100_value',
        'str255_value',
        'text_value',
        'json_value',
        'metadatable_id',
        'metadatable_type',
        'is_verified'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    // protected static function booted()
    // {
    //     // automatically insert ulid on creation
    //     static::creating(fn ($model) => $model->ulid = Str::ulid());
    // }

    /**
     * Get the metadatable model.
     */
    public function metadatable(): MorphTo
    {
        return $this->morphTo('metadatable');
    }

    /**
     * Get a changelog for a Metadata item.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }
}
