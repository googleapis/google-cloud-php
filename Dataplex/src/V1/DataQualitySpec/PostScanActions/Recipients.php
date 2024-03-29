<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/data_quality.proto

namespace Google\Cloud\Dataplex\V1\DataQualitySpec\PostScanActions;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The individuals or groups who are designated to receive notifications
 * upon triggers.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.DataQualitySpec.PostScanActions.Recipients</code>
 */
class Recipients extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The email recipients who will receive the DataQualityScan
     * results report.
     *
     * Generated from protobuf field <code>repeated string emails = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $emails;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $emails
     *           Optional. The email recipients who will receive the DataQualityScan
     *           results report.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\DataQuality::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The email recipients who will receive the DataQualityScan
     * results report.
     *
     * Generated from protobuf field <code>repeated string emails = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Optional. The email recipients who will receive the DataQualityScan
     * results report.
     *
     * Generated from protobuf field <code>repeated string emails = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEmails($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->emails = $arr;

        return $this;
    }

}


