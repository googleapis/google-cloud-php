<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/uptime.proto

namespace Google\Cloud\Monitoring\V3\UptimeCheckConfig\ContentMatcher;

use UnexpectedValueException;

/**
 * Options to perform content matching.
 *
 * Protobuf type <code>google.monitoring.v3.UptimeCheckConfig.ContentMatcher.ContentMatcherOption</code>
 */
class ContentMatcherOption
{
    /**
     * No content matcher type specified (maintained for backward
     * compatibility, but deprecated for future use).
     * Treated as `CONTAINS_STRING`.
     *
     * Generated from protobuf enum <code>CONTENT_MATCHER_OPTION_UNSPECIFIED = 0;</code>
     */
    const CONTENT_MATCHER_OPTION_UNSPECIFIED = 0;
    /**
     * Selects substring matching. The match succeeds if the output contains
     * the `content` string.  This is the default value for checks without
     * a `matcher` option, or where the value of `matcher` is
     * `CONTENT_MATCHER_OPTION_UNSPECIFIED`.
     *
     * Generated from protobuf enum <code>CONTAINS_STRING = 1;</code>
     */
    const CONTAINS_STRING = 1;
    /**
     * Selects negation of substring matching. The match succeeds if the
     * output does _NOT_ contain the `content` string.
     *
     * Generated from protobuf enum <code>NOT_CONTAINS_STRING = 2;</code>
     */
    const NOT_CONTAINS_STRING = 2;
    /**
     * Selects regular-expression matching. The match succeeds if the output
     * matches the regular expression specified in the `content` string.
     * Regex matching is only supported for HTTP/HTTPS checks.
     *
     * Generated from protobuf enum <code>MATCHES_REGEX = 3;</code>
     */
    const MATCHES_REGEX = 3;
    /**
     * Selects negation of regular-expression matching. The match succeeds if
     * the output does _NOT_ match the regular expression specified in the
     * `content` string. Regex matching is only supported for HTTP/HTTPS
     * checks.
     *
     * Generated from protobuf enum <code>NOT_MATCHES_REGEX = 4;</code>
     */
    const NOT_MATCHES_REGEX = 4;
    /**
     * Selects JSONPath matching. See `JsonPathMatcher` for details on when
     * the match succeeds. JSONPath matching is only supported for HTTP/HTTPS
     * checks.
     *
     * Generated from protobuf enum <code>MATCHES_JSON_PATH = 5;</code>
     */
    const MATCHES_JSON_PATH = 5;
    /**
     * Selects JSONPath matching. See `JsonPathMatcher` for details on when
     * the match succeeds. Succeeds when output does _NOT_ match as specified.
     * JSONPath is only supported for HTTP/HTTPS checks.
     *
     * Generated from protobuf enum <code>NOT_MATCHES_JSON_PATH = 6;</code>
     */
    const NOT_MATCHES_JSON_PATH = 6;

    private static $valueToName = [
        self::CONTENT_MATCHER_OPTION_UNSPECIFIED => 'CONTENT_MATCHER_OPTION_UNSPECIFIED',
        self::CONTAINS_STRING => 'CONTAINS_STRING',
        self::NOT_CONTAINS_STRING => 'NOT_CONTAINS_STRING',
        self::MATCHES_REGEX => 'MATCHES_REGEX',
        self::NOT_MATCHES_REGEX => 'NOT_MATCHES_REGEX',
        self::MATCHES_JSON_PATH => 'MATCHES_JSON_PATH',
        self::NOT_MATCHES_JSON_PATH => 'NOT_MATCHES_JSON_PATH',
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


