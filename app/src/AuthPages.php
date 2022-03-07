<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\GuestGuard;
use UserFrosting\Theme\AdminLTE\Controller\LoginPageAction;
use UserFrosting\Theme\AdminLTE\Controller\RegisterPageAction;

class AuthPages implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/account', function (RouteCollectorProxy $group) {
            $group->get('/sign-in', LoginPageAction::class)->setName('page.login');
            $group->get('/register', RegisterPageAction::class)->setName('page.register');
        })->add(GuestGuard::class);
    }
}
