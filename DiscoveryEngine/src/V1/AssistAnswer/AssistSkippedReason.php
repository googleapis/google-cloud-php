<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/assist_answer.proto

namespace Google\Cloud\DiscoveryEngine\V1\AssistAnswer;

use UnexpectedValueException;

/**
 * Possible reasons for not answering an assist call.
 *
 * Protobuf type <code>google.cloud.discoveryengine.v1.AssistAnswer.AssistSkippedReason</code>
 */
class AssistSkippedReason
{
    /**
     * Default value. Skip reason is not specified.
     *
     * Generated from protobuf enum <code>ASSIST_SKIPPED_REASON_UNSPECIFIED = 0;</code>
     */
    const ASSIST_SKIPPED_REASON_UNSPECIFIED = 0;
    /**
     * The assistant ignored the query, because it did not appear to be
     * answer-seeking.
     *
     * Generated from protobuf enum <code>NON_ASSIST_SEEKING_QUERY_IGNORED = 1;</code>
     */
    const NON_ASSIST_SEEKING_QUERY_IGNORED = 1;
    /**
     * The assistant ignored the query or refused to answer because of a
     * customer policy violation (e.g., the query or the answer contained a
     * banned phrase).
     *
     * Generated from protobuf enum <code>CUSTOMER_POLICY_VIOLATION = 2;</code>
     */
    const CUSTOMER_POLICY_VIOLATION = 2;

    private static $valueToName = [
        self::ASSIST_SKIPPED_REASON_UNSPECIFIED => 'ASSIST_SKIPPED_REASON_UNSPECIFIED',
        self::NON_ASSIST_SEEKING_QUERY_IGNORED => 'NON_ASSIST_SEEKING_QUERY_IGNORED',
        self::CUSTOMER_POLICY_VIOLATION => 'CUSTOMER_POLICY_VIOLATION',
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


