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
 * Class LegacyUser
 *
 * @property int $id
 * @property string $name
 * @property string $pass
 * @property int $rank
 * @property int|null $allow_tournament
 * @property int|null $allow_player
 * @property int|null $allow_match
 * @property int|null $allow_see
 *
 * @package App\Models\Legacy
 */
class LegacyUser extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'user';
    public $timestamps = false;

    protected $casts = [
        'rank' => 'int',
        'allow_tournament' => 'int',
        'allow_player' => 'int',
        'allow_match' => 'int',
        'allow_see' => 'int'
    ];

    protected $fillable = [
        'name',
        'pass',
        'rank',
        'allow_tournament',
        'allow_player',
        'allow_match',
        'allow_see'
    ];
}
