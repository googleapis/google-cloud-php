<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/io.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The Google Cloud Storage location for the input content.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.GcsSource</code>
 */
class GcsSource extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Google Cloud Storage URI(-s) to the input file(s). May contain
     * wildcards. For more information on wildcards, see
     * https://cloud.google.com/storage/docs/wildcards.
     *
     * Generated from protobuf field <code>repeated string uris = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $uris;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $uris
     *           Required. Google Cloud Storage URI(-s) to the input file(s). May contain
     *           wildcards. For more information on wildcards, see
     *           https://cloud.google.com/storage/docs/wildcards.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\Io::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Google Cloud Storage URI(-s) to the input file(s). May contain
     * wildcards. For more information on wildcards, see
     * https://cloud.google.com/storage/docs/wildcards.
     *
     * Generated from protobuf field <code>repeated string uris = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUris()
    {
        return $this->uris;
    }

    /**
     * Required. Google Cloud Storage URI(-s) to the input file(s). May contain
     * wildcards. For more information on wildcards, see
     * https://cloud.google.com/storage/docs/wildcards.
     *
     * Generated from protobuf field <code>repeated string uris = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUris($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->uris = $arr;

        return $this;
    }

}

