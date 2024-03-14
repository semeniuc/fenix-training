<?php

namespace Beupsoft\App\Config;

class EventCalendarConfig extends Environment
{
    private static array $ownerCalendar = [
        "dev" => [
            "type" => "user",
            "ownerId" => 572,
            "section" => 132,
        ],
        "prod" => [
            "type" => "user",
            "ownerId" => 1,
            "section" => 4,
        ]
    ];

    public static function getOwnerCalendar(): array
    {
        return self::$ownerCalendar[self::defineMode()];
    }
}