<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkconnectivity/v1/hub.proto

namespace Google\Cloud\NetworkConnectivity\V1;

use UnexpectedValueException;

/**
 * The SpokeType enum represents the type of spoke. The type
 * reflects the kind of resource that a spoke is associated with.
 *
 * Protobuf type <code>google.cloud.networkconnectivity.v1.SpokeType</code>
 */
class SpokeType
{
    /**
     * Unspecified spoke type.
     *
     * Generated from protobuf enum <code>SPOKE_TYPE_UNSPECIFIED = 0;</code>
     */
    const SPOKE_TYPE_UNSPECIFIED = 0;
    /**
     * Spokes associated with VPN tunnels.
     *
     * Generated from protobuf enum <code>VPN_TUNNEL = 1;</code>
     */
    const VPN_TUNNEL = 1;
    /**
     * Spokes associated with VLAN attachments.
     *
     * Generated from protobuf enum <code>INTERCONNECT_ATTACHMENT = 2;</code>
     */
    const INTERCONNECT_ATTACHMENT = 2;
    /**
     * Spokes associated with router appliance instances.
     *
     * Generated from protobuf enum <code>ROUTER_APPLIANCE = 3;</code>
     */
    const ROUTER_APPLIANCE = 3;
    /**
     * Spokes associated with VPC networks.
     *
     * Generated from protobuf enum <code>VPC_NETWORK = 4;</code>
     */
    const VPC_NETWORK = 4;
    /**
     * Spokes that are backed by a producer VPC network.
     *
     * Generated from protobuf enum <code>PRODUCER_VPC_NETWORK = 7;</code>
     */
    const PRODUCER_VPC_NETWORK = 7;

    private static $valueToName = [
        self::SPOKE_TYPE_UNSPECIFIED => 'SPOKE_TYPE_UNSPECIFIED',
        self::VPN_TUNNEL => 'VPN_TUNNEL',
        self::INTERCONNECT_ATTACHMENT => 'INTERCONNECT_ATTACHMENT',
        self::ROUTER_APPLIANCE => 'ROUTER_APPLIANCE',
        self::VPC_NETWORK => 'VPC_NETWORK',
        self::PRODUCER_VPC_NETWORK => 'PRODUCER_VPC_NETWORK',
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

