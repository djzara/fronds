<?php

declare(strict_types=1);

namespace Tests\Unit\Lib\Enums;

use Fronds\Lib\Enums\TypeEnum;
use Tests\TestCase;
use InvalidArgumentException;

/**
 * Class TypeEnumTest
 *
 * @package Tests\Unit\Lib\Enums
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class TypeEnumTest extends TestCase
{

    public function testInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Type for this Enum');
        TypeEnum::name('definitely not valid');
    }

    public function testValidMainType(): void
    {
        $intEnum = TypeEnum::name('int');
        $boolEnum = TypeEnum::name('bool');
        self::assertInstanceOf(TypeEnum::class, $intEnum);
        self::assertInstanceOf(TypeEnum::class, $boolEnum);
    }

    public function testValidIntrospection(): void
    {
        $typeEnum = TypeEnum::name('string');
        self::assertEquals(TypeEnum::class, $typeEnum->getClass());
    }

    public function testTypeValue(): void
    {
        $enumName = 'string';
        $typeEnum = TypeEnum::name($enumName);
        self::assertEquals($enumName, $typeEnum->value());
    }
}
