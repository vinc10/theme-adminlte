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

use UserFrosting\Sprinkle\Core\Event\Contract\RedirectingEventInterface;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/**
 * Set redirect to login.
 */
class UserRedirectedToLogin
{
    /**
     * Inject dependencies.
     *
     * @param RouteParserInterface $routeParser
     */
    public function __construct(
        protected RouteParserInterface $routeParser,
    ) {
    }

    public function __invoke(RedirectingEventInterface $event): void
    {
        $path = $this->routeParser->urlFor('page.login', fallbackRoute: '/login');
        $event->setRedirect($path);
    }
}
