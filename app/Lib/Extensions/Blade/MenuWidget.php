<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Extensions\ExtensionBuilder;

/**
 * Class MenuWidget
 *
 * @package Fronds\Lib\Extensions\Blade
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 * @codeCoverageIgnore
 */
class MenuWidget extends ExtensionBuilder implements BladeExtension
{

    /**
     * @inheritDoc
     */
    public function getExtensionSource($arguments)
    {
        //$this->validateArguments($arguments);
        return <<<HTML
    <ul class="fronds-list-nav fronds-list text-center">
HTML;
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @return $this|BladeExtension
     */
    protected function getExtension(): BladeExtension
    {
        return $this;
    }
}
