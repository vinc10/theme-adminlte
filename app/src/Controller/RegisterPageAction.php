<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\Adapter\JqueryValidationArrayAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

/**
 * Render the account registration page for UserFrosting.
 *
 * This allows new (non-authenticated) users to create a new account for themselves on your website (if enabled).
 * By definition, this is a "public page" (does not require authentication).
 *
 * Middleware: GuestGuard
 * Route: /account/register
 * Route Name: page.register
 * Request type: GET
 */
class RegisterPageAction
{
    // Page template
    protected string $template = 'pages/register.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/register.yaml';

    /**
     * Inject dependencies.
     *
     * @param Config              $config
     * @param SiteLocaleInterface $siteLocale
     * @param Translator          $translator
     * @param Twig                $view
     */
    public function __construct(
        protected Config $config,
        protected SiteLocaleInterface $siteLocale,
        protected Translator $translator,
        protected Twig $view,
        protected JqueryValidationArrayAdapter $validator,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = $this->handle($request);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Destroy the session.
     *
     * @param Request $request
     *
     * @return mixed[]
     */
    protected function handle(Request $request): array
    {
        if ($this->config->get('site.registration.enabled') === false) {
            throw new HttpNotFoundException($request);
        }

        // Load the request schema
        $schema = $this->getSchema();

        // Get locale information
        $currentLocale = $this->translator->getLocale()->getIdentifier();

        // Hide the locale field if there is only 1 locale available
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];

        // Get a list of all locales
        $locales = $this->siteLocale->getAvailableOptions();
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        return [
            'page' => [
                'validators' => [
                    'register' => $this->validator->rules($schema),
                ],
            ],
            'fields'  => $fields,
            'locales' => [
                'available' => $locales,
                'current'   => $currentLocale,
            ],
        ];
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->schema);
        $schema->set('password.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('password.validators.length.max', $this->config->get('site.password.length.max'));
        $schema->set('passwordc.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('passwordc.validators.length.max', $this->config->get('site.password.length.max'));

        return $schema;
    }
}
