<?php

namespace Beupsoft\App\Config;

class EventCalendarConfig extends Environment
{
    private static array $params = [
        "dev" => [
            "type" => "user",
            "ownerId" => 1,
            "from" => "",
            "to" => "",
            "section" => "",
            "name" => ""
        ],
    ];

    public static function getParams(): array
    {
        return self::$params;
    }
}