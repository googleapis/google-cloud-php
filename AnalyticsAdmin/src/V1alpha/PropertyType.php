<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/resources.proto

namespace Google\Analytics\Admin\V1alpha;

use UnexpectedValueException;

/**
 * Types of `Property` resources.
 *
 * Protobuf type <code>google.analytics.admin.v1alpha.PropertyType</code>
 */
class PropertyType
{
    /**
     * Unknown or unspecified property type
     *
     * Generated from protobuf enum <code>PROPERTY_TYPE_UNSPECIFIED = 0;</code>
     */
    const PROPERTY_TYPE_UNSPECIFIED = 0;
    /**
     * Ordinary Google Analytics property
     *
     * Generated from protobuf enum <code>PROPERTY_TYPE_ORDINARY = 1;</code>
     */
    const PROPERTY_TYPE_ORDINARY = 1;
    /**
     * Google Analytics subproperty
     *
     * Generated from protobuf enum <code>PROPERTY_TYPE_SUBPROPERTY = 2;</code>
     */
    const PROPERTY_TYPE_SUBPROPERTY = 2;
    /**
     * Google Analytics rollup property
     *
     * Generated from protobuf enum <code>PROPERTY_TYPE_ROLLUP = 3;</code>
     */
    const PROPERTY_TYPE_ROLLUP = 3;

    private static $valueToName = [
        self::PROPERTY_TYPE_UNSPECIFIED => 'PROPERTY_TYPE_UNSPECIFIED',
        self::PROPERTY_TYPE_ORDINARY => 'PROPERTY_TYPE_ORDINARY',
        self::PROPERTY_TYPE_SUBPROPERTY => 'PROPERTY_TYPE_SUBPROPERTY',
        self::PROPERTY_TYPE_ROLLUP => 'PROPERTY_TYPE_ROLLUP',
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

