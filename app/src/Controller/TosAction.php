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

/**
 * Returns a modal containing account terms of service.
 *
 * This does NOT render a complete page. Instead, it renders the HTML for the
 * form, which can be embedded in other pages.
 *
 * Middleware: none
 * Route: /modals/account/tos
 * Route Name: modal.tos
 * Request type: GET
 */
class TosAction
{
    /**
     * Inject dependencies.
     *
     * @param Twig $view
     */
    public function __construct(
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
        return $this->view->render($response, 'modals/tos.html.twig');
    }
}
