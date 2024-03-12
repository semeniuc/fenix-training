<?php

namespace Beupsoft\App\Config;

class Environment
{
    /**
     * @return string Returns the environmentAPP_ENV
     */
    protected static function defineMode(): string
    {
        return (!empty(getenv('APP_ENV'))) ? getenv('APP_ENV') : 'dev';
    }
}