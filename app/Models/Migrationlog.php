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
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Migrationlog
 *
 * @property int|null $id
 * @property int|null $migratory_id
 * @property string|null $migratory_type
 * @property bool|null $save_confirmed
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Migrationlog extends Model
{
    protected $connection = 'sqlite';
    protected $table = 'migrationlog';

    protected $casts = [
        'migratory_id' => 'int',
        'save_confirmed' => 'bool'
    ];

    protected $fillable = [
        'migratory_id',
        'migratory_type',
        'save_confirmed'
    ];

    /**
     * Get the parent saved model.
     */
    public function migratory(): MorphTo
    {
        return $this->morphTo('migratory');
    }
}
