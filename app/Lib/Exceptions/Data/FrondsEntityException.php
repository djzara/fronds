<?php


namespace Fronds\Lib\Exceptions\Data;

use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

class FrondsEntityException extends FrondsException
{

    /**
     * @return int
     */
    public function getExceptionCode(): int
    {
        return ExceptionConstants::FRONDS_DATA
            & ExceptionConstants::FRONDS_ERROR;
    }

    /**
     * @return int
     */
    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_SERVER_ERROR;
    }

}
