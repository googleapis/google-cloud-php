<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/content.proto

namespace Google\Cloud\AIPlatform\V1\Candidate;

use UnexpectedValueException;

/**
 * The reason why the model stopped generating tokens.
 * If empty, the model has not stopped generating the tokens.
 *
 * Protobuf type <code>google.cloud.aiplatform.v1.Candidate.FinishReason</code>
 */
class FinishReason
{
    /**
     * The finish reason is unspecified.
     *
     * Generated from protobuf enum <code>FINISH_REASON_UNSPECIFIED = 0;</code>
     */
    const FINISH_REASON_UNSPECIFIED = 0;
    /**
     * Token generation reached a natural stopping point or a configured stop
     * sequence.
     *
     * Generated from protobuf enum <code>STOP = 1;</code>
     */
    const STOP = 1;
    /**
     * Token generation reached the configured maximum output tokens.
     *
     * Generated from protobuf enum <code>MAX_TOKENS = 2;</code>
     */
    const MAX_TOKENS = 2;
    /**
     * Token generation stopped because the content potentially contains safety
     * violations. NOTE: When streaming,
     * [content][google.cloud.aiplatform.v1.Candidate.content] is empty if
     * content filters blocks the output.
     *
     * Generated from protobuf enum <code>SAFETY = 3;</code>
     */
    const SAFETY = 3;
    /**
     * Token generation stopped because the content potentially contains
     * copyright violations.
     *
     * Generated from protobuf enum <code>RECITATION = 4;</code>
     */
    const RECITATION = 4;
    /**
     * All other reasons that stopped the token generation.
     *
     * Generated from protobuf enum <code>OTHER = 5;</code>
     */
    const OTHER = 5;
    /**
     * Token generation stopped because the content contains forbidden terms.
     *
     * Generated from protobuf enum <code>BLOCKLIST = 6;</code>
     */
    const BLOCKLIST = 6;
    /**
     * Token generation stopped for potentially containing prohibited content.
     *
     * Generated from protobuf enum <code>PROHIBITED_CONTENT = 7;</code>
     */
    const PROHIBITED_CONTENT = 7;
    /**
     * Token generation stopped because the content potentially contains
     * Sensitive Personally Identifiable Information (SPII).
     *
     * Generated from protobuf enum <code>SPII = 8;</code>
     */
    const SPII = 8;
    /**
     * The function call generated by the model is invalid.
     *
     * Generated from protobuf enum <code>MALFORMED_FUNCTION_CALL = 9;</code>
     */
    const MALFORMED_FUNCTION_CALL = 9;
    /**
     * The model response was blocked by Model Armor.
     *
     * Generated from protobuf enum <code>MODEL_ARMOR = 10;</code>
     */
    const MODEL_ARMOR = 10;

    private static $valueToName = [
        self::FINISH_REASON_UNSPECIFIED => 'FINISH_REASON_UNSPECIFIED',
        self::STOP => 'STOP',
        self::MAX_TOKENS => 'MAX_TOKENS',
        self::SAFETY => 'SAFETY',
        self::RECITATION => 'RECITATION',
        self::OTHER => 'OTHER',
        self::BLOCKLIST => 'BLOCKLIST',
        self::PROHIBITED_CONTENT => 'PROHIBITED_CONTENT',
        self::SPII => 'SPII',
        self::MALFORMED_FUNCTION_CALL => 'MALFORMED_FUNCTION_CALL',
        self::MODEL_ARMOR => 'MODEL_ARMOR',
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


