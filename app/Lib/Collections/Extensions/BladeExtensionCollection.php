<?php

declare(strict_types=1);

namespace Fronds\Lib\Collections\Extensions;

use Fronds\Lib\Collections\TypedCollection;
use Fronds\Lib\Extensions\Blade\BladeExtension;
use Illuminate\Support\Collection;

/**
 * Class BladeExtensionCollection
 *
 * @package Fronds\Lib\Collections\Extensions
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class BladeExtensionCollection extends TypedCollection
{

    /**
     * @return Collection
     * @codeCoverageIgnore
     */
    public function toGenericCollection(): Collection
    {
        return collect($this->toArray());
    }

    protected function storesClass(): string
    {
        return BladeExtension::class;
    }
}
