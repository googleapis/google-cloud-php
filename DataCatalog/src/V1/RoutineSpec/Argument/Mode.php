<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datacatalog/v1/datacatalog.proto

namespace Google\Cloud\DataCatalog\V1\RoutineSpec\Argument;

use UnexpectedValueException;

/**
 * The input or output mode of the argument.
 *
 * Protobuf type <code>google.cloud.datacatalog.v1.RoutineSpec.Argument.Mode</code>
 */
class Mode
{
    /**
     * Unspecified mode.
     *
     * Generated from protobuf enum <code>MODE_UNSPECIFIED = 0;</code>
     */
    const MODE_UNSPECIFIED = 0;
    /**
     * The argument is input-only.
     *
     * Generated from protobuf enum <code>IN = 1;</code>
     */
    const IN = 1;
    /**
     * The argument is output-only.
     *
     * Generated from protobuf enum <code>OUT = 2;</code>
     */
    const OUT = 2;
    /**
     * The argument is both an input and an output.
     *
     * Generated from protobuf enum <code>INOUT = 3;</code>
     */
    const INOUT = 3;

    private static $valueToName = [
        self::MODE_UNSPECIFIED => 'MODE_UNSPECIFIED',
        self::IN => 'IN',
        self::OUT => 'OUT',
        self::INOUT => 'INOUT',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}


