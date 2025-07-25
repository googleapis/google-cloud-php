<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/config/v1/config.proto

namespace Google\Cloud\Config\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * TerraformBlueprint describes the source of a Terraform root module which
 * describes the resources and configs to be deployed.
 *
 * Generated from protobuf message <code>google.cloud.config.v1.TerraformBlueprint</code>
 */
class TerraformBlueprint extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Input variable values for the Terraform blueprint.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.config.v1.TerraformVariable> input_values = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $input_values;
    protected $source;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $gcs_source
     *           URI of an object in Google Cloud Storage.
     *           Format: `gs://{bucket}/{object}`
     *           URI may also specify an object version for zipped objects.
     *           Format: `gs://{bucket}/{object}#{version}`
     *     @type \Google\Cloud\Config\V1\GitSource $git_source
     *           URI of a public Git repo.
     *     @type array|\Google\Protobuf\Internal\MapField $input_values
     *           Optional. Input variable values for the Terraform blueprint.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Config\V1\Config::initOnce();
        parent::__construct($data);
    }

    /**
     * URI of an object in Google Cloud Storage.
     * Format: `gs://{bucket}/{object}`
     * URI may also specify an object version for zipped objects.
     * Format: `gs://{bucket}/{object}#{version}`
     *
     * Generated from protobuf field <code>string gcs_source = 1;</code>
     * @return string
     */
    public function getGcsSource()
    {
        return $this->readOneof(1);
    }

    public function hasGcsSource()
    {
        return $this->hasOneof(1);
    }

    /**
     * URI of an object in Google Cloud Storage.
     * Format: `gs://{bucket}/{object}`
     * URI may also specify an object version for zipped objects.
     * Format: `gs://{bucket}/{object}#{version}`
     *
     * Generated from protobuf field <code>string gcs_source = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setGcsSource($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * URI of a public Git repo.
     *
     * Generated from protobuf field <code>.google.cloud.config.v1.GitSource git_source = 2;</code>
     * @return \Google\Cloud\Config\V1\GitSource|null
     */
    public function getGitSource()
    {
        return $this->readOneof(2);
    }

    public function hasGitSource()
    {
        return $this->hasOneof(2);
    }

    /**
     * URI of a public Git repo.
     *
     * Generated from protobuf field <code>.google.cloud.config.v1.GitSource git_source = 2;</code>
     * @param \Google\Cloud\Config\V1\GitSource $var
     * @return $this
     */
    public function setGitSource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Config\V1\GitSource::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Optional. Input variable values for the Terraform blueprint.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.config.v1.TerraformVariable> input_values = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getInputValues()
    {
        return $this->input_values;
    }

    /**
     * Optional. Input variable values for the Terraform blueprint.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.config.v1.TerraformVariable> input_values = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setInputValues($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Config\V1\TerraformVariable::class);
        $this->input_values = $arr;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->whichOneof("source");
    }

}

