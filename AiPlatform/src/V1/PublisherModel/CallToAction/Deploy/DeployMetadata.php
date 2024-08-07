<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/publisher_model.proto

namespace Google\Cloud\AIPlatform\V1\PublisherModel\CallToAction\Deploy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Metadata information about the deployment for managing deployment
 * config.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.PublisherModel.CallToAction.Deploy.DeployMetadata</code>
 */
class DeployMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Labels for the deployment. For managing deployment config
     * like verifying, source of deployment config, etc.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. Labels for the deployment. For managing deployment config
     *           like verifying, source of deployment config, etc.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\PublisherModel::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Labels for the deployment. For managing deployment config
     * like verifying, source of deployment config, etc.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. Labels for the deployment. For managing deployment config
     * like verifying, source of deployment config, etc.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

}


