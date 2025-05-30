<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1\AutoMonitoringConfig;

use UnexpectedValueException;

/**
 * Scope for applications monitored by Auto-Monitoring
 *
 * Protobuf type <code>google.container.v1.AutoMonitoringConfig.Scope</code>
 */
class Scope
{
    /**
     * Not set.
     *
     * Generated from protobuf enum <code>SCOPE_UNSPECIFIED = 0;</code>
     */
    const SCOPE_UNSPECIFIED = 0;
    /**
     * Auto-Monitoring is enabled for all supported applications.
     *
     * Generated from protobuf enum <code>ALL = 1;</code>
     */
    const ALL = 1;
    /**
     * Disable Auto-Monitoring.
     *
     * Generated from protobuf enum <code>NONE = 2;</code>
     */
    const NONE = 2;

    private static $valueToName = [
        self::SCOPE_UNSPECIFIED => 'SCOPE_UNSPECIFIED',
        self::ALL => 'ALL',
        self::NONE => 'NONE',
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


