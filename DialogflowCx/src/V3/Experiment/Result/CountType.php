<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/experiment.proto

namespace Google\Cloud\Dialogflow\Cx\V3\Experiment\Result;

use UnexpectedValueException;

/**
 * Types of count-based metric for Dialogflow experiment.
 *
 * Protobuf type <code>google.cloud.dialogflow.cx.v3.Experiment.Result.CountType</code>
 */
class CountType
{
    /**
     * Count type unspecified.
     *
     * Generated from protobuf enum <code>COUNT_TYPE_UNSPECIFIED = 0;</code>
     */
    const COUNT_TYPE_UNSPECIFIED = 0;
    /**
     * Total number of occurrences of a 'NO_MATCH'.
     *
     * Generated from protobuf enum <code>TOTAL_NO_MATCH_COUNT = 1;</code>
     */
    const TOTAL_NO_MATCH_COUNT = 1;
    /**
     * Total number of turn counts.
     *
     * Generated from protobuf enum <code>TOTAL_TURN_COUNT = 2;</code>
     */
    const TOTAL_TURN_COUNT = 2;
    /**
     * Average turn count in a session.
     *
     * Generated from protobuf enum <code>AVERAGE_TURN_COUNT = 3;</code>
     */
    const AVERAGE_TURN_COUNT = 3;

    private static $valueToName = [
        self::COUNT_TYPE_UNSPECIFIED => 'COUNT_TYPE_UNSPECIFIED',
        self::TOTAL_NO_MATCH_COUNT => 'TOTAL_NO_MATCH_COUNT',
        self::TOTAL_TURN_COUNT => 'TOTAL_TURN_COUNT',
        self::AVERAGE_TURN_COUNT => 'AVERAGE_TURN_COUNT',
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

