<?php

namespace Beupsoft\App\Config;

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

// TODO Реализовать переключение рабочих сред

// // you can also load several files
// $dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

// // overwrites existing env variables
// $dotenv->overload(__DIR__ . '/.env');

// // loads .env, .env.local, and .env.$APP_ENV.local or .env.$APP_ENV
// $dotenv->loadEnv(__DIR__ . '/.env');