<?php

declare(strict_types=1);

namespace Fronds\Lib\Collections\Extensions;

use Fronds\Lib\Collections\TypedCollection;
use Fronds\Lib\Extensions\Blade\BladeExtension;
use Illuminate\Support\Collection;

class BladeExtensionCollection extends TypedCollection
{
    public function toGenericCollection(): Collection
    {
        return collect($this->toArray());
    }

    protected function storesClass(): string
    {
        return BladeExtension::class;
    }
}
