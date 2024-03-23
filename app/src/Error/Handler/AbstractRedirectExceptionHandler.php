<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Error\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandler;
use UserFrosting\Sprinkle\Core\Error\Renderer\JsonRenderer;
use UserFrosting\Sprinkle\Core\Log\ErrorLoggerInterface;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;
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
     * Inject dependencies.
     *
     * @param ContainerInterface   $ci
     * @param ResponseFactory      $responseFactory
     * @param Config               $config
     * @param Translator           $translator
     * @param ErrorLoggerInterface $logger
     * @param AlertStream          $alert
     * @param RouteParserInterface $routeParser
     */
    public function __construct(
        protected ContainerInterface $ci,
        protected ResponseFactory $responseFactory,
        protected Config $config,
        protected Translator $translator,
        protected ErrorLoggerInterface $logger,
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
        $queryParams = $this->determineQueryParams($request);
        $path = $this->determineRoute($queryParams);

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
            $this->alert->addMessage($type, $message->title);
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
     * Determine the route the user was trying to access, and return it as a
     * string for query param.
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function determineQueryParams(ServerRequestInterface $request): string
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        $query = $uri->getQuery();
        $fragment = $uri->getFragment();

        return $path
            . ($query !== '' ? '?' . $query : '')
            . ($fragment !== '' ? '#' . $fragment : '');
    }

    /**
     * Return redirect route.
     *
     * @param string $queryParams
     *
     * @return string
     */
    abstract protected function determineRoute(string $queryParams): string;

    /**
     * Return alert type. Null for no alerts.
     *
     * @return string|null
     */
    abstract protected function determineAlertType(): ?string;
}
