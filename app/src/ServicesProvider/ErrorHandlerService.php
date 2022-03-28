<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\ServicesProvider;

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Account\Exceptions\LoggedInException;
use UserFrosting\Sprinkle\Core\Error\ExceptionHandlerMiddleware;
use UserFrosting\Theme\AdminLTE\Error\Handler\LoggedInExceptionHandler;

class ErrorHandlerService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            ExceptionHandlerMiddleware::class => \DI\decorate(function (ExceptionHandlerMiddleware $middleware) {
                $middleware->registerHandler(LoggedInException::class, LoggedInExceptionHandler::class);

                return $middleware;
            }),
        ];
    }
}
