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
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class SetPasswordPageActionTest extends AdminLTETestCase
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
        // Create fake PasswordResetRepository
        /** @var PasswordResetRepository */
        $repoPasswordReset = Mockery::mock(PasswordResetRepository::class)
            ->shouldReceive('validate')->with(9999)->once()->andReturn(true)
            ->getMock();
        $this->ci->set(PasswordResetRepository::class, $repoPasswordReset);
        
        $request = $this->createRequest('GET', '/account/set-password/confirm')
                        ->withQueryParams(['token' => 9999]);
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);
    }

    public function testPageWithInvalidToken(): void
    {
        $request = $this->createRequest('GET', '/account/set-password/confirm');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertSame('/account/sign-in?redirect=%2Faccount%2Fset-password%2Fconfirm', $response->getHeaderLine('Location'));

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', array_reverse($messages)[0]['type']);
    }
}
