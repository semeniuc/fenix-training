<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;

class InstallController
{
    public function __construct()
    {
        $this->response(Bitrix::installApp()['install']);
    }

    private function response(bool $isSuccessInstall): void
    {
        $htmlHead = 
        "<head>
            <script src=\"//api.bitrix24.com/api/v1/\"></script>
            <script>
                BX24.init(function () {
                    BX24.installFinish();
                });
            </script>
        </head>";

        if ($isSuccessInstall === true) {
            echo $htmlHead . "<body>installation has been finished</body>";
        } else {
            echo $htmlHead . "<body>installation error</body>";
        }
    }
}
