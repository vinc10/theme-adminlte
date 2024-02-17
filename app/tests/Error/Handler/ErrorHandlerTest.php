<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Tests\Error\Handler;

use Slim\App as SlimApp;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Develop\AdminLTE\App;
use UserFrosting\Develop\AdminLTE\Routes;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Exceptions\AuthExpiredException;
use UserFrosting\Sprinkle\Account\Exceptions\AuthGuardException;
use UserFrosting\Sprinkle\Account\Exceptions\LoggedInException;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

/**
 * Test the handler for AuthGuardException.
 */
class ErrorHandlerTest extends AdminLTETestCase
{
    protected string $mainSprinkle = TestSprinkle::class;

    public function testAuthGuardExceptionHTML(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/AuthGuardException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertSame('/account/sign-in?redirect=%2FAuthGuardException', $response->getHeaderLine('Location'));

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('info', end($messages)['type']); // @phpstan-ignore-line
    }

    public function testAuthGuardExceptionJson(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/AuthGuardException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertJsonResponse([
            'title'       => 'Login Required',
            'description' => 'Please login to continue',
            'status'      => 302
        ], $response);
    }

    public function testAuthExpiredExceptionHTML(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/AuthExpiredException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertSame('/account/sign-in?redirect=%2FAuthExpiredException', $response->getHeaderLine('Location'));

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', end($messages)['type']); // @phpstan-ignore-line
    }

    public function testAuthExpiredExceptionJson(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/AuthExpiredException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertJsonResponse([
            'title'       => 'Session expired',
            'description' => 'Your session has expired.  Please sign in again.',
            'status'      => 302
        ], $response);
    }

    public function testLoggedInExceptionHTML(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/LoggedInException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertSame('/', $response->getHeaderLine('Location'));

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', end($messages)['type']); // @phpstan-ignore-line
    }

    public function testLoggedInExceptionJson(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/LoggedInException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertJsonResponse([
            'title'       => 'Already Logged-in',
            'description' => "Can't access this resource, as you're already logged-in",
            'status'      => 302
        ], $response);
    }
}

class TestRoutes implements RouteDefinitionInterface
{
    public function register(SlimApp $app): void
    {
        $app->get('/AuthGuardException', function () {
            throw new AuthGuardException();
        });
        $app->get('/AuthExpiredException', function () {
            throw new AuthExpiredException();
        });
        $app->get('/LoggedInException', function () {
            throw new LoggedInException();
        });
    }
}

class TestSprinkle extends App
{
    public function getRoutes(): array
    {
        return [
            TestRoutes::class,
        ];
    }
}
