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

// TODO: remove unused imports, replace with Repositories and Models
// use Log;
// use AOE\Player;
// use AOE\Series;
// use Entity\Pool;
// use AOE\PlayerPool;
// use AOE\SeriesPool;
// use AOE\PlayerCachePool;

use Illuminate\Support\Facades\Log;

/**
 * The temporal order === ID order
 */
class LegacyEloHistoryService extends Pool
{
    public static $table = 'elo_1v1_cache';
    public static $class = null;
    public static $cache = null;

    public static $verbose = null;

    public static function rebuild()
    {
        Log::info('Rebuilding elo history');
        // cache players
        PlayerPool::fetchAll();
        // recalculate initial values
        EloHolder::get()->rebuildInitialElo();
        // clear
        self::$db->query('truncate table ' . static::$table);
        // iterate over matches by time
        $eloCache = [];
        $entries = [];
        $elo = EloHolder::get();
        $lastMatches = [];
        foreach (SeriesPool::fetchByTime(false) as $match) {
            Log::debugIf(self::$verbose, 'Processing game from ' . ($match->date ? $match->date->format('Y-m-d') : 'null'));
            if (!isset($eloCache[$match->p1->id])) {
                $eloCache[$match->p1->id] = $elo->initial($match->p1);
            }
            if (!isset($eloCache[$match->p2->id])) {
                $eloCache[$match->p2->id] = $elo->initial($match->p2);
            }
            $before1 = $eloCache[$match->p1->id];
            $before2 = $eloCache[$match->p2->id];
            $changes = EloCalc::calcMatchChanges($eloCache[$match->p1->id], $eloCache[$match->p2->id], $match->s1, $match->s2);
            $eloCache[$match->p1->id] += $changes[0];
            $eloCache[$match->p2->id] += $changes[1];
            $entries[] = static::makeMatchEntry(
                $match,
                $match->p1,
                $before1,
                $eloCache[$match->p1->id]
            );
            $entries[] = static::makeMatchEntry(
                $match,
                $match->p2,
                $before2,
                $eloCache[$match->p2->id]
            );
            $lastMatches[$match->p1->id] = $match;
            $lastMatches[$match->p2->id] = $match;
        }

        // Elo decay
        if (EloCalc::$useDecay) {
            $now = new \DateTime();
            foreach ($lastMatches as $id => $match) {
                Log::debug('decaying ' . $id . ' at ' . $eloCache[$id]);
                $last = clone $match->getApproxTime();
                $last->modify(EloCalc::$decayStartsAfter);
                while ($last < $now and $eloCache[$id] > EloCalc::$bottom) {
                    $eloBefore = $eloCache[$id];
                    $eloCache[$id] = max($eloCache[$id] - EloCalc::$decayPerMonth, EloCalc::$bottom);
                    Log::debug("decaying $id 30 days, now " . $eloCache[$id]);
                    $entries[] = static::makeDecayEntry(clone $last, $id, $eloBefore, $eloCache[$id]);
                    $last->modify('+30 days');
                }
            }
        }

        // insert entries
        Log::info('Pushing elo history data');
        foreach (array_chunk($entries, 100) as $list) {
            self::insertList($list);
        }

        // Save last matches
        PlayerCachePool::refreshEloData($lastMatches);
    }

    public static function makeMatchEntry($match, $player, $eloBefore, $eloAfter)
    {
        static $now = null;
        if ($now === null) {
            $now = new \DateTime();
        }

        // KEEP SAME ORDER!!
        return [
            'created' => $now,
            'type' => 'match',
            'player_id' => $player->id,
            'tournament_id' => $match->tournament->id,
            'match_id' => $match->id,
            'match_time' => $match->date ? $match->date : $match->tournament->end(),
            'elo_before' => $eloBefore,
            'elo_after' => $eloAfter,
        ];
    }

    public static function makeDecayEntry($time, $playerID, $eloBefore, $eloAfter)
    {
        static $now = null;
        if ($now === null) {
            $now = new \DateTime();
        }

        // KEEP SAME ORDER!!
        return [
            'created' => $now,
            'type' => 'decay',
            'player_id' => $playerID,
            'tournament_id' => null,
            'match_id' => null,
            'match_time' => $time,
            'elo_before' => $eloBefore,
            'elo_after' => $eloAfter,
        ];
    }

    public static function afterMatch(Series $m, Player $p)
    {
        $l = static::$db->query('
            select *
            from ' . static::$table . "
            where match_id = {$m->id} and player_id = {$p->id} limit 1")->fetch();

        return $l ? (int) $l['elo_after'] : null;
    }
}
