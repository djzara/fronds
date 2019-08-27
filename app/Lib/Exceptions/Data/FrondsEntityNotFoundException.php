<?php


namespace Fronds\Lib\Exceptions\Data;

use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

/**
 * Class FrondsEntityNotFoundException
 * @package Fronds\Lib\Exceptions\Data
 */
class FrondsEntityNotFoundException extends FrondsException
{
    public function getExceptionCode(): int
    {
        return ExceptionConstants::FRONDS_DATA
            | ExceptionConstants::COULD_NOT_FIND
            | ExceptionConstants::FRONDS_ERROR;
    }

    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_NOT_FOUND;
    }

}