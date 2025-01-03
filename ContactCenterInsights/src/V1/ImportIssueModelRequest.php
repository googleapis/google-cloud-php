<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/contactcenterinsights/v1/contact_center_insights.proto

namespace Google\Cloud\ContactCenterInsights\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to import an issue model.
 *
 * Generated from protobuf message <code>google.cloud.contactcenterinsights.v1.ImportIssueModelRequest</code>
 */
class ImportIssueModelRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The parent resource of the issue model.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Optional. If set to true, will create an issue model from the imported file
     * with randomly generated IDs for the issue model and corresponding issues.
     * Otherwise, replaces an existing model with the same ID as the file.
     *
     * Generated from protobuf field <code>bool create_new_model = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $create_new_model = false;
    protected $Source;

    /**
     * @param string $parent Required. The parent resource of the issue model. Please see
     *                       {@see ContactCenterInsightsClient::locationName()} for help formatting this field.
     *
     * @return \Google\Cloud\ContactCenterInsights\V1\ImportIssueModelRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\ContactCenterInsights\V1\ImportIssueModelRequest\GcsSource $gcs_source
     *           Google Cloud Storage source message.
     *     @type string $parent
     *           Required. The parent resource of the issue model.
     *     @type bool $create_new_model
     *           Optional. If set to true, will create an issue model from the imported file
     *           with randomly generated IDs for the issue model and corresponding issues.
     *           Otherwise, replaces an existing model with the same ID as the file.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Contactcenterinsights\V1\ContactCenterInsights::initOnce();
        parent::__construct($data);
    }

    /**
     * Google Cloud Storage source message.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.ImportIssueModelRequest.GcsSource gcs_source = 2;</code>
     * @return \Google\Cloud\ContactCenterInsights\V1\ImportIssueModelRequest\GcsSource|null
     */
    public function getGcsSource()
    {
        return $this->readOneof(2);
    }

    public function hasGcsSource()
    {
        return $this->hasOneof(2);
    }

    /**
     * Google Cloud Storage source message.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.ImportIssueModelRequest.GcsSource gcs_source = 2;</code>
     * @param \Google\Cloud\ContactCenterInsights\V1\ImportIssueModelRequest\GcsSource $var
     * @return $this
     */
    public function setGcsSource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\ContactCenterInsights\V1\ImportIssueModelRequest\GcsSource::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Required. The parent resource of the issue model.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The parent resource of the issue model.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Optional. If set to true, will create an issue model from the imported file
     * with randomly generated IDs for the issue model and corresponding issues.
     * Otherwise, replaces an existing model with the same ID as the file.
     *
     * Generated from protobuf field <code>bool create_new_model = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getCreateNewModel()
    {
        return $this->create_new_model;
    }

    /**
     * Optional. If set to true, will create an issue model from the imported file
     * with randomly generated IDs for the issue model and corresponding issues.
     * Otherwise, replaces an existing model with the same ID as the file.
     *
     * Generated from protobuf field <code>bool create_new_model = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setCreateNewModel($var)
    {
        GPBUtil::checkBool($var);
        $this->create_new_model = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->whichOneof("Source");
    }

}

