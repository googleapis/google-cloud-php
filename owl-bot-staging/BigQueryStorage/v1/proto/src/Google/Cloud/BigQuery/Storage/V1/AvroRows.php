<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/bigquery/storage/v1/avro.proto

namespace Google\Cloud\BigQuery\Storage\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Avro rows.
 *
 * Generated from protobuf message <code>google.cloud.bigquery.storage.v1.AvroRows</code>
 */
class AvroRows extends \Google\Protobuf\Internal\Message
{
    /**
     * Binary serialized rows in a block.
     *
     * Generated from protobuf field <code>bytes serialized_binary_rows = 1;</code>
     */
    protected $serialized_binary_rows = '';
    /**
     * [Deprecated] The count of rows in the returning block.
     * Please use the format-independent ReadRowsResponse.row_count instead.
     *
     * Generated from protobuf field <code>int64 row_count = 2 [deprecated = true];</code>
     * @deprecated
     */
    protected $row_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $serialized_binary_rows
     *           Binary serialized rows in a block.
     *     @type int|string $row_count
     *           [Deprecated] The count of rows in the returning block.
     *           Please use the format-independent ReadRowsResponse.row_count instead.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Bigquery\Storage\V1\Avro::initOnce();
        parent::__construct($data);
    }

    /**
     * Binary serialized rows in a block.
     *
     * Generated from protobuf field <code>bytes serialized_binary_rows = 1;</code>
     * @return string
     */
    public function getSerializedBinaryRows()
    {
        return $this->serialized_binary_rows;
    }

    /**
     * Binary serialized rows in a block.
     *
     * Generated from protobuf field <code>bytes serialized_binary_rows = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSerializedBinaryRows($var)
    {
        GPBUtil::checkString($var, False);
        $this->serialized_binary_rows = $var;

        return $this;
    }

    /**
     * [Deprecated] The count of rows in the returning block.
     * Please use the format-independent ReadRowsResponse.row_count instead.
     *
     * Generated from protobuf field <code>int64 row_count = 2 [deprecated = true];</code>
     * @return int|string
     * @deprecated
     */
    public function getRowCount()
    {
        @trigger_error('row_count is deprecated.', E_USER_DEPRECATED);
        return $this->row_count;
    }

    /**
     * [Deprecated] The count of rows in the returning block.
     * Please use the format-independent ReadRowsResponse.row_count instead.
     *
     * Generated from protobuf field <code>int64 row_count = 2 [deprecated = true];</code>
     * @param int|string $var
     * @return $this
     * @deprecated
     */
    public function setRowCount($var)
    {
        @trigger_error('row_count is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkInt64($var);
        $this->row_count = $var;

        return $this;
    }

}
