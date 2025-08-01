<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/modelarmor/v1/service.proto

namespace Google\Cloud\ModelArmor\V1\Template\TemplateMetadata;

use UnexpectedValueException;

/**
 * Enforcement type for Model Armor filters.
 *
 * Protobuf type <code>google.cloud.modelarmor.v1.Template.TemplateMetadata.EnforcementType</code>
 */
class EnforcementType
{
    /**
     * Default value. Same as INSPECT_AND_BLOCK.
     *
     * Generated from protobuf enum <code>ENFORCEMENT_TYPE_UNSPECIFIED = 0;</code>
     */
    const ENFORCEMENT_TYPE_UNSPECIFIED = 0;
    /**
     * Model Armor filters will run in inspect only mode. No action will be
     * taken on the request.
     *
     * Generated from protobuf enum <code>INSPECT_ONLY = 1;</code>
     */
    const INSPECT_ONLY = 1;
    /**
     * Model Armor filters will run in inspect and block mode. Requests
     * that trip Model Armor filters will be blocked.
     *
     * Generated from protobuf enum <code>INSPECT_AND_BLOCK = 2;</code>
     */
    const INSPECT_AND_BLOCK = 2;

    private static $valueToName = [
        self::ENFORCEMENT_TYPE_UNSPECIFIED => 'ENFORCEMENT_TYPE_UNSPECIFIED',
        self::INSPECT_ONLY => 'INSPECT_ONLY',
        self::INSPECT_AND_BLOCK => 'INSPECT_AND_BLOCK',
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


