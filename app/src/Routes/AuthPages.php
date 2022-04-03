<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\GuestGuard;
use UserFrosting\Theme\AdminLTE\Controller\ForgotPasswordPageAction;
use UserFrosting\Theme\AdminLTE\Controller\LoginPageAction;
use UserFrosting\Theme\AdminLTE\Controller\RegisterPageAction;
use UserFrosting\Theme\AdminLTE\Controller\ResendVerificationPageAction;
use UserFrosting\Theme\AdminLTE\Controller\SetPasswordPageAction;

class AuthPages implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/account', function (RouteCollectorProxy $group) {
            $group->get('/sign-in', LoginPageAction::class)->setName('page.login');
            $group->get('/register', RegisterPageAction::class)->setName('page.register');
            $group->get('/forgot-password', ForgotPasswordPageAction::class)->setName('page.forgot-password');
            $group->get('/resend-verification', ResendVerificationPageAction::class)->setName('page.resend-verification');
            $group->get('/set-password/confirm', SetPasswordPageAction::class)->setName('page.set-password.confirm');
            // $group->get('/settings', 'UserFrosting\Sprinkle\Account\Controller\SettingsPageAction')->setName('page.settings');
        })->add(GuestGuard::class);
    }
}
