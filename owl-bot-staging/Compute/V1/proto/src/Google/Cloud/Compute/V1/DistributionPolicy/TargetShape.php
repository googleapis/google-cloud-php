<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\DistributionPolicy;

use UnexpectedValueException;

/**
 * The distribution shape to which the group converges either proactively or on resize events (depending on the value set in updatePolicy.instanceRedistributionType).
 *
 * Protobuf type <code>google.cloud.compute.v1.DistributionPolicy.TargetShape</code>
 */
class TargetShape
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_TARGET_SHAPE = 0;</code>
     */
    const UNDEFINED_TARGET_SHAPE = 0;
    /**
     * The group picks zones for creating VM instances to fulfill the requested number of VMs within present resource constraints and to maximize utilization of unused zonal reservations. Recommended for batch workloads that do not require high availability.
     *
     * Generated from protobuf enum <code>ANY = 64972;</code>
     */
    const ANY = 64972;
    /**
     * The group creates all VM instances within a single zone. The zone is selected based on the present resource constraints and to maximize utilization of unused zonal reservations. Recommended for batch workloads with heavy interprocess communication.
     *
     * Generated from protobuf enum <code>ANY_SINGLE_ZONE = 61100880;</code>
     */
    const ANY_SINGLE_ZONE = 61100880;
    /**
     * The group prioritizes acquisition of resources, scheduling VMs in zones where resources are available while distributing VMs as evenly as possible across selected zones to minimize the impact of zonal failure. Recommended for highly available serving workloads.
     *
     * Generated from protobuf enum <code>BALANCED = 468409608;</code>
     */
    const BALANCED = 468409608;
    /**
     * The group schedules VM instance creation and deletion to achieve and maintain an even number of managed instances across the selected zones. The distribution is even when the number of managed instances does not differ by more than 1 between any two zones. Recommended for highly available serving workloads.
     *
     * Generated from protobuf enum <code>EVEN = 2140442;</code>
     */
    const EVEN = 2140442;

    private static $valueToName = [
        self::UNDEFINED_TARGET_SHAPE => 'UNDEFINED_TARGET_SHAPE',
        self::ANY => 'ANY',
        self::ANY_SINGLE_ZONE => 'ANY_SINGLE_ZONE',
        self::BALANCED => 'BALANCED',
        self::EVEN => 'EVEN',
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
class_alias(TargetShape::class, \Google\Cloud\Compute\V1\DistributionPolicy_TargetShape::class);
