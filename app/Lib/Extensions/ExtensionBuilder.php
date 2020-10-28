<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions;

use Fronds\Lib\Enums\TypeEnum;
use Fronds\Lib\Extensions\Blade\BladeExtension;
use SebastianBergmann\Template\InvalidArgumentException;

/**
 * Class ExtensionBuilder
 *
 * @package Fronds\Lib\Extensions
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
abstract class ExtensionBuilder
{
    protected array $arguments = [];
    protected string $name = '';


    protected function __construct()
    {
    }

    abstract public static function build(): ExtensionBuilder;
    abstract protected function getExtension(): BladeExtension;

    /**
     * You can only set the name once per builder instance
     * @param  string  $name
     * @return $this
     */
    public function name(string $name): ExtensionBuilder
    {
        if ($this->name === '') {
            $this->name = $name;
        }
        return $this;
    }

    public function argument(string $name, TypeEnum $argType, ?string $default = null): ExtensionBuilder
    {
        $this->arguments[] = [
            'arg' => $name,
            'type' => $argType,
            'default' => $default
        ];
        return $this;
    }

    /**
     * @param  array  $inputArgs
     */
    protected function validateArguments(array $inputArgs)
    {
        if (count($inputArgs) < count($this->arguments)) {
            throw new InvalidArgumentException('Invalid number of arguments given to ' . $this->getName());
        }
    }

    /**
     * Automatically registers with the Fronds service provider
     */
    public function get(): BladeExtension
    {
        return static::getExtension();
    }
}
