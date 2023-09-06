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

namespace App\Services\Elo\Legacy;

// TODO: Remove unused old imports, replace with Models and Repositories
// use AOE\SeriesPool;
// use AOE\Player;
// use AOE\PlayerPool;
// use AOE\Tournament\Stage;
// use Entity\Pool;

use Illuminate\Support\Facades\Log;

class LegacyEloCalculationService
{
    public static $useDecay = false;
    public static $decayPerMonth = 10;
    public static $decayStartsAfter = '+90 days';

    public static $minNumSeriesHighStart = 8; // With less, a player is starting with lower elo
    public static $minNumSeries = 8; // With less, a player is not ranked (still has elo)

    public static $bottom = 1800;
    public static $initalLow = 1900;
    public static $initalMed = 2000;
    public static $initalHigh = 2000;

    public static $normalizer = 400;
    public static $gameWeight = 8;

    public static $verbose = false;

    public static function calculateMatchChanges($before1, $before2, $score1, $score2)
    {
        $changes1 = 0;
        $changes2 = 0;
        $win1changes = self::calculateGameChangesElo($before1, $before2);
        $win2changes = self::calculateGameChangesElo($before2, $before1);
        for ($i = 0; $i < $score1; $i++) {
            $changes1 += $win1changes[0];
            $changes2 += $win1changes[1];
        }
        for ($i = 0; $i < $score2; $i++) {
            $changes1 += $win2changes[1];
            $changes2 += $win2changes[0];
        }

        //\Log::debugIf(self::$verbose, "Series result: {$before1}/{$before2} with {$score1}:{$score2} -> {$changes1}/{$changes2}");
        return [$changes1, $changes2];
    }

    public static function calculateGameChangesElo($winnerElo, $loserElo)
    {
        $E = self::calculateGameWinProbability($winnerElo, $loserElo);
        //\Log::debugIf(self::$verbose, "Elo Game: Winner ({$winnerElo}) vs Loser({$loserElo}): E(w1) = {$E}");
        $exchange = round(static::$gameWeight * (1 - $E));
        $changeWinner = $exchange;
        $changeLoser = -$exchange;

        //\Log::debugIf(self::$verbose, "Elo Game: Winner ({$winnerElo}) vs Loser ({$loserElo}): {$changeWinner}/{$changeLoser}");
        return [$changeWinner, $changeLoser];
    }

    public static function calculateGameWinProbability($winnerElo, $loserElo)
    {
        return 1 / (1 + pow(10, ($loserElo - $winnerElo) / static::$normalizer));
    }

    public static function seriesWinProbability($winnerElo, $loserElo, $bo)
    {
        $p = static::calculateGameWinProbability($winnerElo, $loserElo);
        $gamesToWin = ($bo - 1) / 2;
        $maxLosses = $gamesToWin - 1;
        $sum = 0;
        //\Log::debugIf(static::$verbose, "Calculating win prob of ".$winnerElo." to ".$loserElo." - ".$p);
        for ($losses = 0; $losses <= $maxLosses; $losses++) {
            $thisProb = static::calculateGameResultProbability($gamesToWin, $losses, $p);
            $sum += $thisProb;
            Log::debugIf(static::$verbose, 'Prob of ' . $gamesToWin . ':' . $losses . ' is ' . $thisProb);
        }

        //\Log::debugIf(static::$verbose, "Result: ".$sum);
        return $sum;
    }

    public static function calculateGameResultProbability($winnerScore, $loserScore, $p)
    {
        //\Log::debugIf(static::$verbose, "Prob of ".$winnerScore.":".$loserScore." is ".static::outOf($winnerScore, $winnerScore + $loserScore)." * ".pow($p, $winnerScore)." * ".pow(1 - $p, $loserScore));
        return static::outOf($winnerScore, $winnerScore + $loserScore) * pow($p, $winnerScore) * pow(1 - $p, $loserScore);
    }

    public static function outOf($k, $n)
    {
        return static::fact($n) / static::fact($k) / static::fact($n - $k);
    }

    public static function fact($x)
    {
        if ($x <= 1) {
            return 1;
        } else {
            return $x * static::fact($x - 1);
        }
    }
}
