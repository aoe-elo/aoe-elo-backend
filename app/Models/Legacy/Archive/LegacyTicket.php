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
 * Class LegacyTicket
 *
 * @property int|null $id
 * @property Carbon|null $created
 * @property int $user
 * @property string|null $type
 * @property int|null $done
 * @property string|null $message
 * @property string|null $contact
 * @property string|null $hash
 * @property string|null $session
 *
 * @package App\Models\Legacy\Archive
 */
class LegacyTicket extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'ticket';
    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime',
        'user' => 'int',
        'done' => 'int'
    ];

    protected $fillable = [
        'created',
        'user',
        'type',
        'done',
        'message',
        'contact',
        'hash',
        'session'
    ];
}
