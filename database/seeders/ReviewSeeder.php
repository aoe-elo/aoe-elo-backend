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

namespace Database\Seeders;

use App\Repositories\PlayerRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review_repo = new ReviewRepository();
        $player_repo = new PlayerRepository();

        $player = $player_repo->getPlayerById(1);

        $change = [
            'name' => 'John Doe2'
        ];

        $review = $review_repo->addReviewToQueue($player, $change, 2, 'We\'re testing here to change DauTs name.', 'Test to change name', 'pending');

        // $review_repo->addCommentToReviewEntry($review->id, 'This is a new comment.', 2, 'Adding comment to review entry.');

        // wait for 20 seconds
        sleep(5);
        $review_repo->deleteReviewEntry($review->id, 2, 'Removing review entry.');
    }
}
