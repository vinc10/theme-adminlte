<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Listener;

use Slim\Interfaces\RouteParserInterface;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;

/**
 * Set redirect for Login Activity
 */
class UserRedirectedAfterLogin
{
    public function __construct(
        protected RouteParserInterface $routeParser,
    ) {
    }

    public function __invoke(UserRedirectedAfterLoginEvent $event): void
    {
        $path = $this->routeParser->urlFor('index');
        $event->setRedirect($path);
    }
}
