<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Exceptions\Usage\FrondsInvalidExtensionException;

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

    public function withValues(array $arguments): void;

}
