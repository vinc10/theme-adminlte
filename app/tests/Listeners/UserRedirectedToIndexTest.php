<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Tests\Integration\Event;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Event\UserAuthenticatedEvent;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;
use UserFrosting\Sprinkle\Account\Listener\UpgradePassword;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Theme\AdminLTE\Listener\UserRedirectedToIndex;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class UserRedirectedToIndexTest extends AdminLTETestCase
{
    use MockeryPHPUnitIntegration;

    public function testEvent(): void
    {
        $event = new UserRedirectedAfterLoginEvent();
        $this->assertNull($event->getRedirect());

        /** @var UserRedirectedToIndex */
        $listener = $this->ci->get(UserRedirectedToIndex::class);
        $listener($event);
        
        $this->assertSame('/', $event->getRedirect());
    }
}
