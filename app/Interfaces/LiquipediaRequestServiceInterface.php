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

namespace App\Interfaces;

interface LiquipediaRequestServiceInterface
{
    // TODO!: Add more needed methods for Liquipedia API here
    public function getPlayerByLiquipediaId($liquipediaPlayerId);

    public function getLocationByLiquipediaLocationId($liquipediaLocationId);

    public function getTeamByLiquipediaId($liquipediaTeamId);

    public function getTournamentByLiquipediaId($liquipediaTournamentId);

    public function getSetByLiquipediaId($liquipediaSetId);
}
