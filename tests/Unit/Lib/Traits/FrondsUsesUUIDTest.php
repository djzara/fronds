<?php

declare(strict_types=1);

namespace Tests\Unit\Lib\Traits;

use Fronds\Models\MenuDefinition;
use Tests\TestCase;

/**
 * Class FrondsUsesUUIDTest
 *
 * @package Tests\Unit\Lib\Traits
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FrondsUsesUUIDTest extends TestCase
{

    public function testAutoAddsUUID(): void
    {
        // for now just use something we know uses the trait
        $menuDef = MenuDefinition::create(['menu_title' => 'uuid test', 'menu_type' => 'list']);
        self::assertNotNull($menuDef->uuid);
    }
}
