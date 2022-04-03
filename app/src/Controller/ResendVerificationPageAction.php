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
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\I18n\Translator;

/**
 * Render the "resend verification email" page.
 *
 * This is a form that allows users who lost their account verification link to
 * have the link resent to their email address. By default, this is a "public
 * page" (does not require authentication).
 *
 * Middleware: GuestGuard
 * Route: /account/resend-verification
 * Route Name: page.resend-verification
 * Request type: GET
 */
class ResendVerificationPageAction
{
    // Page template
    protected string $template = 'pages/resend-verification.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/resend-verification.yaml';

    /**
     * Inject dependencies.
     *
     * @param Twig       $view
     * @param Translator $translator
     */
    public function __construct(
        protected Twig $view,
        protected Translator $translator,
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
        $validatorLogin = new JqueryValidationAdapter($schema, $this->translator);

        return [
            'page' => [
                'validators' => [
                    'resend_verification' => $validatorLogin->rules('json', false),
                ],
            ],
        ];
    }
}
