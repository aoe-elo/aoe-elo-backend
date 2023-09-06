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
 * Class LegacySubscription
 *
 * @property int|null $id
 * @property Carbon|null $created
 * @property string|null $email
 * @property string|null $session
 *
 * @package App\Models\Legacy\Archive
 */
class LegacySubscription extends Model
{
    protected $connection = 'legacy_mysql';
    protected $table = 'subscription';
    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime'
    ];

    protected $fillable = [
        'created',
        'email',
        'session'
    ];
}
