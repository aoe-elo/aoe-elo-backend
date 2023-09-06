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

namespace App\Services;

use App\Models\Action;
use App\Models\LocationStyle;

class LookupService
{
    private $style_lookup = [];
    private $action_lookup = [];

    private static $ATP_CATEGORY_LOOKUP = [
        'prize_pool' => 1,
        'participants' => 2,
        'invitational' => 3,
        'settings_restrictions' => 4,
        'game_mode' => 5,
        'base_points' => 6
    ];

    private static $ARD_METADATA_FIELDS_LOOKUP = [
        'aka' => 'str50_value',
        'twitter' => 'str255_value',
        'twitch' => 'str255_value',
        'youtube' => 'str255_value',
        'douyu' => 'str255_value',
        'discord' => 'str50_value',
        'facebook_gaming' => 'str255_value',
        'kick' => 'str100_value',
    ];

    private static $ARD_PLATFORM_METADATA_FIELDS_LOOKUP = [
        'ibp' => 'str50_value',
        'gamepark' => 'str50_value',
        'zone' => 'str50_value',
        'gameranger' => 'str50_value',
        'rl' => 'str50_value',
        'voobly' => 'str50_value',
    ];

    private static $TOURNAMENT_TYPE_LOOKUP = [
        'cup' => 1,
        'qualifier' => 2,
        'other' => 3
    ];

    private static $TOURNAMENT_STRUCTURE_LOOKUP = [
        'single-elemination' => 1, // typo in legacy db
        'single-elimination' => 1,
        'double-elimination' => 2,
        'round-robin' => 3,
        'swiss' => 4,
        'league' => 5,
        'group' => 6,
        'group-ko' => 7,
        'other' => 8
    ];

    private static $TOURNAMENT_GAME_MODE_LOOKUP = [
        'rm' => 1,
        'dm' => 2,
        'ew' => 3,
        'other' => 4,
    ];

    private static $TOURNAMENT_INFO_TYPE_LOOKUP = [
        1 => 'challonge_bracket',
        2 => 'bracket_url',
        3 => 'public_resource',
        4 => 'private_resource',
        5 => 'location',
        6 => 'other',
    ];

    public function __construct()
    {
        $this->initLocationStyleLookup();
        $this->initActionLookup();
    }

    public static function getTournamentInfoType($type)
    {
        if (isset(self::$TOURNAMENT_INFO_TYPE_LOOKUP[$type])) {
            return self::$TOURNAMENT_INFO_TYPE_LOOKUP[$type];
        }

        return null;
    }

    public static function getTournamentGameMode($mode)
    {
        if (isset(self::$TOURNAMENT_GAME_MODE_LOOKUP[$mode])) {
            return self::$TOURNAMENT_GAME_MODE_LOOKUP[$mode];
        }

        return null;
    }

    public static function getTournamentStructure($structure)
    {
        if (isset(self::$TOURNAMENT_STRUCTURE_LOOKUP[$structure])) {
            return self::$TOURNAMENT_STRUCTURE_LOOKUP[$structure];
        }

        return null;
    }

    public static function getTournamentType($type)
    {
        if (isset(self::$TOURNAMENT_TYPE_LOOKUP[$type])) {
            return self::$TOURNAMENT_TYPE_LOOKUP[$type];
        }

        return null;
    }

    public static function getArdMetadataField($field)
    {
        if (isset(self::$ARD_METADATA_FIELDS_LOOKUP[$field])) {
            return self::$ARD_METADATA_FIELDS_LOOKUP[$field];
        }

        return null;
    }

    public static function getArdMetadataArray()
    {
        return self::$ARD_METADATA_FIELDS_LOOKUP;
    }

    public static function getArdPlatformMetadataArray()
    {
        return self::$ARD_PLATFORM_METADATA_FIELDS_LOOKUP;
    }

    public static function getArdPlatformMetadataField($field)
    {
        if (isset(self::$ARD_PLATFORM_METADATA_FIELDS_LOOKUP[$field])) {
            return self::$ARD_PLATFORM_METADATA_FIELDS_LOOKUP[$field];
        }

        return null;
    }

    public static function getAtpCategoryId($name)
    {
        if (isset(self::$ATP_CATEGORY_LOOKUP[$name])) {
            return self::$ATP_CATEGORY_LOOKUP[$name];
        }

        return null;
    }

    private function initActionLookup()
    {
        $this->action_lookup = Action::all(['*'])->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->keyBy('name');
    }

    public function getActionId($name)
    {
        if (isset($this->action_lookup[$name])) {
            return $this->action_lookup[$name]['id'];
        }

        return null;
    }

    private function initLocationStyleLookup()
    {
        $this->style_lookup = LocationStyle::all(['*'])->transform(function ($item) {
            return [
                'id' => $item->id,
                'style' => $item->style,
            ];
        })->keyBy('style');
    }

    public function getLocationStyleId($style)
    {
        if (isset($this->style_lookup[$style])) {
            return $this->style_lookup[$style]['id'];
        }

        return null;
    }
}
