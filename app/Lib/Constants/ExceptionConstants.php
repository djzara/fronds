<?php


namespace Fronds\Lib\Constants;

/**
 * Interface ExceptionConstants
 * @package Fronds\Lib\Constants
 */
interface ExceptionConstants
{

    // source
    public const FRONDS_DATA = 0x000000;
    public const FRONDS_NETWORK = 0x000001;
    public const FRONDS_CLIENT = 0x000002;
    public const FRONDS_INTERNAL = 0x00004;
    public const FRONDS_EXTERNAL = 0x000008;

    // behavior
    public const COULD_NOT_CREATE = 0x000100;
    public const COULD_NOT_FIND = 0x000200;
    public const INVALID_INPUT = 0x000400;
    public const INVALID_STRUCTURE = 0x000800;
    public const IMPROPER_ACCESS = 0x000F00;
    public const ILLEGAL_ACCESS = 0x001000;
    public const INVALID_ARGUMENT = 0x002000;

    // severity
    public const FRONDS_NOTICE = 0x010000;
    public const FRONDS_WARNING = 0x020000;
    public const FRONDS_ERROR = 0x040000;
    // the exception was important enough that the system must redo the previous
    // action to ensure integrity
    public const FRONDS_HALT = 0x080000;
}