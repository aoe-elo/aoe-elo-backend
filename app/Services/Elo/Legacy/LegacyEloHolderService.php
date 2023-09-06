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
// use AOE\SeriesPool;
// use AOE\Player;
// use AOE\PlayerPool;
// use AOE\Tournament\Stage;
// use Entity\Entity;
// use Entity\Pool;

/**
 * Allows to query the elo ratings of players at given times. Uses caching for improved performance.
 */
class LegacyEloHolderService
{
    private static $instance;

    private $EloHistory = [];
    private $now;
    private $initTime;

    private function __construct()
    {
        $this->now = new \DateTime();
        $this->initTime = new \DateTime('1990-01-01 00:00:00');
        $this->checkInitialElo();
    }

    /**
     * @return EloHolder
     */
    public static function get()
    {
        if (!static::$instance) {
            static::$instance = new EloHolder();
        }

        return static::$instance;
    }

    public function initial(Player $p)
    {
        return $this->at($this->initTime, $p);
    }

    public function listInitial(array $ids = null)
    {
        return $this->listAt($this->initTime, $ids);
    }

    /** Get current elo of a player */
    public function current(Player $p)
    {
        return $this->at($this->now, $p);
    }

    /** Get all current elos */
    public function listCurrent(array $ids = null)
    {
        return $this->listAt($this->now, $ids);
    }

    /** Get one player elo at a certain time */
    public function at(\DateTime $t, Player $p)
    {
        $list = $this->listAt($t, [$p->id]);

        return $list[$p->id];
    }

    /** Get all player elos at a given time */
    public function listAt(\DateTime $t, array $ids = null)
    {
        $stamp = $t->getTimestamp();
        if (!array_key_exists($stamp, $this->EloHistory)) {
            $this->EloHistory[$stamp] = $this->measureAt(null, $t);
        }
        if ($ids === null) {
            return $this->EloHistory[$stamp];
        } else {
            return array_intersect_key($this->EloHistory[$stamp], array_flip($ids));
        }
    }

    /** Get elo development (diff) compared to a time span in the past */
    public function development(array $playerIDs = null, $horizon = '-60 days')
    {
        $now = new \DateTime();
        $then = $now->modify($horizon);
        $current = $this->listCurrent($playerIDs);
        $previous = $this->listAt($then, $playerIDs);
        $devs = [];
        foreach (array_keys($current) as $id) {
            if (isset($current[$id]) and isset($previous[$id])) {
                $devs[$id] = $current[$id] - $previous[$id];
            } else {
                $devs[$id] = null;
            }
        }

        return $devs;
    }

    public function calcAverageElo(array $players = null, \DateTime $time = null, $top = null)
    {
        $elos = $this->listAt($time, is_array($players) ? Entity::makeIDList($players) : null);
        if (!$elos) {
            return null;
        }
        if (!$top) {
            $avg = array_sum($elos) / count($elos);
        } else {
            arsort($elos);
            $elos = array_slice($elos, 0, $top);
            $avg = array_sum($elos) / count($elos);
        }

        return round($avg);
    }

    public function checkInitialElo()
    {
        \Log::debug('Checking if initial Elo has to be rebuilt');
        $missing = Pool::$db->query('select 1 from ' . PlayerPool::$table . ' where initial_elo_1v1 is null limit 1');
        if (!$missing->fetch()) {
            \Log::info('Initial player Elo is complete, no rebuild.');
        } else {
            $this->rebuildInitialElo();
        }
    }

    /**
     * Calculate initial Elo for all players:
     * cout num_matches, num_finals and num_tournaments
     */
    public function rebuildInitialElo()
    {
        $query = '
                select
                    p.id,
                    count(*) as num_matches,
                    sum(if(m.stage_id in (' . Stage::ID_FINAL . ', ' . Stage::ID_GRAND_FINAL . '), 1, 0)) as num_finals
                from ' . PlayerPool::$table . ' as p
                left join ' . SeriesPool::$table . ' as m on m.player_1_id = p.id or m.player_2_id = p.id
                left join stage as s on s.id = m.stage_id
                group by p.id
            ';
        $elos = [];
        $stmt = Pool::$db->query($query);
        while ($line = $stmt->fetch()) {
            $verbose = $line['id'] == 247;
            $elo = EloCalc::$initalLow;
            // TODO evaluate tournament participations
            $n = (int) $line['num_matches'];
            $f = (int) $line['num_finals'];
            if ($n >= EloCalc::$minNumSeriesHighStart) {
                $elo = EloCalc::$initalMed;
            }
            if ($f > 0) {
                $elo = EloCalc::$initalHigh;
            }
            $elos[(int) $line['id']] = $elo;
            if ($verbose) {
                \Log::info('-------------- verbose init elo');
                \Log::info('num_matches ' . $n);
                \Log::info('num_finals  ' . $f);
                \Log::info($line);
            }
        }
        // TODO put in one stmt
        foreach ($elos as $id => $elo) {
            Pool::$db->query('update ' . PlayerPool::$table . " set initial_elo_1v1 = {$elo} where id = {$id}");
        }
    }

    /**
     * @return array player_id to Elo at the given time (or most recent)
     */
    private function measureAt(array $playerIDs = null, \DateTime $before = null)
    {
        \Log::info('Measuring all player Elos at ' . ($before ? $before->format('Y-m-d') : 'the moment'));
        if (is_array($playerIDs) and !$playerIDs) {
            return [];
        }
        $db = EloHistory::$db;
        $playerfilter = ($playerIDs === null) ? '1' : 'player_id ' . $db->inIntClause($playerIDs);
        $timeFilter = !$before ? '1' : "match_time <= '" . $db->escapeVal($before->format($db->getDateFormat())) . "'";
        $query = '
            select
                stat.id,
                if(latest_elo is null, initial_elo_1v1, latest_elo) as elo
            from (
                select
                    p.*,
                    (
                        select elo_after
                        from ' . EloHistory::$table . ' as e
                        where player_id = p.id and ' . $timeFilter . '
                        order by e.id desc limit 1
                    ) as latest_elo
                from ' . PlayerPool::$table . ' as p
                where ' . $playerfilter . '
            ) as stat
        ';
        $stmt = $db->query($query);
        $elos = [];
        while ($line = $stmt->fetch()) {
            $elos[(int) $line['id']] = (int) $line['elo'];
        }

        return $elos;
    }
}
