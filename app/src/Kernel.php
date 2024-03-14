<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\Fenix\App\Controller\IndexController;
use Beupsoft\Fenix\App\Controller\InstallController;
use Beupsoft\Fenix\App\Controller\SubscriptionController;

class Kernel
{
    public function __construct(string $requestUri)
    {
        $route = $this->extract($requestUri);
        
        if ($route === "/favicon.ico") {
            exit;
        }

        $this->execute($route);
    }

    private function execute(string $route): void
    {
        match ($route) {
            "/" => new IndexController,
            "/install" => new InstallController,
            "/listener" => new SubscriptionController,


            "/test/listener" => $this->test("listener"),
            "/test/events" => $this->test("events"),

            "/request/deal" => $this->request("deal"),
            "/request/training" => $this->request("training"),
            "/request/sections" => $this->request("sections"),
            "/request/event" => $this->request("event"),
            "/request/accessibility" => $this->request("accessibility"),
            "/request/enum" => $this->request("enum"),

            default => throw new \Exception(message: "Controller $route not found", code: 404),
        };
    }

    private function extract(string $url): string
    {
        return parse_url($url, PHP_URL_PATH);
    }

    private function test(string $name):void
    {
        require_once (dirname(__DIR__) . "/tests/" . $name . ".php");
    }

    private function request(string $name):void
    {
        require_once (dirname(__DIR__) . "/tests/requests/" . $name . ".php");
    }
}
