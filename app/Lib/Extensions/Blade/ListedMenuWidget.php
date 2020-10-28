<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Extensions\ExtensionBuilder;

/**
 * Class ListedMenuWidget
 *
 * @package Fronds\Lib\Extensions\Blade
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 * @codeCoverageIgnore
 */
class ListedMenuWidget extends ExtensionBuilder implements BladeExtension
{

    public static function build(): ExtensionBuilder
    {
        return new self();
    }


    public function withValues(array $arguments): void
    {
    }

    /**
     * @param string $arguments
     * @return mixed
     */
    public function getExtensionSource($arguments)
    {
        $args = explode(',', $arguments);
        $this->validateArguments($args);

        $menuName = trim($args[0], ' \'"');
        $menuContent = trim($args[1], ' \'"');
        return <<<HTML
    <li class="fronds-list-nav-item" data-fronds-shows-menu="$menuName">
        <a href="#$menuName">$menuContent</a>
    </li>
HTML;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return $this|BladeExtension
     */
    protected function getExtension(): BladeExtension
    {
        return $this;
    }
}
