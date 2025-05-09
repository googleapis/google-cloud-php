<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/instance.proto

namespace Google\Cloud\FinancialServices\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to export a list of currently registered parties.
 *
 * Generated from protobuf message <code>google.cloud.financialservices.v1.ExportRegisteredPartiesRequest</code>
 */
class ExportRegisteredPartiesRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The full path to the Instance resource in this API.
     * format: `projects/{project}/locations/{location}/instances/{instance}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Required. The location to output the RegisteredParties.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination dataset = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $dataset = null;
    /**
     * Required. LineOfBusiness to get RegisteredParties from.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.LineOfBusiness line_of_business = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $line_of_business = 0;

    /**
     * @param string                                                 $name           Required. The full path to the Instance resource in this API.
     *                                                                               format: `projects/{project}/locations/{location}/instances/{instance}`
     *                                                                               Please see {@see AMLClient::instanceName()} for help formatting this field.
     * @param \Google\Cloud\FinancialServices\V1\BigQueryDestination $dataset        Required. The location to output the RegisteredParties.
     * @param int                                                    $lineOfBusiness Required. LineOfBusiness to get RegisteredParties from.
     *                                                                               For allowed values, use constants defined on {@see \Google\Cloud\FinancialServices\V1\LineOfBusiness}
     *
     * @return \Google\Cloud\FinancialServices\V1\ExportRegisteredPartiesRequest
     *
     * @experimental
     */
    public static function build(string $name, \Google\Cloud\FinancialServices\V1\BigQueryDestination $dataset, int $lineOfBusiness): self
    {
        return (new self())
            ->setName($name)
            ->setDataset($dataset)
            ->setLineOfBusiness($lineOfBusiness);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The full path to the Instance resource in this API.
     *           format: `projects/{project}/locations/{location}/instances/{instance}`
     *     @type \Google\Cloud\FinancialServices\V1\BigQueryDestination $dataset
     *           Required. The location to output the RegisteredParties.
     *     @type int $line_of_business
     *           Required. LineOfBusiness to get RegisteredParties from.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Financialservices\V1\Instance::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The full path to the Instance resource in this API.
     * format: `projects/{project}/locations/{location}/instances/{instance}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The full path to the Instance resource in this API.
     * format: `projects/{project}/locations/{location}/instances/{instance}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Required. The location to output the RegisteredParties.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination dataset = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\FinancialServices\V1\BigQueryDestination|null
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    public function hasDataset()
    {
        return isset($this->dataset);
    }

    public function clearDataset()
    {
        unset($this->dataset);
    }

    /**
     * Required. The location to output the RegisteredParties.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BigQueryDestination dataset = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\FinancialServices\V1\BigQueryDestination $var
     * @return $this
     */
    public function setDataset($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\FinancialServices\V1\BigQueryDestination::class);
        $this->dataset = $var;

        return $this;
    }

    /**
     * Required. LineOfBusiness to get RegisteredParties from.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.LineOfBusiness line_of_business = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getLineOfBusiness()
    {
        return $this->line_of_business;
    }

    /**
     * Required. LineOfBusiness to get RegisteredParties from.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.LineOfBusiness line_of_business = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setLineOfBusiness($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\FinancialServices\V1\LineOfBusiness::class);
        $this->line_of_business = $var;

        return $this;
    }

}

