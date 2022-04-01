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

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandler;
use UserFrosting\Sprinkle\Core\Error\Renderer\JsonRenderer;
use UserFrosting\Sprinkle\Core\Log\ErrorLogger;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use UserFrosting\Theme\AdminLTE\Error\Renderer\EmptyRenderer;

/**
 * Abstract extension handler that will redirect the user after the error
 * message to the alert stream.
 */
abstract class AbstractRedirectExceptionHandler extends ExceptionHandler
{
    /**
     * @var string[] Renderers for specific content types.
     */
    protected array $errorRenderers = [
        'application/json' => JsonRenderer::class,
        'text/html'        => EmptyRenderer::class,
    ];

    /**
     * @param ContainerInterface $ci
     * @param ResponseFactory    $responseFactory
     * @param Config             $config
     * @param Translator         $translator
     */
    public function __construct(
        protected ContainerInterface $ci,
        protected ResponseFactory $responseFactory,
        protected Config $config,
        protected Translator $translator,
        protected ErrorLogger $logger,
        protected AlertStream $alert,
        protected RouteParserInterface $routeParser,
    ) {
        parent::__construct($ci, $responseFactory, $config, $translator, $logger);
    }

    /**
     * Add redirect header.
     * {@inheritDoc}
     */
    public function renderResponse(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $response = parent::renderResponse($request, $exception);
        $path = $this->determineRoute();

        return $response->withHeader('Location', $path);
    }

    /**
     * Add alert message header.
     * {@inheritDoc}
     */
    protected function determineUserMessage(Throwable $exception, int $statusCode): Message
    {
        $message = parent::determineUserMessage($exception, $statusCode);

        // Add Alert if required
        $type = $this->determineAlertType();
        if ($type !== null) {
            $this->alert->addMessageTranslated($type, $message->title);
        }

        return $message;
    }

    /**
     * Never log.
     */
    protected function shouldLogExceptions(): bool
    {
        return false;
    }

    /**
     * Never display error details.
     */
    protected function displayErrorDetails(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function determineStatusCode(ServerRequestInterface $request, Throwable $exception): int
    {
        return 302;
    }

    /**
     * Return redirect route.
     *
     * @return string
     */
    abstract protected function determineRoute(): string;

    /**
     * Return alert type. Null for no alerts.
     *
     * @return string|null
     */
    abstract protected function determineAlertType(): ?string;
}
