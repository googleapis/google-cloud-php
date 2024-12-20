<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/environment_type_enum.proto

namespace Google\Ads\AdManager\V1\EnvironmentTypeEnum;

use UnexpectedValueException;

/**
 * The different environments in which an ad can be shown.
 *
 * Protobuf type <code>google.ads.admanager.v1.EnvironmentTypeEnum.EnvironmentType</code>
 */
class EnvironmentType
{
    /**
     * No value specified
     *
     * Generated from protobuf enum <code>ENVIRONMENT_TYPE_UNSPECIFIED = 0;</code>
     */
    const ENVIRONMENT_TYPE_UNSPECIFIED = 0;
    /**
     * A regular web browser.
     *
     * Generated from protobuf enum <code>BROWSER = 1;</code>
     */
    const BROWSER = 1;
    /**
     * Video players.
     *
     * Generated from protobuf enum <code>VIDEO_PLAYER = 2;</code>
     */
    const VIDEO_PLAYER = 2;

    private static $valueToName = [
        self::ENVIRONMENT_TYPE_UNSPECIFIED => 'ENVIRONMENT_TYPE_UNSPECIFIED',
        self::BROWSER => 'BROWSER',
        self::VIDEO_PLAYER => 'VIDEO_PLAYER',
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


