<?php

use Fronds\Lib\Exceptions\FrondsException;

// basically overrides to use for the Laravel throw_if and throw_unless functions to
// wrap in the custom fronds exception to prevent general Throwables from being thrown
// to help with inheritance
if (!function_exists('fronds_throw_if')) {

    /**
     * @param $condition
     * @param $exception
     * @param mixed ...$args
     * @return mixed
     * @throws FrondsException
     */
    function fronds_throw_if($condition, $exception, ...$args)
    {
        if ($condition && $exception instanceof FrondsException) {
            throw is_string($exception) ? new $exception(...$args) : $exception;
        }

        return $condition;
    }
}

if (! function_exists('fronds_throw_unless')) {

    /**
     * We're really just inverting the call to throw_if, just reuse it
     * @param $condition
     * @param $exception
     * @param mixed ...$parameters
     * @return mixed
     * @throws FrondsException
     */
    function fronds_throw_unless($condition, $exception, ...$parameters)
    {
        return fronds_throw_if(!$condition, $exception, ...$parameters);
    }
}