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
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Theme\AdminLTE\Controller\TosAction;

class TosPages implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->get('/modals/account/tos', TosAction::class)->setName('modal.tos');
    }
}
