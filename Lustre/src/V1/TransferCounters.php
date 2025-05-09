<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/lustre/v1/transfer.proto

namespace Google\Cloud\Lustre\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A collection of counters that report the progress of a transfer operation.
 *
 * Generated from protobuf message <code>google.cloud.lustre.v1.TransferCounters</code>
 */
class TransferCounters extends \Google\Protobuf\Internal\Message
{
    /**
     * Objects found in the data source that are scheduled to be transferred,
     * excluding any that are filtered based on object conditions or skipped due
     * to sync.
     *
     * Generated from protobuf field <code>int64 found_objects_count = 1;</code>
     */
    protected $found_objects_count = 0;
    /**
     * Total number of bytes found in the data source that are scheduled to be
     * transferred, excluding any that are filtered based on object conditions or
     * skipped due to sync.
     *
     * Generated from protobuf field <code>int64 bytes_found_count = 2;</code>
     */
    protected $bytes_found_count = 0;
    /**
     * Objects in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 objects_skipped_count = 3;</code>
     */
    protected $objects_skipped_count = 0;
    /**
     * Bytes in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_skipped_count = 4;</code>
     */
    protected $bytes_skipped_count = 0;
    /**
     * Objects that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_copied_count = 5;</code>
     */
    protected $objects_copied_count = 0;
    /**
     * Bytes that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_copied_count = 6;</code>
     */
    protected $bytes_copied_count = 0;
    /**
     * Output only. Objects that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_failed_count = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $objects_failed_count = 0;
    /**
     * Output only. Bytes that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_failed_count = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $bytes_failed_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $found_objects_count
     *           Objects found in the data source that are scheduled to be transferred,
     *           excluding any that are filtered based on object conditions or skipped due
     *           to sync.
     *     @type int|string $bytes_found_count
     *           Total number of bytes found in the data source that are scheduled to be
     *           transferred, excluding any that are filtered based on object conditions or
     *           skipped due to sync.
     *     @type int|string $objects_skipped_count
     *           Objects in the data source that are not transferred because they already
     *           exist in the data destination.
     *     @type int|string $bytes_skipped_count
     *           Bytes in the data source that are not transferred because they already
     *           exist in the data destination.
     *     @type int|string $objects_copied_count
     *           Objects that are copied to the data destination.
     *     @type int|string $bytes_copied_count
     *           Bytes that are copied to the data destination.
     *     @type int|string $objects_failed_count
     *           Output only. Objects that are failed to write to the data destination.
     *     @type int|string $bytes_failed_count
     *           Output only. Bytes that are failed to write to the data destination.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Lustre\V1\Transfer::initOnce();
        parent::__construct($data);
    }

    /**
     * Objects found in the data source that are scheduled to be transferred,
     * excluding any that are filtered based on object conditions or skipped due
     * to sync.
     *
     * Generated from protobuf field <code>int64 found_objects_count = 1;</code>
     * @return int|string
     */
    public function getFoundObjectsCount()
    {
        return $this->found_objects_count;
    }

    /**
     * Objects found in the data source that are scheduled to be transferred,
     * excluding any that are filtered based on object conditions or skipped due
     * to sync.
     *
     * Generated from protobuf field <code>int64 found_objects_count = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setFoundObjectsCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->found_objects_count = $var;

        return $this;
    }

    /**
     * Total number of bytes found in the data source that are scheduled to be
     * transferred, excluding any that are filtered based on object conditions or
     * skipped due to sync.
     *
     * Generated from protobuf field <code>int64 bytes_found_count = 2;</code>
     * @return int|string
     */
    public function getBytesFoundCount()
    {
        return $this->bytes_found_count;
    }

    /**
     * Total number of bytes found in the data source that are scheduled to be
     * transferred, excluding any that are filtered based on object conditions or
     * skipped due to sync.
     *
     * Generated from protobuf field <code>int64 bytes_found_count = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setBytesFoundCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->bytes_found_count = $var;

        return $this;
    }

    /**
     * Objects in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 objects_skipped_count = 3;</code>
     * @return int|string
     */
    public function getObjectsSkippedCount()
    {
        return $this->objects_skipped_count;
    }

    /**
     * Objects in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 objects_skipped_count = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setObjectsSkippedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->objects_skipped_count = $var;

        return $this;
    }

    /**
     * Bytes in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_skipped_count = 4;</code>
     * @return int|string
     */
    public function getBytesSkippedCount()
    {
        return $this->bytes_skipped_count;
    }

    /**
     * Bytes in the data source that are not transferred because they already
     * exist in the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_skipped_count = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setBytesSkippedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->bytes_skipped_count = $var;

        return $this;
    }

    /**
     * Objects that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_copied_count = 5;</code>
     * @return int|string
     */
    public function getObjectsCopiedCount()
    {
        return $this->objects_copied_count;
    }

    /**
     * Objects that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_copied_count = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setObjectsCopiedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->objects_copied_count = $var;

        return $this;
    }

    /**
     * Bytes that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_copied_count = 6;</code>
     * @return int|string
     */
    public function getBytesCopiedCount()
    {
        return $this->bytes_copied_count;
    }

    /**
     * Bytes that are copied to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_copied_count = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setBytesCopiedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->bytes_copied_count = $var;

        return $this;
    }

    /**
     * Output only. Objects that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_failed_count = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getObjectsFailedCount()
    {
        return $this->objects_failed_count;
    }

    /**
     * Output only. Objects that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 objects_failed_count = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setObjectsFailedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->objects_failed_count = $var;

        return $this;
    }

    /**
     * Output only. Bytes that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_failed_count = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getBytesFailedCount()
    {
        return $this->bytes_failed_count;
    }

    /**
     * Output only. Bytes that are failed to write to the data destination.
     *
     * Generated from protobuf field <code>int64 bytes_failed_count = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setBytesFailedCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->bytes_failed_count = $var;

        return $this;
    }

}

