<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\Condition;

use UnexpectedValueException;

/**
 * This is deprecated and has no effect. Do not use.
 *
 * Protobuf type <code>google.cloud.compute.v1.Condition.Op</code>
 */
class Op
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_OP = 0;</code>
     */
    const UNDEFINED_OP = 0;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>DISCHARGED = 266338274;</code>
     */
    const DISCHARGED = 266338274;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>EQUALS = 442201023;</code>
     */
    const EQUALS = 442201023;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>IN = 2341;</code>
     */
    const IN = 2341;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>NOT_EQUALS = 19718859;</code>
     */
    const NOT_EQUALS = 19718859;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>NOT_IN = 161144369;</code>
     */
    const NOT_IN = 161144369;
    /**
     * This is deprecated and has no effect. Do not use.
     *
     * Generated from protobuf enum <code>NO_OP = 74481951;</code>
     */
    const NO_OP = 74481951;

    private static $valueToName = [
        self::UNDEFINED_OP => 'UNDEFINED_OP',
        self::DISCHARGED => 'DISCHARGED',
        self::EQUALS => 'EQUALS',
        self::IN => 'IN',
        self::NOT_EQUALS => 'NOT_EQUALS',
        self::NOT_IN => 'NOT_IN',
        self::NO_OP => 'NO_OP',
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

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Op::class, \Google\Cloud\Compute\V1\Condition_Op::class);
