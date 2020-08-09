<?php


namespace Fronds\Lib\Collections;

use Fronds\Lib\Exceptions\Usage\FrondsIllegalArgumentException;
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
    public function typeClass(): string
    {
        return static::storesClass();
    }

    /**
     * This allows for the validation of incoming data to ensure it
     * matches the type declared by this collection
     * @return string
     */
    abstract protected function storesClass(): string;

    /**
     * Retrieve the underlying collection class
     * @return Collection
     */
    abstract public function toGenericCollection(): Collection;

    /**
     * @param  mixed  $item
     * @return static
     * @throws FrondsIllegalArgumentException
     */
    public function add($item): TypedCollection
    {
        $collectionType = static::storesClass();
        if (!($item instanceof $collectionType)) {
            throw new FrondsIllegalArgumentException('Invalid Collection Type');
        }
        parent::add($item);
        return $this;
    }
}
