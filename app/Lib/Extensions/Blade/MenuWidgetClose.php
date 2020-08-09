<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Extensions\ExtensionBuilder;

class MenuWidgetClose extends ExtensionBuilder implements BladeExtension
{
    public function getExtensionSource($arguments)
    {
        return '</ul>';
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function withValues(array $arguments): void
    {
        // TODO: Implement withValues() method.
    }

    public static function build(): ExtensionBuilder
    {
        return new self();
    }

    protected function getExtension(): BladeExtension
    {
        return $this;
    }
}
