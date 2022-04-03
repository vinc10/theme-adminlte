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

use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class SettingsPageActionTest extends AdminLTETestCase
{
    use RefreshDatabase;

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
        
        /** @var User */
        $user = User::factory()->create();

        /** @var Authenticator */
        $authenticator = $this->ci->get(Authenticator::class);
        $authenticator->login($user);
        
        $request = $this->createRequest('GET', '/account/settings');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);

        $authenticator->logout();
    }
}
