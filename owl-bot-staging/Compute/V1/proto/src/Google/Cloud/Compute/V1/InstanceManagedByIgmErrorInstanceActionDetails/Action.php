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
     * The managed instance group is abandoning this instance. The instance will be removed from the instance group and from any target pools that are associated with this group.
     *
     * Generated from protobuf enum <code>ABANDONING = 388244813;</code>
     */
    const ABANDONING = 388244813;
    /**
     * The managed instance group is creating this instance. If the group fails to create this instance, it will try again until it is successful.
     *
     * Generated from protobuf enum <code>CREATING = 455564985;</code>
     */
    const CREATING = 455564985;
    /**
     * The managed instance group is attempting to create this instance only once. If the group fails to create this instance, it does not try again and the group's targetSize value is decreased.
     *
     * Generated from protobuf enum <code>CREATING_WITHOUT_RETRIES = 428843785;</code>
     */
    const CREATING_WITHOUT_RETRIES = 428843785;
    /**
     * The managed instance group is permanently deleting this instance.
     *
     * Generated from protobuf enum <code>DELETING = 528602024;</code>
     */
    const DELETING = 528602024;
    /**
     * The managed instance group has not scheduled any actions for this instance.
     *
     * Generated from protobuf enum <code>NONE = 2402104;</code>
     */
    const NONE = 2402104;
    /**
     * The managed instance group is recreating this instance.
     *
     * Generated from protobuf enum <code>RECREATING = 287278572;</code>
     */
    const RECREATING = 287278572;
    /**
     * The managed instance group is applying configuration changes to the instance without stopping it. For example, the group can update the target pool list for an instance without stopping that instance.
     *
     * Generated from protobuf enum <code>REFRESHING = 163266343;</code>
     */
    const REFRESHING = 163266343;
    /**
     * The managed instance group is restarting this instance.
     *
     * Generated from protobuf enum <code>RESTARTING = 320534387;</code>
     */
    const RESTARTING = 320534387;
    /**
     * The managed instance group is resuming this instance.
     *
     * Generated from protobuf enum <code>RESUMING = 446856618;</code>
     */
    const RESUMING = 446856618;
    /**
     * The managed instance group is starting this instance.
     *
     * Generated from protobuf enum <code>STARTING = 488820800;</code>
     */
    const STARTING = 488820800;
    /**
     * The managed instance group is stopping this instance.
     *
     * Generated from protobuf enum <code>STOPPING = 350791796;</code>
     */
    const STOPPING = 350791796;
    /**
     * The managed instance group is suspending this instance.
     *
     * Generated from protobuf enum <code>SUSPENDING = 514206246;</code>
     */
    const SUSPENDING = 514206246;
    /**
     * The managed instance group is verifying this already created instance. Verification happens every time the instance is (re)created or restarted and consists of: 1. Waiting until health check specified as part of this managed instance group's autohealing policy reports HEALTHY. Note: Applies only if autohealing policy has a health check specified 2. Waiting for addition verification steps performed as post-instance creation (subject to future extensions).
     *
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
        self::RESUMING => 'RESUMING',
        self::STARTING => 'STARTING',
        self::STOPPING => 'STOPPING',
        self::SUSPENDING => 'SUSPENDING',
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

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Action::class, \Google\Cloud\Compute\V1\InstanceManagedByIgmErrorInstanceActionDetails_Action::class);
