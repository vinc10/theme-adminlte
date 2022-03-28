<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE;

use UserFrosting\Event\EventListenerRecipe;
use UserFrosting\Sprinkle\Account\Account;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLogoutEvent;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterVerificationEvent;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\SprinkleRecipe;
use UserFrosting\Theme\AdminLTE\Listener\UserRedirectedToIndex;
use UserFrosting\Theme\AdminLTE\ServicesProvider\ControllerService;
use UserFrosting\Theme\AdminLTE\ServicesProvider\ErrorHandlerService;

class AdminLTE implements SprinkleRecipe, EventListenerRecipe
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'AdminLTE Theme';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return __DIR__ . '/../';
    }

    /**
     * {@inheritdoc}
     */
    public function getBakeryCommands(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSprinkles(): array
    {
        return [
            Core::class,
            Account::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return [
            AuthPages::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return [
            ControllerService::class,
            ErrorHandlerService::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddlewares(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListeners(): array
    {
        return [
            UserRedirectedAfterLogoutEvent::class => [
                UserRedirectedToIndex::class,
            ],
            UserRedirectedAfterLoginEvent::class => [
                UserRedirectedToIndex::class,
            ],
            UserRedirectedAfterVerificationEvent::class => [
                UserRedirectedToIndex::class,
            ],
        ];
    }
}
