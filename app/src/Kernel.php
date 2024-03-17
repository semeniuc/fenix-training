<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\Fenix\App\Controller\IndexController;
use Beupsoft\Fenix\App\Controller\InstallController;
use Beupsoft\Fenix\App\Controller\SubscriptionController;

class Kernel
{
    public function __construct(string $requestUri)
    {
        $route = $this->getRoute($this->getArguments($requestUri));
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

    private function getArguments(string $uri): array
    {
        $args = [];
        $query = parse_url($uri, PHP_URL_QUERY);

        if (!empty($query)) {
            $parts = explode("&", $query);
            foreach ($parts as $part) {
                $pair = explode("=", $part);
                if ($pair[0]) {
                    $args[$pair[0]] = $pair[1] ?? null;
                }
            }
        }

        return $args;
    }

    private function getRoute(array $args = []): string
    {
        return ($args["event"]) ? "/" . $args["event"] : "/";
    }

    private function test(string $name): void
    {
        require_once(dirname(__DIR__) . "/tests/" . $name . ".php");
    }

    private function request(string $name): void
    {
        require_once(dirname(__DIR__) . "/tests/requests/" . $name . ".php");
    }
}
