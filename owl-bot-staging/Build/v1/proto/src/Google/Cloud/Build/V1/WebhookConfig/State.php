<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/cloudbuild/v1/cloudbuild.proto

namespace Google\Cloud\Build\V1\WebhookConfig;

use UnexpectedValueException;

/**
 * Enumerates potential issues with the Secret Manager secret provided by the
 * user.
 *
 * Protobuf type <code>google.devtools.cloudbuild.v1.WebhookConfig.State</code>
 */
class State
{
    /**
     * The webhook auth configuration not been checked.
     *
     * Generated from protobuf enum <code>STATE_UNSPECIFIED = 0;</code>
     */
    const STATE_UNSPECIFIED = 0;
    /**
     * The auth configuration is properly setup.
     *
     * Generated from protobuf enum <code>OK = 1;</code>
     */
    const OK = 1;
    /**
     * The secret provided in auth_method has been deleted.
     *
     * Generated from protobuf enum <code>SECRET_DELETED = 2;</code>
     */
    const SECRET_DELETED = 2;

    private static $valueToName = [
        self::STATE_UNSPECIFIED => 'STATE_UNSPECIFIED',
        self::OK => 'OK',
        self::SECRET_DELETED => 'SECRET_DELETED',
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

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(State::class, \Google\Cloud\Build\V1\WebhookConfig_State::class);
