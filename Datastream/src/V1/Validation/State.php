<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datastream/v1/datastream_resources.proto

namespace Google\Cloud\Datastream\V1\Validation;

use UnexpectedValueException;

/**
 * Validation execution state.
 *
 * Protobuf type <code>google.cloud.datastream.v1.Validation.State</code>
 */
class State
{
    /**
     * Unspecified state.
     *
     * Generated from protobuf enum <code>STATE_UNSPECIFIED = 0;</code>
     */
    const STATE_UNSPECIFIED = 0;
    /**
     * Validation did not execute.
     *
     * Generated from protobuf enum <code>NOT_EXECUTED = 1;</code>
     */
    const NOT_EXECUTED = 1;
    /**
     * Validation failed.
     *
     * Generated from protobuf enum <code>FAILED = 2;</code>
     */
    const FAILED = 2;
    /**
     * Validation passed.
     *
     * Generated from protobuf enum <code>PASSED = 3;</code>
     */
    const PASSED = 3;
    /**
     * Validation executed with warnings.
     *
     * Generated from protobuf enum <code>WARNING = 4;</code>
     */
    const WARNING = 4;

    private static $valueToName = [
        self::STATE_UNSPECIFIED => 'STATE_UNSPECIFIED',
        self::NOT_EXECUTED => 'NOT_EXECUTED',
        self::FAILED => 'FAILED',
        self::PASSED => 'PASSED',
        self::WARNING => 'WARNING',
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


