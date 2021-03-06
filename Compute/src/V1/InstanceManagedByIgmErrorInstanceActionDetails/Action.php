<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\InstanceManagedByIgmErrorInstanceActionDetails;

use UnexpectedValueException;

/**
 * [Output Only] Action that managed instance group was executing on the instance when the error occurred. Possible values:
 *
 * Protobuf type <code>google.cloud.compute.v1.InstanceManagedByIgmErrorInstanceActionDetails.Action</code>
 */
class Action
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_ACTION = 0;</code>
     */
    const UNDEFINED_ACTION = 0;
    /**
     * Generated from protobuf enum <code>ABANDONING = 388244813;</code>
     */
    const ABANDONING = 388244813;
    /**
     * Generated from protobuf enum <code>CREATING = 455564985;</code>
     */
    const CREATING = 455564985;
    /**
     * Generated from protobuf enum <code>CREATING_WITHOUT_RETRIES = 428843785;</code>
     */
    const CREATING_WITHOUT_RETRIES = 428843785;
    /**
     * Generated from protobuf enum <code>DELETING = 528602024;</code>
     */
    const DELETING = 528602024;
    /**
     * Generated from protobuf enum <code>NONE = 2402104;</code>
     */
    const NONE = 2402104;
    /**
     * Generated from protobuf enum <code>RECREATING = 287278572;</code>
     */
    const RECREATING = 287278572;
    /**
     * Generated from protobuf enum <code>REFRESHING = 163266343;</code>
     */
    const REFRESHING = 163266343;
    /**
     * Generated from protobuf enum <code>RESTARTING = 320534387;</code>
     */
    const RESTARTING = 320534387;
    /**
     * Generated from protobuf enum <code>VERIFYING = 16982185;</code>
     */
    const VERIFYING = 16982185;

    private static $valueToName = [
        self::UNDEFINED_ACTION => 'UNDEFINED_ACTION',
        self::ABANDONING => 'ABANDONING',
        self::CREATING => 'CREATING',
        self::CREATING_WITHOUT_RETRIES => 'CREATING_WITHOUT_RETRIES',
        self::DELETING => 'DELETING',
        self::NONE => 'NONE',
        self::RECREATING => 'RECREATING',
        self::REFRESHING => 'REFRESHING',
        self::RESTARTING => 'RESTARTING',
        self::VERIFYING => 'VERIFYING',
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


