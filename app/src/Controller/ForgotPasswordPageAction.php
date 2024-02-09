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
use UserFrosting\Fortress\Adapter\JqueryValidationArrayAdapter;
use UserFrosting\Fortress\RequestSchema;

/**
 * Render the "forgot password" page.
 *
 * This creates a simple form to allow users who forgot their password to have
 * a time-limited password reset link emailed to them. By default, this is a
 * "public page" (does not require authentication).
 *
 * Middleware: GuestGuard
 * Route: /account/forgot-password
 * Route Name: page.forgot-password
 * Request type: GET
 */
class ForgotPasswordPageAction
{
    // Page template
    protected string $template = 'pages/forgot-password.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/forgot-password.yaml';

    /**
     * Inject dependencies.
     *
     * @param Twig                         $view
     * @param JqueryValidationArrayAdapter $validator
     */
    public function __construct(
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
        $schema = new RequestSchema($this->schema);

        return [
            'page' => [
                'validators' => [
                    'forgot_password' => $this->validator->rules($schema),
                ],
            ],
        ];
    }
}
