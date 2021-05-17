<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Repositories\Structure\MenuDefinitionRepository;

/**
 * Class FrondsRenderMenu
 *
 * @package Fronds\Lib\Extensions\Blade
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FrondsRenderMenu implements BladeExtension
{

    private MenuDefinitionRepository $menuDefRepo;

    public function __construct()
    {
        $this->menuDefRepo = resolve(MenuDefinitionRepository::class);
    }

    /**
     * @param  mixed  $arguments
     * @return mixed|void
     */
    public function getExtensionSource($arguments)
    {
        // TODO: Implement getExtensionSource() method.
    }

    public function getArguments(): array
    {
        return [];
    }

    public function getName(): string
    {
        return 'frondsRenderMenu';
    }

    public function withValues(array $arguments): void
    {
        // TODO: Implement withValues() method.
    }
}
