<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Tests\Controller;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class SettingsPageActionTest extends AdminLTETestCase
{
    use RefreshDatabase;
    use MockeryPHPUnitIntegration;

    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testPage(): void
    {
        // Force config
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.locales.available', ['en_US' => true]);
        $config->set('reserved_user_ids.master', 0); // Prevent user from being master

        /** @var User */
        $user = User::factory()->create();

        /** @var Authenticator */
        $authenticator = Mockery::mock(Authenticator::class)
            ->makePartial()
            ->shouldReceive('user')->andReturn($user)
            ->getMock();
        $this->ci->set(Authenticator::class, $authenticator);

        /** @var AuthorizationManager */
        $authorizer = Mockery::mock(AuthorizationManager::class)
            ->shouldReceive('checkAccess')->with($user, 'uri_account_settings', Mockery::andAnyOtherArgs())->times(2)->andReturn(true) // Once from the template !
            ->shouldReceive('checkAccess')->with($user, 'update_account_settings')->once()->andReturn(true)
            ->getMock();
        $this->ci->set(AuthorizationManager::class, $authorizer);

        $request = $this->createRequest('GET', '/account/settings');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);
    }

    public function testPageWithNoPermissions(): void
    {
        // Force config
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.locales.available', ['en_US' => true]);
        $config->set('reserved_user_ids.master', 0); // Prevent user from being master

        /** @var User */
        $user = User::factory()->create();

        /** @var Authenticator */
        $authenticator = Mockery::mock(Authenticator::class)
            ->makePartial()
            ->shouldReceive('user')->andReturn($user)
            ->getMock();
        $this->ci->set(Authenticator::class, $authenticator);

        $request = $this->createJsonRequest('GET', '/account/settings');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(403, $response);
        $this->assertJsonResponse('Access Denied', $response, 'title');
    }
}
