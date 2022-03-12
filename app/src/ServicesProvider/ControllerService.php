<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\ServicesProvider;

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Account\Controller\CheckUsernameAction;
use UserFrosting\Theme\AdminLTE\Controller\CheckUsernameAction as ThemeCheckUsernameAction;

/**
 * Map models interface to the class.
 *
 * Note both class are map using class-string, since Models are not instantiated
 * by the container in the Eloquent world.
 */
class ControllerService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            CheckUsernameAction::class => \DI\autowire(ThemeCheckUsernameAction::class),
        ];
    }
}
