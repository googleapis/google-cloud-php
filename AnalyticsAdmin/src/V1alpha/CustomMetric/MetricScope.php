<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/resources.proto

namespace Google\Analytics\Admin\V1alpha\CustomMetric;

use UnexpectedValueException;

/**
 * The scope of this metric.
 *
 * Protobuf type <code>google.analytics.admin.v1alpha.CustomMetric.MetricScope</code>
 */
class MetricScope
{
    /**
     * Scope unknown or not specified.
     *
     * Generated from protobuf enum <code>METRIC_SCOPE_UNSPECIFIED = 0;</code>
     */
    const METRIC_SCOPE_UNSPECIFIED = 0;
    /**
     * Metric scoped to an event.
     *
     * Generated from protobuf enum <code>EVENT = 1;</code>
     */
    const EVENT = 1;

    private static $valueToName = [
        self::METRIC_SCOPE_UNSPECIFIED => 'METRIC_SCOPE_UNSPECIFIED',
        self::EVENT => 'EVENT',
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


