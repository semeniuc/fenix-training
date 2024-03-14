<?php

namespace Beupsoft\App\Config;

class TrainingConfig extends Environment
{
    private static array $params = [
        "dev" => [
            "entityTypeId" => 149,
            "fields" => [
                "id" => "id",
                "title" => "title",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "dealId" => "parentId2",
                "eventId" => "ufCrm22EventId",
                "assignedById" => "assignedById",
                "datetimeTraining" => "ufCrm22_1709804621873",
                "whoIsClosed" => "ufCrm22_1709810191984",
            ],
        ],
        "prod" => [
            "entityTypeId" => 149,
            "fields" => [
                "id" => "id",
                "title" => "title",
                "categoryId" => "categoryId",
                "stageId" => "stageId",
                "dealId" => "parentId2",
                "eventId" => "ufCrm22EventId",
                "assignedById" => "assignedById",
                "datetimeTraining" => "ufCrm22_1709804621873",
                "whoIsClosed" => "ufCrm22_1709810191984",
            ],
        ],
    ];

    public static function getEntityTypeId(): int
    {
        return self::$params[self::defineMode()]["entityTypeId"];
    }

    public static function getFields(): array
    {
        return self::$params[self::defineMode()]["fields"];
    }
}