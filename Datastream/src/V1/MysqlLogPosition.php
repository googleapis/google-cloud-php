<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datastream/v1/datastream_resources.proto

namespace Google\Cloud\Datastream\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * MySQL log position
 *
 * Generated from protobuf message <code>google.cloud.datastream.v1.MysqlLogPosition</code>
 */
class MysqlLogPosition extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The binary log file name.
     *
     * Generated from protobuf field <code>string log_file = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $log_file = '';
    /**
     * Optional. The position within the binary log file. Default is head of file.
     *
     * Generated from protobuf field <code>optional int32 log_position = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $log_position = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $log_file
     *           Required. The binary log file name.
     *     @type int $log_position
     *           Optional. The position within the binary log file. Default is head of file.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Datastream\V1\DatastreamResources::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The binary log file name.
     *
     * Generated from protobuf field <code>string log_file = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getLogFile()
    {
        return $this->log_file;
    }

    /**
     * Required. The binary log file name.
     *
     * Generated from protobuf field <code>string log_file = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setLogFile($var)
    {
        GPBUtil::checkString($var, True);
        $this->log_file = $var;

        return $this;
    }

    /**
     * Optional. The position within the binary log file. Default is head of file.
     *
     * Generated from protobuf field <code>optional int32 log_position = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getLogPosition()
    {
        return isset($this->log_position) ? $this->log_position : 0;
    }

    public function hasLogPosition()
    {
        return isset($this->log_position);
    }

    public function clearLogPosition()
    {
        unset($this->log_position);
    }

    /**
     * Optional. The position within the binary log file. Default is head of file.
     *
     * Generated from protobuf field <code>optional int32 log_position = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setLogPosition($var)
    {
        GPBUtil::checkInt32($var);
        $this->log_position = $var;

        return $this;
    }

}

