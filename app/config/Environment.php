<?php

namespace Beupsoft\App\Config;

class Environment
{
    /**
     * @return string Returns the environment
     */
    protected static function defineMode(): string
    {
        return (!empty($_ENV["APP_ENV"])) ? $_ENV["APP_ENV"] : 'dev';
    }
}