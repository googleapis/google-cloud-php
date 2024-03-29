<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1\InstanceGroupManagerInstanceLifecyclePolicy;

use UnexpectedValueException;

/**
 * The action that a MIG performs on a failed or an unhealthy VM. A VM is marked as unhealthy when the application running on that VM fails a health check. Valid values are - REPAIR (default): MIG automatically repairs a failed or an unhealthy VM by recreating it. For more information, see About repairing VMs in a MIG. - DO_NOTHING: MIG does not repair a failed or an unhealthy VM. 
 *
 * Protobuf type <code>google.cloud.compute.v1.InstanceGroupManagerInstanceLifecyclePolicy.DefaultActionOnFailure</code>
 */
class DefaultActionOnFailure
{
    /**
     * A value indicating that the enum field is not set.
     *
     * Generated from protobuf enum <code>UNDEFINED_DEFAULT_ACTION_ON_FAILURE = 0;</code>
     */
    const UNDEFINED_DEFAULT_ACTION_ON_FAILURE = 0;
    /**
     * MIG does not repair a failed or an unhealthy VM.
     *
     * Generated from protobuf enum <code>DO_NOTHING = 451307513;</code>
     */
    const DO_NOTHING = 451307513;
    /**
     * (Default) MIG automatically repairs a failed or an unhealthy VM by recreating it. For more information, see About repairing VMs in a MIG.
     *
     * Generated from protobuf enum <code>REPAIR = 266277773;</code>
     */
    const REPAIR = 266277773;

    private static $valueToName = [
        self::UNDEFINED_DEFAULT_ACTION_ON_FAILURE => 'UNDEFINED_DEFAULT_ACTION_ON_FAILURE',
        self::DO_NOTHING => 'DO_NOTHING',
        self::REPAIR => 'REPAIR',
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


