<?php 

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Symfony\Component\Dotenv\Dotenv;

class IndexController 
{
    const C_REST_LOGS_DIR = "/logs";
    public function __construct()
    {
        // dd(["index"]);
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__, 2) . '/.env');

        $result = Bitrix::call("scope");

        // $result = defined(static::class."::C_REST_LOGS_DIR");
        echo json_encode($result);

        // echo "index";
    }
}