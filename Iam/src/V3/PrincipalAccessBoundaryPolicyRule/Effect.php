<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/v3/principal_access_boundary_policy_resources.proto

namespace Google\Cloud\Iam\V3\PrincipalAccessBoundaryPolicyRule;

use UnexpectedValueException;

/**
 * An effect to describe the access relationship.
 *
 * Protobuf type <code>google.iam.v3.PrincipalAccessBoundaryPolicyRule.Effect</code>
 */
class Effect
{
    /**
     * Effect unspecified.
     *
     * Generated from protobuf enum <code>EFFECT_UNSPECIFIED = 0;</code>
     */
    const EFFECT_UNSPECIFIED = 0;
    /**
     * Allows access to the resources in this rule.
     *
     * Generated from protobuf enum <code>ALLOW = 1;</code>
     */
    const ALLOW = 1;

    private static $valueToName = [
        self::EFFECT_UNSPECIFIED => 'EFFECT_UNSPECIFIED',
        self::ALLOW => 'ALLOW',
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


