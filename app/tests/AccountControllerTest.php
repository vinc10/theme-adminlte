<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Integration\Controller;

use Mockery as m;
use UserFrosting\Sprinkle\Account\Controller\AccountController;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\withTestUser;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
// use UserFrosting\Sprinkle\Core\Tests\withController;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Support\Exception\NotFoundException;

/**
 * Tests AccountController.
 */
class AccountControllerTest extends AccountTestCase
{
    use RefreshDatabase;
    // use withTestUser;
    // use withController;

    /**
     * @var bool DB is initialized for normal db
     */
    protected static $initialized = false;

    /**
     * Setup test database for controller tests.
     */
    /*public function setUp(): void
    {
        parent::setUp();
        // $this->setupTestDatabase();

        if ($this->usingInMemoryDatabase() || !static::$initialized) {

            // Setup database, then setup User & default role
            $this->refreshDatabase();
            static::$initialized = true;
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }*/

    /**
     * @return AccountController
     */
    /*public function testControllerConstructor()
    {
        $controller = $this->getController();
        $this->assertInstanceOf(AccountController::class, $controller);

        return $controller;
    }*/

    /**
     * @depends testControllerConstructor
     *
     * @param AccountController $controller
     */
    /*public function testgetModalAccountTos(AccountController $controller)
    {
        $result = $controller->getModalAccountTos($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @param AccountController $controller
     */
    /*public function testpageForgotPassword(AccountController $controller)
    {
        $result = $controller->pageForgotPassword($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @param AccountController $controller
     */
    /*public function testpageRegister(AccountController $controller)
    {
        $result = $controller->pageRegister($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @depends testpageRegister
     */
    /*public function testpageRegisterWithDisabledRegistration()
    {
        // Force config
        $this->ci->config['site.registration.enabled'] = false;

        // Recreate controller to use new config
        $controller = $this->getController();

        $this->expectException(NotFoundException::class);
        $controller->pageRegister($this->getRequest(), $this->getResponse(), []);
    }

    /**
     * @depends testControllerConstructor
     * @depends testpageRegister
     */
    /*public function testpageRegisterWithNoLocales()
    {
        // Force config
        $this->ci->config['site.locales.available'] = [];

        // Recreate controller to use new config
        $controller = $this->getController();

        $result = $controller->pageRegister($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @depends testpageRegister
     */
    /*public function testpageRegisterWithLoggedInUser()
    {
        // Create a test user
        $testUser = $this->createTestUser(false, true);

        // Recreate controller to use fake throttler
        $controller = $this->getController();

        $result = $controller->pageRegister($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 302);
    }

    /**
     * @depends testControllerConstructor
     */
    /*public function testpageSettings()
    {
        // Create admin user. He will have access
        $testUser = $this->createTestUser(true, true);

        // Recreate controller to use user
        $controller = $this->getController();

        $this->actualpageSettings($controller);
    }

    /**
     * @depends testControllerConstructor
     * @depends testpageSettings
     */
    /*public function testpageSettingsWithPartialPermissions()
    {
        // Create a user and give him permissions
        $testUser = $this->createTestUser(false, true);
        $this->giveUserTestPermission($testUser, 'uri_account_settings');

        // Force config
        $this->ci->config['site.locales.available'] = [];

        // Recreate controller to use config & user
        $controller = $this->getController();

        $this->actualpageSettings($controller);
    }

    /**
     * @param AccountController $controller
     */
    /*protected function actualpageSettings(AccountController $controller)
    {
        $result = $controller->pageSettings($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @param AccountController $controller
     */
    /*public function testpageSettingsWithNoPermissions(AccountController $controller)
    {
        $this->expectException(ForbiddenException::class);
        $controller->pageSettings($this->getRequest(), $this->getResponse(), []);
    }

    /**
     * @depends testControllerConstructor
     * @param AccountController $controller
     */
    /*public function testpageSignIn(AccountController $controller)
    {
        $result = $controller->pageSignIn($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', (string) $result->getBody());
    }

    /**
     * @depends testControllerConstructor
     * @depends testpageSignIn
     */
    /*public function testpageSignInWithLoggedInUser()
    {
        // Create a test user
        $testUser = $this->createTestUser(false, true);

        // Recreate controller to use fake throttler
        $controller = $this->getController();

        $result = $controller->pageSignIn($this->getRequest(), $this->getResponse(), []);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 302);
    }

    /**
     * @return AccountController
     */
    protected function getController()
    {
        return new AccountController($this->ci);
    }
}
