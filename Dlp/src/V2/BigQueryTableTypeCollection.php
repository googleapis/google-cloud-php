<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2/dlp.proto

namespace Google\Cloud\Dlp\V2;

use UnexpectedValueException;

/**
 * Over time new types may be added. Currently VIEW, MATERIALIZED_VIEW, and
 * non-BigLake external tables are not supported.
 *
 * Protobuf type <code>google.privacy.dlp.v2.BigQueryTableTypeCollection</code>
 */
class BigQueryTableTypeCollection
{
    /**
     * Unused.
     *
     * Generated from protobuf enum <code>BIG_QUERY_COLLECTION_UNSPECIFIED = 0;</code>
     */
    const BIG_QUERY_COLLECTION_UNSPECIFIED = 0;
    /**
     * Automatically generate profiles for all tables, even if the table type is
     * not yet fully supported for analysis. Profiles for unsupported tables will
     * be generated with errors to indicate their partial support. When full
     * support is added, the tables will automatically be profiled during the next
     * scheduled run.
     *
     * Generated from protobuf enum <code>BIG_QUERY_COLLECTION_ALL_TYPES = 1;</code>
     */
    const BIG_QUERY_COLLECTION_ALL_TYPES = 1;
    /**
     * Only those types fully supported will be profiled. Will expand
     * automatically as Cloud DLP adds support for new table types. Unsupported
     * table types will not have partial profiles generated.
     *
     * Generated from protobuf enum <code>BIG_QUERY_COLLECTION_ONLY_SUPPORTED_TYPES = 2;</code>
     */
    const BIG_QUERY_COLLECTION_ONLY_SUPPORTED_TYPES = 2;

    private static $valueToName = [
        self::BIG_QUERY_COLLECTION_UNSPECIFIED => 'BIG_QUERY_COLLECTION_UNSPECIFIED',
        self::BIG_QUERY_COLLECTION_ALL_TYPES => 'BIG_QUERY_COLLECTION_ALL_TYPES',
        self::BIG_QUERY_COLLECTION_ONLY_SUPPORTED_TYPES => 'BIG_QUERY_COLLECTION_ONLY_SUPPORTED_TYPES',
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

