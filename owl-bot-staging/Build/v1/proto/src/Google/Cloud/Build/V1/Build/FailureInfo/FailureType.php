<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/cloudbuild/v1/cloudbuild.proto

namespace Google\Cloud\Build\V1\Build\FailureInfo;

use UnexpectedValueException;

/**
 * The name of a fatal problem encountered during the execution of the
 * build.
 *
 * Protobuf type <code>google.devtools.cloudbuild.v1.Build.FailureInfo.FailureType</code>
 */
class FailureType
{
    /**
     * Type unspecified
     *
     * Generated from protobuf enum <code>FAILURE_TYPE_UNSPECIFIED = 0;</code>
     */
    const FAILURE_TYPE_UNSPECIFIED = 0;
    /**
     * Unable to push the image to the repository.
     *
     * Generated from protobuf enum <code>PUSH_FAILED = 1;</code>
     */
    const PUSH_FAILED = 1;
    /**
     * Final image not found.
     *
     * Generated from protobuf enum <code>PUSH_IMAGE_NOT_FOUND = 2;</code>
     */
    const PUSH_IMAGE_NOT_FOUND = 2;
    /**
     * Unauthorized push of the final image.
     *
     * Generated from protobuf enum <code>PUSH_NOT_AUTHORIZED = 3;</code>
     */
    const PUSH_NOT_AUTHORIZED = 3;
    /**
     * Backend logging failures. Should retry.
     *
     * Generated from protobuf enum <code>LOGGING_FAILURE = 4;</code>
     */
    const LOGGING_FAILURE = 4;
    /**
     * A build step has failed.
     *
     * Generated from protobuf enum <code>USER_BUILD_STEP = 5;</code>
     */
    const USER_BUILD_STEP = 5;
    /**
     * The source fetching has failed.
     *
     * Generated from protobuf enum <code>FETCH_SOURCE_FAILED = 6;</code>
     */
    const FETCH_SOURCE_FAILED = 6;

    private static $valueToName = [
        self::FAILURE_TYPE_UNSPECIFIED => 'FAILURE_TYPE_UNSPECIFIED',
        self::PUSH_FAILED => 'PUSH_FAILED',
        self::PUSH_IMAGE_NOT_FOUND => 'PUSH_IMAGE_NOT_FOUND',
        self::PUSH_NOT_AUTHORIZED => 'PUSH_NOT_AUTHORIZED',
        self::LOGGING_FAILURE => 'LOGGING_FAILURE',
        self::USER_BUILD_STEP => 'USER_BUILD_STEP',
        self::FETCH_SOURCE_FAILED => 'FETCH_SOURCE_FAILED',
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
class_alias(FailureType::class, \Google\Cloud\Build\V1\Build_FailureInfo_FailureType::class);
