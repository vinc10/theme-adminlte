<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Error\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandlerInterface;

/**
 * Handler for LoggedInException. Redirect to index.
 */
final class LoggedInExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(
        protected ResponseFactory $responseFactory,
        protected RouteParserInterface $routeParser,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $path = $this->routeParser->urlFor('index');
        $response = $this->responseFactory->createResponse(302);

        return $response->withHeader('Location', $path);
    }
}
