<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/resources.proto

namespace Google\Cloud\Dataplex\V1\Zone\ResourceSpec;

use UnexpectedValueException;

/**
 * Location type of the resources attached to a zone.
 *
 * Protobuf type <code>google.cloud.dataplex.v1.Zone.ResourceSpec.LocationType</code>
 */
class LocationType
{
    /**
     * Unspecified location type.
     *
     * Generated from protobuf enum <code>LOCATION_TYPE_UNSPECIFIED = 0;</code>
     */
    const LOCATION_TYPE_UNSPECIFIED = 0;
    /**
     * Resources that are associated with a single region.
     *
     * Generated from protobuf enum <code>SINGLE_REGION = 1;</code>
     */
    const SINGLE_REGION = 1;
    /**
     * Resources that are associated with a multi-region location.
     *
     * Generated from protobuf enum <code>MULTI_REGION = 2;</code>
     */
    const MULTI_REGION = 2;

    private static $valueToName = [
        self::LOCATION_TYPE_UNSPECIFIED => 'LOCATION_TYPE_UNSPECIFIED',
        self::SINGLE_REGION => 'SINGLE_REGION',
        self::MULTI_REGION => 'MULTI_REGION',
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
class_alias(LocationType::class, \Google\Cloud\Dataplex\V1\Zone_ResourceSpec_LocationType::class);
