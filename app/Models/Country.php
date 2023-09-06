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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Country
 *
 * @property int|null $id
 * @property string $capital
 * @property string $citizenship
 * @property string|null $country_code
 * @property string $currency
 * @property string $currency_code
 * @property string $currency_sub_unit
 * @property string $currency_symbol
 * @property int $currency_decimals
 * @property string $full_name
 * @property string|null $iso_3166_2
 * @property string|null $iso_3166_3
 * @property string|null $name
 * @property string|null $region_code
 * @property string|null $sub_region_code
 * @property bool|null $eea
 * @property string $calling_code
 * @property string $flag
 *
 * @package App\Models
 */
class Country extends Model
{
    protected $connection = 'sqlite';
    protected $table = 'countries';
    public $timestamps = false;

    protected $casts = [
        'currency_decimals' => 'int',
        'eea' => 'bool'
    ];

    protected $fillable = [
        'capital',
        'citizenship',
        'country_code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'currency_symbol',
        'currency_decimals',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'name',
        'region_code',
        'sub_region_code',
        'eea',
        'calling_code',
        'flag'
    ];

    /**
     * Get a changelog for a Country.
     */
    public function action_logs(): MorphMany
    {
        return $this->morphMany(Actionlog::class, 'loggable');
    }

    public function ard_players(): HasMany
    {
        return $this->hasMany(ArdPlayer::class, 'country_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'country_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'country_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
