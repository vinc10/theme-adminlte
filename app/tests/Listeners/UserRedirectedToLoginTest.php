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
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterDenyResetPasswordEvent;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;
use UserFrosting\Sprinkle\Account\Listener\UpgradePassword;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Theme\AdminLTE\Listener\UserRedirectedToIndex;
use UserFrosting\Theme\AdminLTE\Listener\UserRedirectedToLogin;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class UserRedirectedToLoginTest extends AdminLTETestCase
{
    use MockeryPHPUnitIntegration;

    public function testEvent(): void
    {
        $event = new UserRedirectedAfterDenyResetPasswordEvent();
        $this->assertNull($event->getRedirect());

        /** @var UserRedirectedToIndex */
        $listener = $this->ci->get(UserRedirectedToLogin::class);
        $listener($event);
        
        $this->assertSame('/account/sign-in', $event->getRedirect());
    }
}
