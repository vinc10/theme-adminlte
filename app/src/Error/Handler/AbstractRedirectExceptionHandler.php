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
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandlerInterface;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;

/**
 * Abstract extension handler that will redirect the user after the error
 * message to the alert stream.
 */
abstract class AbstractRedirectExceptionHandler implements ExceptionHandlerInterface
{
    protected string $type = 'danger';
    protected string $route = 'page.login';

    public function __construct(
        protected ResponseFactory $responseFactory,
        protected RouteParserInterface $routeParser,
        protected AlertStream $alert,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $this->addMessage($exception);
        $path = $this->routeParser->urlFor($this->route);
        $response = $this->responseFactory->createResponse(302);

        return $response->withHeader('Location', $path);
    }

    /**
     * Add message to Alert Stream.
     *
     * @param Throwable $exception
     */
    protected function addMessage(Throwable $exception): void
    {
        if ($exception instanceof UserMessageException) {
            $userMessage = $exception->getDescription();
            if (is_string($userMessage)) {
                $this->alert->addMessageTranslated($this->type, $userMessage);

                return;
            }

            $this->alert->addMessageTranslated($this->type, $userMessage->message, $userMessage->parameters);

            return;
        }

        $this->alert->addMessageTranslated($this->type, $exception->getMessage());
    }
}
