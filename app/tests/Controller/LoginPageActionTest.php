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

use UserFrosting\Theme\AdminLTE\Tests\AdminLTETestCase;

class LoginPageActionTest extends AdminLTETestCase
{
    public function testPage(): void
    {
        $request = $this->createJsonRequest('GET', '/account/sign-in');
        $response = $this->handleRequest($request);
        $this->assertResponse('', $response);
        $this->assertResponseStatus(200, $response);
    }
}
