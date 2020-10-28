<?php

declare(strict_types=1);

namespace Fronds\Lib\Enums;

use InvalidArgumentException;

use function in_array;

/**
 * Class TypeEnum
 *
 * @package Fronds\Lib\Enums
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class TypeEnum implements Enum
{
    protected const ALLOWED_TYPES = [
        'bool', 'int', 'array', 'object', 'string', 'iterable', 'callable'
    ];

    protected function __construct()
    {
    }

    protected static string $typeName;

    public static function name(string $typeName): ?TypeEnum
    {
        if (!in_array($typeName, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('Invalid Type for this Enum');
        }
        self::$typeName = $typeName;

        return new static();
    }

    public function getClass(): string
    {
        return static::class;
    }

    public function value(): string
    {
        return self::$typeName;
    }
}
