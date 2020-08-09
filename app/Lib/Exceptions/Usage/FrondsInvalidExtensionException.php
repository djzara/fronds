<?php

declare(strict_types=1);

namespace Fronds\Lib\Exceptions\Usage;

use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

class FrondsInvalidExtensionException extends FrondsException
{
    public function getExceptionCode(): int
    {
        return ExceptionConstants::FRONDS_INTERNAL | ExceptionConstants::INVALID_TYPE;
    }

    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_SERVER_ERROR;
    }

}
