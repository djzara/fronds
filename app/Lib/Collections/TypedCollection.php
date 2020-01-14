<?php


namespace Fronds\Lib\Collections;


use Illuminate\Support\Collection;

/**
 * Class TypedCollection
 * @package Fronds\Lib\Collections
 * @codeCoverageIgnore not implemented
 */
abstract class TypedCollection extends Collection
{

    /**
     * Adds a little bit of type safety to collection contents. Any collection of this type should only
     * contain elements of that class
     * @return string
     */
    abstract public function typeClass(): string;

    /**
     * Retrieve the underlying collection class
     * @return Collection
     */
    abstract public function toGenericCollection(): Collection;

}
