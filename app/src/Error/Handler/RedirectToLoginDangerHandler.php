<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Error\Handler;

/**
 * Redirect the user to the login page with danger alert.
 */
final class RedirectToLoginDangerHandler extends AbstractRedirectExceptionHandler
{
    protected string $type = 'danger';
    protected string $route = 'page.login';
}
