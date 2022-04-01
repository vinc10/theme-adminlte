<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Theme\AdminLTE\Tests;

use UserFrosting\Develop\AdminLTE\App;
use UserFrosting\Testing\TestCase;

/**
 * Test case with App as main sprinkle
 */
class AdminLTETestCase extends TestCase
{
    protected string $mainSprinkle = App::class;
}
