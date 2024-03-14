<?php

namespace Beupsoft\App\Config;

class DealConfig extends Environment
{
    private static array $params = [
        "dev" => [
            "entityTypeId" => 2,
            "fields" => [
                "id" => "id",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "assignedById" => "assignedById",
                "days" => "ufCrm_1709801608762",
                "time" => "ufCrm_1709801802210",
            ],
        ],
        "prod" => [
            "entityTypeId" => 2,
            "fields" => [
                "id" => "id",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "assignedById" => "assignedById",
                "days" => "ufCrm_1709801608762",
                "time" => "ufCrm_1709801802210",
            ],
        ],
    ];

    private static array $listDays = [
        "Poniedziałek" => 1,
        "Wtorek" => 2,
        "Środa" => 3,
        "Czwartek" => 4,
        "Piątek" => 5,
        "Sobota" => 6,
        "Niedziela" => 7,
    ];

    public static function getEntityTypeId(): int
    {
        return self::$params[self::defineMode()]["entityTypeId"];
    }

    public static function getFields(): array
    {
        return self::$params[self::defineMode()]["fields"];
    }

    public static function getListDays(): array
    {
        return self::$listDays;
    }
}