<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataform/v1/dataform.proto

namespace Google\Cloud\Dataform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * `ReadRepositoryFile` response message.
 *
 * Generated from protobuf message <code>google.cloud.dataform.v1.ReadRepositoryFileResponse</code>
 */
class ReadRepositoryFileResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The file's contents.
     *
     * Generated from protobuf field <code>bytes contents = 1;</code>
     */
    protected $contents = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $contents
     *           The file's contents.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataform\V1\Dataform::initOnce();
        parent::__construct($data);
    }

    /**
     * The file's contents.
     *
     * Generated from protobuf field <code>bytes contents = 1;</code>
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * The file's contents.
     *
     * Generated from protobuf field <code>bytes contents = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setContents($var)
    {
        GPBUtil::checkString($var, False);
        $this->contents = $var;

        return $this;
    }

}

