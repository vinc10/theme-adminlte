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
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\Adapter\JqueryValidationArrayAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

/**
 * Account settings page.
 *
 * Provides a form for users to modify various properties of their account,
 * such as name, email, locale, etc. Any fields that the user does not have
 * permission to modify will be automatically disabled. This page requires
 * authentication.
 *
 * Middleware: AuthGuard
 * Route: /account/settings
 * Route Name: page.settings
 * Request type: GET
 */
class SettingsPageAction
{
    // Page template
    protected string $template = 'pages/account-settings.html.twig';

    // Request schema for client side form validation
    protected string $accountSchema = 'schema://requests/account-settings.yaml';
    protected string $profileSchema = 'schema://requests/profile-settings.yaml';

    /**
     * Inject dependencies.
     *
     * @param Authenticator                $authenticator
     * @param AuthorizationManager         $authorizer
     * @param Config                       $config
     * @param SiteLocaleInterface          $siteLocale
     * @param JqueryValidationArrayAdapter $validator
     * @param Twig                         $view
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected AuthorizationManager $authorizer,
        protected Config $config,
        protected SiteLocaleInterface $siteLocale,
        protected JqueryValidationArrayAdapter $validator,
        protected Twig $view,
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
        $this->validateAccess();
        $payload = $this->handle($request);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        // Access-controlled page
        if (!$this->authorizer->checkAccess($this->authenticator->user(), 'uri_account_settings')) {
            throw new ForbiddenException();
        }
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
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];

        // Get a list of all locales
        // Hide the locale field if there is only 1 locale available
        $locales = $this->siteLocale->getAvailableOptions();
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        return [
            'locales' => $locales,
            'fields'  => $fields,
            'page'    => [
                'validators' => [
                    'account_settings' => $this->validator->rules($this->getAccountSchema()),
                    'profile_settings' => $this->validator->rules($this->getProfileSchema()),
                ],
                'visibility' => ($this->authorizer->checkAccess($this->authenticator->user(), 'update_account_settings') ? '' : 'disabled'),
            ],
        ];
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getAccountSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->accountSchema);
        $schema->set('password.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('password.validators.length.max', $this->config->get('site.password.length.max'));
        $schema->set('passwordc.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('passwordc.validators.length.max', $this->config->get('site.password.length.max'));

        return $schema;
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getProfileSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->profileSchema);

        return $schema;
    }
}
