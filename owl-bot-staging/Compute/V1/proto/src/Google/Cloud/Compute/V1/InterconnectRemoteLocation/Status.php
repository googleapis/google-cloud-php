<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\InterconnectRemoteLocation;

use UnexpectedValueException;

/**
 * [Output Only] The status of this InterconnectRemoteLocation, which can take one of the following values: - CLOSED: The InterconnectRemoteLocation is closed and is unavailable for provisioning new Cross-Cloud Interconnects. - AVAILABLE: The InterconnectRemoteLocation is available for provisioning new Cross-Cloud Interconnects. 
 *
 * Protobuf type <code>google.cloud.compute.v1.InterconnectRemoteLocation.Status</code>
 */
class Status
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_STATUS = 0;</code>
     */
    const UNDEFINED_STATUS = 0;
    /**
     * The InterconnectRemoteLocation is available for provisioning new Cross-Cloud Interconnects.
     *
     * Generated from protobuf enum <code>AVAILABLE = 442079913;</code>
     */
    const AVAILABLE = 442079913;
    /**
     * The InterconnectRemoteLocation is closed for provisioning new Cross-Cloud Interconnects.
     *
     * Generated from protobuf enum <code>CLOSED = 380163436;</code>
     */
    const CLOSED = 380163436;

    private static $valueToName = [
        self::UNDEFINED_STATUS => 'UNDEFINED_STATUS',
        self::AVAILABLE => 'AVAILABLE',
        self::CLOSED => 'CLOSED',
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
class_alias(Status::class, \Google\Cloud\Compute\V1\InterconnectRemoteLocation_Status::class);
