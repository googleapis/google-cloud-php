<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/model.proto

namespace Google\Cloud\FinancialServices\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for exporting Model metadata.
 *
 * Generated from protobuf message <code>google.cloud.financialservices.v1.ExportModelMetadataRequest</code>
 */
class ExportModelMetadataRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the Model.
     *
     * Generated from protobuf field <code>string model = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $model = '';
    /**
     * Required. BigQuery output where the metadata will be written.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination structured_metadata_destination = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $structured_metadata_destination = null;

    /**
     * @param string                                                 $model                         Required. The resource name of the Model. Please see
     *                                                                                              {@see AMLClient::modelName()} for help formatting this field.
     * @param \Google\Cloud\FinancialServices\V1\BigQueryDestination $structuredMetadataDestination Required. BigQuery output where the metadata will be written.
     *
     * @return \Google\Cloud\FinancialServices\V1\ExportModelMetadataRequest
     *
     * @experimental
     */
    public static function build(string $model, \Google\Cloud\FinancialServices\V1\BigQueryDestination $structuredMetadataDestination): self
    {
        return (new self())
            ->setModel($model)
            ->setStructuredMetadataDestination($structuredMetadataDestination);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $model
     *           Required. The resource name of the Model.
     *     @type \Google\Cloud\FinancialServices\V1\BigQueryDestination $structured_metadata_destination
     *           Required. BigQuery output where the metadata will be written.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Financialservices\V1\Model::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the Model.
     *
     * Generated from protobuf field <code>string model = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Required. The resource name of the Model.
     *
     * Generated from protobuf field <code>string model = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setModel($var)
    {
        GPBUtil::checkString($var, True);
        $this->model = $var;

        return $this;
    }

    /**
     * Required. BigQuery output where the metadata will be written.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination structured_metadata_destination = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\FinancialServices\V1\BigQueryDestination|null
     */
    public function getStructuredMetadataDestination()
    {
        return $this->structured_metadata_destination;
    }

    public function hasStructuredMetadataDestination()
    {
        return isset($this->structured_metadata_destination);
    }

    public function clearStructuredMetadataDestination()
    {
        unset($this->structured_metadata_destination);
    }

    /**
     * Required. BigQuery output where the metadata will be written.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination structured_metadata_destination = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\FinancialServices\V1\BigQueryDestination $var
     * @return $this
     */
    public function setStructuredMetadataDestination($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\FinancialServices\V1\BigQueryDestination::class);
        $this->structured_metadata_destination = $var;

        return $this;
    }

}

