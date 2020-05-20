<?php
/**
 * User: zara
 * Date: 2019-05-19
 * Time: 17:58
 */

namespace Fronds\Lib\Exceptions;

use Exception;
use Throwable;

abstract class FrondsException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    abstract public function getExceptionCode() : int;

    abstract public function getHttpErrorCode() : int;
}
