<?php

namespace Google\Auth\Tests;

use Google\Auth\HttpHandler\Guzzle7HttpHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

trait HelperTrait
{
    private function getHandler(array $mockResponses = []): Guzzle7HttpHandler
    {
        $mock = new MockHandler($mockResponses);
        $handler = HandlerStack::create($mock);
        $client = new Client(["handler" => $handler]);

        return new Guzzle7HttpHandler($client);
    }

    private function setHomeEnv(?string $value): void
    {
        $assigment = sprintf(
            "%s%s%s",
            PHP_OS_FAMILY === "Windows" ? "APPDATA" : "HOME",
            $value === null ? "" : "=",
            (string) $value
        );

        putenv($assigment);
    }

    private function skipResidencyCheck(bool $skip = true): void
    {
        $prop = new \ReflectionProperty(
            \Google\Auth\Credentials\GCECredentials::class,
            'checkResidency'
        );
        $prop->setValue(null, !$skip);
    }
}
