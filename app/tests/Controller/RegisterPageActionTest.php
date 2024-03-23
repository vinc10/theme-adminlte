<?php

declare(strict_types=1);

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Tests\Controller;

use UserFrosting\Config\Config;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class RegisterPageActionTest extends AdminLTETestCase
{
    public function testPage(): void
    {
        // Force config
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.locales.available', ['en_US' => true]);
        
        $request = $this->createJsonRequest('GET', '/account/register');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);
    }

    public function testPageWithDisabledRegistration(): void
    {
        // Force config
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.registration.enabled', false);
        
        $request = $this->createJsonRequest('GET', '/account/register');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(404, $response);
    }
}
