<?php

namespace Beupsoft\Fenix\App;

class Route
{
    public function __construct(string $requestUri)
    {
        $route = $this->getRoute($this->getArguments($requestUri));
        $this->execute($route);
    }

    private function execute(string $route): void
    {
        match ($route) {
            "/install" => new Install(),
            "/listener" => new Listener(),

            "/get-listeners" => $this->testRequest("listeners"),
            "/get-events" => $this->testRequest("events"),
            "/get-deal" => $this->testRequest("deal"),
            "/get-training" => $this->testRequest("training"),
            "/get-sections" => $this->testRequest("sections"),
            "/get-event" => $this->testRequest("event"),
            "/get-accessibility" => $this->testRequest("accessibility"),
            "/get-enum" => $this->testRequest("enum"),

            default => throw new \Exception(message: "Route $route not found", code: 404),
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
        return (isset($args["event"])) ? "/" . $args["event"] : "/";
    }

    private function testRequest(string $name): void
    {
        require_once(dirname(__DIR__) . "/tests/requests/" . $name . ".php");
    }
}
