<?php

declare(strict_types=1);

namespace Fronds\Lib\Exceptions\Usage;


use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;

/**
 * Class FrondsIllegalArgumentException
 *
 * @package Fronds\Lib\Exceptions\Usage
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FrondsIllegalArgumentException extends FrondsException
{
    /**
     * @return int
     */
    public function getExceptionCode(): int
    {
        return ExceptionConstants::FRONDS_ERROR | ExceptionConstants::INVALID_ARGUMENT;
    }

    /**
     * @return int
     */
    public function getHttpErrorCode(): int
    {
        return HttpConstants::HTTP_SERVER_ERROR;
    }

}
