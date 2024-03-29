<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2/dlp.proto

namespace Google\Cloud\Dlp\V2;

use UnexpectedValueException;

/**
 * Describes functionality of a given container in its original format.
 *
 * Protobuf type <code>google.privacy.dlp.v2.TransformationContainerType</code>
 */
class TransformationContainerType
{
    /**
     * Unused.
     *
     * Generated from protobuf enum <code>TRANSFORM_UNKNOWN_CONTAINER = 0;</code>
     */
    const TRANSFORM_UNKNOWN_CONTAINER = 0;
    /**
     * Body of a file.
     *
     * Generated from protobuf enum <code>TRANSFORM_BODY = 1;</code>
     */
    const TRANSFORM_BODY = 1;
    /**
     * Metadata for a file.
     *
     * Generated from protobuf enum <code>TRANSFORM_METADATA = 2;</code>
     */
    const TRANSFORM_METADATA = 2;
    /**
     * A table.
     *
     * Generated from protobuf enum <code>TRANSFORM_TABLE = 3;</code>
     */
    const TRANSFORM_TABLE = 3;

    private static $valueToName = [
        self::TRANSFORM_UNKNOWN_CONTAINER => 'TRANSFORM_UNKNOWN_CONTAINER',
        self::TRANSFORM_BODY => 'TRANSFORM_BODY',
        self::TRANSFORM_METADATA => 'TRANSFORM_METADATA',
        self::TRANSFORM_TABLE => 'TRANSFORM_TABLE',
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

