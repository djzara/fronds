<?php
/**
 * User: zara
 * Date: 2019-05-19
 * Time: 17:59
 */

namespace Fronds\Lib\Constants;

/**
 * Any constants related to HTTP requests go here
 * which is not limited to response codes
 * Interface HttpConstants
 * @package Fronds\Lib\Constants
 */
interface HttpConstants
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_FORBIDDEN= 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_INVALID = 422;
    public const HTTP_SERVER_ERROR = 500;
}
