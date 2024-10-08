<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2/dlp.proto

namespace Google\Cloud\Dlp\V2\ColumnDataProfile;

use UnexpectedValueException;

/**
 * The possible policy states for a column.
 *
 * Protobuf type <code>google.privacy.dlp.v2.ColumnDataProfile.ColumnPolicyState</code>
 */
class ColumnPolicyState
{
    /**
     * No policy tags.
     *
     * Generated from protobuf enum <code>COLUMN_POLICY_STATE_UNSPECIFIED = 0;</code>
     */
    const COLUMN_POLICY_STATE_UNSPECIFIED = 0;
    /**
     * Column has policy tag applied.
     *
     * Generated from protobuf enum <code>COLUMN_POLICY_TAGGED = 1;</code>
     */
    const COLUMN_POLICY_TAGGED = 1;

    private static $valueToName = [
        self::COLUMN_POLICY_STATE_UNSPECIFIED => 'COLUMN_POLICY_STATE_UNSPECIFIED',
        self::COLUMN_POLICY_TAGGED => 'COLUMN_POLICY_TAGGED',
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


