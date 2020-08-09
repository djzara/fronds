<?php

declare(strict_types=1);

namespace Fronds\Lib\Enums;

class StringEnum extends TypeEnum
{

    /**
     * For this kind of enum, we only really need the data type
     * @return string
     */
    public function value(): string
    {
        return $this->type();
    }

    protected function type(): string
    {
        return parent::$typeName;
    }
}
