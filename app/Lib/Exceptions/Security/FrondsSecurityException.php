<?php

namespace Fronds\Lib\Exceptions\Security;

use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

/**
 * Class FrondsSecurityException
 * @package Fronds\Lib\Exceptions\Security
 */
class FrondsSecurityException extends FrondsException
{
    public function getExceptionCode(): int
    {
        return ExceptionConstants::FRONDS_CLIENT
            | ExceptionConstants::FRONDS_HALT
            | ExceptionConstants::ILLEGAL_ACCESS;
    }

    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_INVALID;
    }


}