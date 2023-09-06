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

namespace App\Utilities;

class ProgressBar
{
    /**
     * Progress bar for console output.
     *
     * credits: https://gist.github.com/mayconbordin/2860547
     *
     * @param int $done
     * @param int $total
     * @param string $info
     * @param int $width
     * @return string
     */
    public static function render(int $done, int $total, string $info = '', int $width = 50): string
    {
        $perc = round(($done * 100) / $total);
        $bar = round(($width * $perc) / 100);

        return sprintf("%s/%s | %s%% [%s>%s] %s   \r", $done, $total, $perc, str_repeat('=', $bar), str_repeat(' ', $width - $bar), $info);
    }
}
