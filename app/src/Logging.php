<?php

namespace Beupsoft\Fenix\App;

final class Logging
{
    private const IS_SAVE_LOG = true;
    private const DIR_LOG = '../var/log/';

    public static function save(mixed $arData, string $type = '', string $category = '')
    {
        $return = false;

        if (static::IS_SAVE_LOG === true) 
        {
            $path = (!empty($category) ? static::DIR_LOG . $category . "/" : static::DIR_LOG);
            (file_exists($path)) ?: mkdir($path, 0775, true);
            
            $dataToJson = [
                date('H:i:s') => [
                    'type' => $type,
                    'data' => $arData,
                ],
            ];

            $file = date("Y-m-d") . ".json";

            if (file_exists($path . $file)) {
                $oldJsonLog = json_decode(file_get_contents($path . $file), true);
                $jsonLog = json_encode(array_merge($dataToJson, $oldJsonLog), JSON_PRETTY_PRINT);
            } else {
                $jsonLog = json_encode($dataToJson, JSON_PRETTY_PRINT);
            }

            $return = file_put_contents($path . $file, $jsonLog);
        }

        return $return;
    }
}
