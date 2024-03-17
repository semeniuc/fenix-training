<?php

namespace Beupsoft\App\Config;

class DealConfig extends Environment
{
    private static array $params = [
        "dev" => [
            "entityTypeId" => 2,
            "fields" => [
                "id" => "id",
                "title" => "ufCrm_1710710399",
                "contactId" => "contactId",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "assignedById" => "assignedById",
                "days" => "ufCrm_1709801608762",
                "time" => "ufCrm_1709801802210",
                "startDate" => "ufCrm_1709802486280",
                "numberTrainings" => "ufCrm_1705395448677",
                "startDatePause" => "ufCrm_1709802590412",
                "endDatePause" => "ufCrm_1709802612328",
            ],
        ],
        "prod" => [
            "entityTypeId" => 2,
            "fields" => [
                "id" => "id",
                "title" => "ufCrm_1710710399",
                "contactId" => "contactId",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "assignedById" => "assignedById",
                "days" => "ufCrm_1709801608762",
                "time" => "ufCrm_1709801802210",
                "startDate" => "ufCrm_1709802486280",
                "numberTrainings" => "ufCrm_1705395448677",
                "startDatePause" => "ufCrm_1709802590412",
                "endDatePause" => "ufCrm_1709802612328",
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