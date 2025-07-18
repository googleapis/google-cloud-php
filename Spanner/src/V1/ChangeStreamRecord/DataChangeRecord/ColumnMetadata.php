<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/spanner/v1/change_stream.proto

namespace Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Metadata for a column.
 *
 * Generated from protobuf message <code>google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ColumnMetadata</code>
 */
class ColumnMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the column.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * Type of the column.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     */
    private $type = null;
    /**
     * Indicates whether the column is a primary key column.
     *
     * Generated from protobuf field <code>bool is_primary_key = 3;</code>
     */
    private $is_primary_key = false;
    /**
     * Ordinal position of the column based on the original table definition
     * in the schema starting with a value of 1.
     *
     * Generated from protobuf field <code>int64 ordinal_position = 4;</code>
     */
    private $ordinal_position = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Name of the column.
     *     @type \Google\Cloud\Spanner\V1\Type $type
     *           Type of the column.
     *     @type bool $is_primary_key
     *           Indicates whether the column is a primary key column.
     *     @type int|string $ordinal_position
     *           Ordinal position of the column based on the original table definition
     *           in the schema starting with a value of 1.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Spanner\V1\ChangeStream::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the column.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Name of the column.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Type of the column.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     * @return \Google\Cloud\Spanner\V1\Type|null
     */
    public function getType()
    {
        return $this->type;
    }

    public function hasType()
    {
        return isset($this->type);
    }

    public function clearType()
    {
        unset($this->type);
    }

    /**
     * Type of the column.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     * @param \Google\Cloud\Spanner\V1\Type $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Spanner\V1\Type::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Indicates whether the column is a primary key column.
     *
     * Generated from protobuf field <code>bool is_primary_key = 3;</code>
     * @return bool
     */
    public function getIsPrimaryKey()
    {
        return $this->is_primary_key;
    }

    /**
     * Indicates whether the column is a primary key column.
     *
     * Generated from protobuf field <code>bool is_primary_key = 3;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsPrimaryKey($var)
    {
        GPBUtil::checkBool($var);
        $this->is_primary_key = $var;

        return $this;
    }

    /**
     * Ordinal position of the column based on the original table definition
     * in the schema starting with a value of 1.
     *
     * Generated from protobuf field <code>int64 ordinal_position = 4;</code>
     * @return int|string
     */
    public function getOrdinalPosition()
    {
        return $this->ordinal_position;
    }

    /**
     * Ordinal position of the column based on the original table definition
     * in the schema starting with a value of 1.
     *
     * Generated from protobuf field <code>int64 ordinal_position = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setOrdinalPosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->ordinal_position = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ColumnMetadata::class, \Google\Cloud\Spanner\V1\ChangeStreamRecord_DataChangeRecord_ColumnMetadata::class);

