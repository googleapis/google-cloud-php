<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v2/file.proto

namespace Google\Cloud\SecurityCenter\V2\File;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Operation(s) performed on a file.
 *
 * Generated from protobuf message <code>google.cloud.securitycenter.v2.File.FileOperation</code>
 */
class FileOperation extends \Google\Protobuf\Internal\Message
{
    /**
     * The type of the operation
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.File.FileOperation.OperationType type = 1;</code>
     */
    protected $type = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type
     *           The type of the operation
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycenter\V2\File::initOnce();
        parent::__construct($data);
    }

    /**
     * The type of the operation
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.File.FileOperation.OperationType type = 1;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * The type of the operation
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.File.FileOperation.OperationType type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\SecurityCenter\V2\File\FileOperation\OperationType::class);
        $this->type = $var;

        return $this;
    }

}


