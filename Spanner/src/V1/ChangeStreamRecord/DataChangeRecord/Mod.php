<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/spanner/v1/change_stream.proto

namespace Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A mod describes all data changes in a watched table row.
 *
 * Generated from protobuf message <code>google.spanner.v1.ChangeStreamRecord.DataChangeRecord.Mod</code>
 */
class Mod extends \Google\Protobuf\Internal\Message
{
    /**
     * Returns the value of the primary key of the modified row.
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue keys = 1;</code>
     */
    private $keys;
    /**
     * Returns the old values before the change for the modified columns.
     * Always empty for
     * [INSERT][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.INSERT],
     * or if old values are not being captured specified by
     * [value_capture_type][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ValueCaptureType].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue old_values = 2;</code>
     */
    private $old_values;
    /**
     * Returns the new values after the change for the modified columns.
     * Always empty for
     * [DELETE][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.DELETE].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue new_values = 3;</code>
     */
    private $new_values;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $keys
     *           Returns the value of the primary key of the modified row.
     *     @type array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $old_values
     *           Returns the old values before the change for the modified columns.
     *           Always empty for
     *           [INSERT][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.INSERT],
     *           or if old values are not being captured specified by
     *           [value_capture_type][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ValueCaptureType].
     *     @type array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $new_values
     *           Returns the new values after the change for the modified columns.
     *           Always empty for
     *           [DELETE][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.DELETE].
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Spanner\V1\ChangeStream::initOnce();
        parent::__construct($data);
    }

    /**
     * Returns the value of the primary key of the modified row.
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue keys = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Returns the value of the primary key of the modified row.
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue keys = 1;</code>
     * @param array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setKeys($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue::class);
        $this->keys = $arr;

        return $this;
    }

    /**
     * Returns the old values before the change for the modified columns.
     * Always empty for
     * [INSERT][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.INSERT],
     * or if old values are not being captured specified by
     * [value_capture_type][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ValueCaptureType].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue old_values = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOldValues()
    {
        return $this->old_values;
    }

    /**
     * Returns the old values before the change for the modified columns.
     * Always empty for
     * [INSERT][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.INSERT],
     * or if old values are not being captured specified by
     * [value_capture_type][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ValueCaptureType].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue old_values = 2;</code>
     * @param array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOldValues($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue::class);
        $this->old_values = $arr;

        return $this;
    }

    /**
     * Returns the new values after the change for the modified columns.
     * Always empty for
     * [DELETE][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.DELETE].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue new_values = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getNewValues()
    {
        return $this->new_values;
    }

    /**
     * Returns the new values after the change for the modified columns.
     * Always empty for
     * [DELETE][google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModType.DELETE].
     *
     * Generated from protobuf field <code>repeated .google.spanner.v1.ChangeStreamRecord.DataChangeRecord.ModValue new_values = 3;</code>
     * @param array<\Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setNewValues($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Spanner\V1\ChangeStreamRecord\DataChangeRecord\ModValue::class);
        $this->new_values = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Mod::class, \Google\Cloud\Spanner\V1\ChangeStreamRecord_DataChangeRecord_Mod::class);

