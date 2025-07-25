<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\FirewallPolicyRuleMatcher;

use UnexpectedValueException;

/**
 * Network type of the traffic destination. Allowed values are: - UNSPECIFIED - INTERNET - NON_INTERNET
 * Additional supported values which may be not listed in the enum directly due to technical reasons:
 * INTERNET
 * INTRA_VPC
 * NON_INTERNET
 * UNSPECIFIED
 * VPC_NETWORKS
 *
 * Protobuf type <code>google.cloud.compute.v1.FirewallPolicyRuleMatcher.DestNetworkType</code>
 */
class DestNetworkType
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_DEST_NETWORK_TYPE = 0;</code>
     */
    const UNDEFINED_DEST_NETWORK_TYPE = 0;

    private static $valueToName = [
        self::UNDEFINED_DEST_NETWORK_TYPE => 'UNDEFINED_DEST_NETWORK_TYPE',
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


