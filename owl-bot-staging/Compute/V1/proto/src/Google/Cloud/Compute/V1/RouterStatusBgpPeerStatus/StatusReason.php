<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\RouterStatusBgpPeerStatus;

use UnexpectedValueException;

/**
 * Indicates why particular status was returned.
 *
 * Protobuf type <code>google.cloud.compute.v1.RouterStatusBgpPeerStatus.StatusReason</code>
 */
class StatusReason
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_STATUS_REASON = 0;</code>
     */
    const UNDEFINED_STATUS_REASON = 0;
    /**
     * Indicates internal problems with configuration of MD5 authentication. This particular reason can only be returned when md5AuthEnabled is true and status is DOWN.
     *
     * Generated from protobuf enum <code>MD5_AUTH_INTERNAL_PROBLEM = 140462259;</code>
     */
    const MD5_AUTH_INTERNAL_PROBLEM = 140462259;
    /**
     * Generated from protobuf enum <code>STATUS_REASON_UNSPECIFIED = 394331913;</code>
     */
    const STATUS_REASON_UNSPECIFIED = 394331913;

    private static $valueToName = [
        self::UNDEFINED_STATUS_REASON => 'UNDEFINED_STATUS_REASON',
        self::MD5_AUTH_INTERNAL_PROBLEM => 'MD5_AUTH_INTERNAL_PROBLEM',
        self::STATUS_REASON_UNSPECIFIED => 'STATUS_REASON_UNSPECIFIED',
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
class_alias(StatusReason::class, \Google\Cloud\Compute\V1\RouterStatusBgpPeerStatus_StatusReason::class);
