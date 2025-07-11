<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/model_garden_service.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for
 * [ModelGardenService.Deploy][google.cloud.aiplatform.v1.ModelGardenService.Deploy].
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.DeployResponse</code>
 */
class DeployResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The name of the PublisherModel resource.
     * Format:
     * `publishers/{publisher}/models/{publisher_model}&#64;{version_id}`, or
     * `publishers/hf-{hugging-face-author}/models/{hugging-face-model-name}&#64;001`
     *
     * Generated from protobuf field <code>string publisher_model = 1 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $publisher_model = '';
    /**
     * Output only. The name of the Endpoint created.
     * Format: `projects/{project}/locations/{location}/endpoints/{endpoint}`
     *
     * Generated from protobuf field <code>string endpoint = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $endpoint = '';
    /**
     * Output only. The name of the Model created.
     * Format: `projects/{project}/locations/{location}/models/{model}`
     *
     * Generated from protobuf field <code>string model = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $model = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $publisher_model
     *           Output only. The name of the PublisherModel resource.
     *           Format:
     *           `publishers/{publisher}/models/{publisher_model}&#64;{version_id}`, or
     *           `publishers/hf-{hugging-face-author}/models/{hugging-face-model-name}&#64;001`
     *     @type string $endpoint
     *           Output only. The name of the Endpoint created.
     *           Format: `projects/{project}/locations/{location}/endpoints/{endpoint}`
     *     @type string $model
     *           Output only. The name of the Model created.
     *           Format: `projects/{project}/locations/{location}/models/{model}`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\ModelGardenService::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The name of the PublisherModel resource.
     * Format:
     * `publishers/{publisher}/models/{publisher_model}&#64;{version_id}`, or
     * `publishers/hf-{hugging-face-author}/models/{hugging-face-model-name}&#64;001`
     *
     * Generated from protobuf field <code>string publisher_model = 1 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getPublisherModel()
    {
        return $this->publisher_model;
    }

    /**
     * Output only. The name of the PublisherModel resource.
     * Format:
     * `publishers/{publisher}/models/{publisher_model}&#64;{version_id}`, or
     * `publishers/hf-{hugging-face-author}/models/{hugging-face-model-name}&#64;001`
     *
     * Generated from protobuf field <code>string publisher_model = 1 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setPublisherModel($var)
    {
        GPBUtil::checkString($var, True);
        $this->publisher_model = $var;

        return $this;
    }

    /**
     * Output only. The name of the Endpoint created.
     * Format: `projects/{project}/locations/{location}/endpoints/{endpoint}`
     *
     * Generated from protobuf field <code>string endpoint = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Output only. The name of the Endpoint created.
     * Format: `projects/{project}/locations/{location}/endpoints/{endpoint}`
     *
     * Generated from protobuf field <code>string endpoint = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setEndpoint($var)
    {
        GPBUtil::checkString($var, True);
        $this->endpoint = $var;

        return $this;
    }

    /**
     * Output only. The name of the Model created.
     * Format: `projects/{project}/locations/{location}/models/{model}`
     *
     * Generated from protobuf field <code>string model = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Output only. The name of the Model created.
     * Format: `projects/{project}/locations/{location}/models/{model}`
     *
     * Generated from protobuf field <code>string model = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setModel($var)
    {
        GPBUtil::checkString($var, True);
        $this->model = $var;

        return $this;
    }

}

