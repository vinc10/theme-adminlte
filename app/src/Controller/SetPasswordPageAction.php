<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Exceptions\PasswordResetInvalidException;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;

/**
 * Reset password page.
 *
 * Renders the new password page for password reset requests.
 *
 * Middleware: GuestGuard
 * Route: /account/set-password/confirm
 * Route Name: account.setPassword.confirm
 * Request type: GET
 */
class SetPasswordPageAction
{
    // Page template
    protected string $template = 'pages/reset-password.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/set-password.yaml';

    /**
     * Inject dependencies.
     *
     * @param Twig                    $view
     * @param Translator              $translator
     * @param Config                  $config
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(
        protected Twig $view,
        protected Translator $translator,
        protected Config $config,
        protected PasswordResetRepository $passwordResetRepository,
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
        $params = $request->getQueryParams();
        $schema = $this->getSchema();
        $validatorLogin = new JqueryValidationAdapter($schema, $this->translator);

        // Check validity of token.
        $token = $params['token'] ?? '';
        if (!$this->passwordResetRepository->validate($token)) {
            throw new PasswordResetInvalidException();
        }

        return [
            'page' => [
                'validators' => [
                    'set_password' => $validatorLogin->rules('json', false),
                ],
            ],
            'token' => $token,
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
