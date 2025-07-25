<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/assist_answer.proto

namespace Google\Cloud\DiscoveryEngine\V1\AssistantContent\CodeExecutionResult;

use UnexpectedValueException;

/**
 * Enumeration of possible outcomes of the code execution.
 *
 * Protobuf type <code>google.cloud.discoveryengine.v1.AssistantContent.CodeExecutionResult.Outcome</code>
 */
class Outcome
{
    /**
     * Unspecified status. This value should not be used.
     *
     * Generated from protobuf enum <code>OUTCOME_UNSPECIFIED = 0;</code>
     */
    const OUTCOME_UNSPECIFIED = 0;
    /**
     * Code execution completed successfully.
     *
     * Generated from protobuf enum <code>OUTCOME_OK = 1;</code>
     */
    const OUTCOME_OK = 1;
    /**
     * Code execution finished but with a failure. `stderr` should contain the
     * reason.
     *
     * Generated from protobuf enum <code>OUTCOME_FAILED = 2;</code>
     */
    const OUTCOME_FAILED = 2;
    /**
     * Code execution ran for too long, and was cancelled. There may or may
     * not be a partial output present.
     *
     * Generated from protobuf enum <code>OUTCOME_DEADLINE_EXCEEDED = 3;</code>
     */
    const OUTCOME_DEADLINE_EXCEEDED = 3;

    private static $valueToName = [
        self::OUTCOME_UNSPECIFIED => 'OUTCOME_UNSPECIFIED',
        self::OUTCOME_OK => 'OUTCOME_OK',
        self::OUTCOME_FAILED => 'OUTCOME_FAILED',
        self::OUTCOME_DEADLINE_EXCEEDED => 'OUTCOME_DEADLINE_EXCEEDED',
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


