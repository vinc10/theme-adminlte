<?php

declare(strict_types=1);

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
use UserFrosting\Sprinkle\Account\Controller\CheckUsernameAction as AccountCheckUsernameAction;

/**
 * Overwrite the default "account.check-username" routes.
 *
 * Replace the body rendering to match Jquery Validator requirements.
 */
class CheckUsernameAction extends AccountCheckUsernameAction
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = $this->handle($request);
        if ($payload['available'] === true) {
            $response->getBody()->write('true');
        } else {
            // @phpstan-ignore-next-line Message is always string
            $response->getBody()->write($payload['message']);
        }

        return $response;
    }
}
