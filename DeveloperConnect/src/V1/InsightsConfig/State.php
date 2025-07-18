<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/developerconnect/v1/insights_config.proto

namespace Google\Cloud\DeveloperConnect\V1\InsightsConfig;

use UnexpectedValueException;

/**
 * The state of the InsightsConfig.
 *
 * Protobuf type <code>google.cloud.developerconnect.v1.InsightsConfig.State</code>
 */
class State
{
    /**
     * No state specified.
     *
     * Generated from protobuf enum <code>STATE_UNSPECIFIED = 0;</code>
     */
    const STATE_UNSPECIFIED = 0;
    /**
     * The InsightsConfig is pending application discovery/runtime discovery.
     *
     * Generated from protobuf enum <code>PENDING = 5;</code>
     */
    const PENDING = 5;
    /**
     * The initial discovery process is complete.
     *
     * Generated from protobuf enum <code>COMPLETE = 3;</code>
     */
    const COMPLETE = 3;
    /**
     * The InsightsConfig is in an error state.
     *
     * Generated from protobuf enum <code>ERROR = 4;</code>
     */
    const ERROR = 4;

    private static $valueToName = [
        self::STATE_UNSPECIFIED => 'STATE_UNSPECIFIED',
        self::PENDING => 'PENDING',
        self::COMPLETE => 'COMPLETE',
        self::ERROR => 'ERROR',
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


