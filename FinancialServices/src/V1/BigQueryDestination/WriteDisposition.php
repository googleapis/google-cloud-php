<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/bigquery_destination.proto

namespace Google\Cloud\FinancialServices\V1\BigQueryDestination;

use UnexpectedValueException;

/**
 * WriteDisposition controls the behavior when the destination table already
 * exists.
 *
 * Protobuf type <code>google.cloud.financialservices.v1.BigQueryDestination.WriteDisposition</code>
 */
class WriteDisposition
{
    /**
     * Default behavior is the same as WRITE_EMPTY.
     *
     * Generated from protobuf enum <code>WRITE_DISPOSITION_UNSPECIFIED = 0;</code>
     */
    const WRITE_DISPOSITION_UNSPECIFIED = 0;
    /**
     * If the table already exists and contains data, an error is returned.
     *
     * Generated from protobuf enum <code>WRITE_EMPTY = 1;</code>
     */
    const WRITE_EMPTY = 1;
    /**
     * If the table already exists, the data will be overwritten.
     *
     * Generated from protobuf enum <code>WRITE_TRUNCATE = 2;</code>
     */
    const WRITE_TRUNCATE = 2;

    private static $valueToName = [
        self::WRITE_DISPOSITION_UNSPECIFIED => 'WRITE_DISPOSITION_UNSPECIFIED',
        self::WRITE_EMPTY => 'WRITE_EMPTY',
        self::WRITE_TRUNCATE => 'WRITE_TRUNCATE',
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


