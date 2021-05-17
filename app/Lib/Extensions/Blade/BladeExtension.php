<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Exceptions\Usage\FrondsInvalidExtensionException;

/**
 * Interface BladeExtension
 *
 * @package Fronds\Lib\Extensions\Blade
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
interface BladeExtension
{
    /**
     * @param mixed $arguments
     * @return mixed
     * @throws FrondsInvalidExtensionException
     */
    public function getExtensionSource($arguments);

    /**
     * @return array
     */
    public function getArguments(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param  array  $arguments
     */
    public function withValues(array $arguments): void;
}
