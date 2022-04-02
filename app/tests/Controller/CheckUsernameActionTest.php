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
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class CheckUsernameActionTest extends AdminLTETestCase
{
    use MockeryPHPUnitIntegration;
    use RefreshDatabase;

    /**
     * Setup test database for controller tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testCheckUsername(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/check-username')
                        ->withQueryParams(['user_name' => 'potato']);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponse('true', $response);
        $this->assertResponseStatus(200, $response);
    }

    public function testCheckUsernameWithUsernameNotAvailable(): void
    {
        // Create test user
        /** @var User */
        $user = User::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/check-username')
                        ->withQueryParams(['user_name' => $user->user_name]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $text = "Username <strong>{$user->user_name}</strong> is not available. Choose a different name, or click 'suggest'.";
        $this->assertResponse($text, $response);
        $this->assertResponseStatus(200, $response);
    }
}
