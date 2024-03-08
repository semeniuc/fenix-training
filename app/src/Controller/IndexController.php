<?php 

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;

class IndexController 
{
    public function __construct()
    {
        // dd(["index"]);

        echo Bitrix::call("scope");

        // echo "index";
    }
}