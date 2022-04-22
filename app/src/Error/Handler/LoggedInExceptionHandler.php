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
 * Handler for LoggedInException. Redirect to index.
 */
final class LoggedInExceptionHandler extends AbstractRedirectExceptionHandler
{
    /**
     * Return redirect route.
     * 
     * @param string $queryParams
     *
     * @return string
     */
    protected function determineRoute(string $queryParams): string
    {
        return $this->routeParser->urlFor('index');
    }

    /**
     * Return redirect route.
     *
     * @return string
     */
    protected function determineAlertType(): ?string
    {
        return null;
    }
}
