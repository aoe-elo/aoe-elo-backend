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
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArdPlayerTeam
 *
 * @property int|null $id
 * @property int $ard_player_id
 * @property int $ard_team_id
 * @property bool|null $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @property ArdPlayer $ard_player
 * @property ArdTeam $ard_team
 *
 * @package App\Models
 */
class ArdPlayerTeam extends Pivot
{
    use SoftDeletes;

    protected $connection = 'sqlite';
    protected $table = 'ard_player_ard_team';

    protected $casts = [
        'ard_player_id' => 'int',
        'ard_team_id' => 'int',
        'is_active' => 'bool'
    ];

    protected $fillable = [
        'ard_player_id',
        'ard_team_id',
        'is_active'
    ];

    public function ard_player()
    {
        return $this->belongsTo(ArdPlayer::class, 'ard_player_id', 'id');
    }

    public function ard_team()
    {
        return $this->belongsTo(ArdTeam::class, 'ard_team_id', 'id');
    }
}
