<?php

namespace Tests;

use NourApi\Framework\Http\Request;

class HttpBehaviorTest extends TestCase
{
    public function testHeadRequestHasNoResponseBody(): void
    {
        $response = $this->app->handle(Request::create('/', 'HEAD'));
        self::assertSame(200, $response->getStatusCode());
        self::assertSame('', $response->getContent());
    }

    public function testMissingRouteReturnsJson404(): void
    {
        $response = $this->app->handle(Request::create('/missing', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']));
        self::assertSame(404, $response->getStatusCode());
        self::assertStringContainsString('application/json', $response->headers->get('Content-Type'));
    }

    public function testDefaultDebugConfigurationDoesNotExposeExceptions(): void
    {
        $this->app['config']->set('app.debug', false);
        $this->app['config']->set('logging.default', 'null');
        $this->app->router->get('/failure', static function () {
            throw new \RuntimeException('private-database-credentials');
        });
        $response = $this->app->handle(Request::create('/failure', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']));
        self::assertSame(500, $response->getStatusCode());
        self::assertSame(['message' => 'Server Error'], json_decode($response->getContent(), true));
    }
}
