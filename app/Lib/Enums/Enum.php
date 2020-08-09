<?php

declare(strict_types=1);

namespace Fronds\Lib\Enums;

interface Enum
{

    public function getClass(): string;

    public function value(): string;
}
