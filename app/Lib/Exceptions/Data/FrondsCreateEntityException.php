<?php

namespace Fronds\Lib\Exceptions\Data;

use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

/**
 * Class FrondsCreateEntityException
 * @package Fronds\Lib\Exceptions\Data
 */
class FrondsCreateEntityException extends FrondsException
{

    public function getExceptionCode(): int
    {
        return ExceptionConstants::COULD_NOT_CREATE
            & ExceptionConstants::FRONDS_DATA
            & ExceptionConstants::FRONDS_HALT;
    }

    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_SERVER_ERROR;
    }

}
