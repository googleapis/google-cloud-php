<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkmanagement/v1/vpc_flow_logs_config.proto

namespace Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig;

use UnexpectedValueException;

/**
 * Toggles the aggregation interval for collecting flow logs by 5-tuple.
 *
 * Protobuf type <code>google.cloud.networkmanagement.v1.VpcFlowLogsConfig.AggregationInterval</code>
 */
class AggregationInterval
{
    /**
     * If not specified, will default to INTERVAL_5_SEC.
     *
     * Generated from protobuf enum <code>AGGREGATION_INTERVAL_UNSPECIFIED = 0;</code>
     */
    const AGGREGATION_INTERVAL_UNSPECIFIED = 0;
    /**
     * Aggregate logs in 5s intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_5_SEC = 1;</code>
     */
    const INTERVAL_5_SEC = 1;
    /**
     * Aggregate logs in 30s intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_30_SEC = 2;</code>
     */
    const INTERVAL_30_SEC = 2;
    /**
     * Aggregate logs in 1m intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_1_MIN = 3;</code>
     */
    const INTERVAL_1_MIN = 3;
    /**
     * Aggregate logs in 5m intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_5_MIN = 4;</code>
     */
    const INTERVAL_5_MIN = 4;
    /**
     * Aggregate logs in 10m intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_10_MIN = 5;</code>
     */
    const INTERVAL_10_MIN = 5;
    /**
     * Aggregate logs in 15m intervals.
     *
     * Generated from protobuf enum <code>INTERVAL_15_MIN = 6;</code>
     */
    const INTERVAL_15_MIN = 6;

    private static $valueToName = [
        self::AGGREGATION_INTERVAL_UNSPECIFIED => 'AGGREGATION_INTERVAL_UNSPECIFIED',
        self::INTERVAL_5_SEC => 'INTERVAL_5_SEC',
        self::INTERVAL_30_SEC => 'INTERVAL_30_SEC',
        self::INTERVAL_1_MIN => 'INTERVAL_1_MIN',
        self::INTERVAL_5_MIN => 'INTERVAL_5_MIN',
        self::INTERVAL_10_MIN => 'INTERVAL_10_MIN',
        self::INTERVAL_15_MIN => 'INTERVAL_15_MIN',
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


