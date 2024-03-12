<?php

// namespace Beupsoft\App\Config\Calendar;

use Beupsoft\App\Config\Environment;

class Event extends Environment
{
    private static array $params = [
        "dev" => [
            "ownerId" => "",
        ],
    ];

    public static function getParams(): array
    {
        return self::$params;
    }
}