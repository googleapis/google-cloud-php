<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/model.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Contains information about the source of the models generated from Model
 * Garden.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.ModelGardenSource</code>
 */
class ModelGardenSource extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The model garden source model resource name.
     *
     * Generated from protobuf field <code>string public_model_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $public_model_name = '';
    /**
     * Optional. The model garden source model version ID.
     *
     * Generated from protobuf field <code>string version_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $version_id = '';
    /**
     * Optional. Whether to avoid pulling the model from the HF cache.
     *
     * Generated from protobuf field <code>bool skip_hf_model_cache = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $skip_hf_model_cache = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $public_model_name
     *           Required. The model garden source model resource name.
     *     @type string $version_id
     *           Optional. The model garden source model version ID.
     *     @type bool $skip_hf_model_cache
     *           Optional. Whether to avoid pulling the model from the HF cache.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\Model::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The model garden source model resource name.
     *
     * Generated from protobuf field <code>string public_model_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getPublicModelName()
    {
        return $this->public_model_name;
    }

    /**
     * Required. The model garden source model resource name.
     *
     * Generated from protobuf field <code>string public_model_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setPublicModelName($var)
    {
        GPBUtil::checkString($var, True);
        $this->public_model_name = $var;

        return $this;
    }

    /**
     * Optional. The model garden source model version ID.
     *
     * Generated from protobuf field <code>string version_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getVersionId()
    {
        return $this->version_id;
    }

    /**
     * Optional. The model garden source model version ID.
     *
     * Generated from protobuf field <code>string version_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setVersionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->version_id = $var;

        return $this;
    }

    /**
     * Optional. Whether to avoid pulling the model from the HF cache.
     *
     * Generated from protobuf field <code>bool skip_hf_model_cache = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getSkipHfModelCache()
    {
        return $this->skip_hf_model_cache;
    }

    /**
     * Optional. Whether to avoid pulling the model from the HF cache.
     *
     * Generated from protobuf field <code>bool skip_hf_model_cache = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setSkipHfModelCache($var)
    {
        GPBUtil::checkBool($var);
        $this->skip_hf_model_cache = $var;

        return $this;
    }

}

