<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\Fenix\App\Controller\IndexController;
use Beupsoft\Fenix\App\Controller\InstallController;

class Kernel
{
    public function __construct(string $requestUri)
    {
        $route = $this->extract($requestUri);
        $this->execute($route);
    }

    private function execute(string $route): void
    {
        match ($route) {
            "/" => new IndexController,
            "/install" => new InstallController,
            // "/listener/spa"
            // "/listener/deal"
            default => throw new \Exception(message: "Controller $route not found", code: 404),
        };
    }

    private function extract(string $url): string
    {
        return parse_url($url, PHP_URL_PATH);
    }
}
