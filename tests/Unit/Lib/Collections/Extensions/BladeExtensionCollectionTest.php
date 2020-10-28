<?php

declare(strict_types=1);

namespace Tests\Unit\Lib\Collections\Extensions;

use Fronds\Lib\Collections\Extensions\BladeExtensionCollection;
use Fronds\Lib\Extensions\Blade\BladeExtension;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Class BladeExtensionCollectionTest
 *
 * @package Tests\Unit\Lib\Collections\Extensions
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class BladeExtensionCollectionTest extends TestCase
{

    public function testReturnsCorrectClass(): void
    {
        $bladeExtColl = new BladeExtensionCollection();
        self::assertEquals(BladeExtension::class, $bladeExtColl->typeClass());
    }
}
