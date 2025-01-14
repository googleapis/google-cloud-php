<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/eventarc/v1/eventarc.proto

namespace Google\Cloud\Eventarc\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request message for the UpdatePipeline method.
 *
 * Generated from protobuf message <code>google.cloud.eventarc.v1.UpdatePipelineRequest</code>
 */
class UpdatePipelineRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The Pipeline to be updated.
     *
     * Generated from protobuf field <code>.google.cloud.eventarc.v1.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $pipeline = null;
    /**
     * Optional. The fields to be updated; only fields explicitly provided are
     * updated. If no field mask is provided, all provided fields in the request
     * are updated. To update all fields, provide a field mask of "*".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $update_mask = null;
    /**
     * Optional. If set to true, and the Pipeline is not found, a new Pipeline
     * will be created. In this situation, `update_mask` is ignored.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $allow_missing = false;
    /**
     * Optional. If set, validate the request and preview the review, but do not
     * post it.
     *
     * Generated from protobuf field <code>bool validate_only = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $validate_only = false;

    /**
     * @param \Google\Cloud\Eventarc\V1\Pipeline $pipeline   Required. The Pipeline to be updated.
     * @param \Google\Protobuf\FieldMask         $updateMask Optional. The fields to be updated; only fields explicitly provided are
     *                                                       updated. If no field mask is provided, all provided fields in the request
     *                                                       are updated. To update all fields, provide a field mask of "*".
     *
     * @return \Google\Cloud\Eventarc\V1\UpdatePipelineRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\Eventarc\V1\Pipeline $pipeline, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setPipeline($pipeline)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Eventarc\V1\Pipeline $pipeline
     *           Required. The Pipeline to be updated.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Optional. The fields to be updated; only fields explicitly provided are
     *           updated. If no field mask is provided, all provided fields in the request
     *           are updated. To update all fields, provide a field mask of "*".
     *     @type bool $allow_missing
     *           Optional. If set to true, and the Pipeline is not found, a new Pipeline
     *           will be created. In this situation, `update_mask` is ignored.
     *     @type bool $validate_only
     *           Optional. If set, validate the request and preview the review, but do not
     *           post it.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Eventarc\V1\Eventarc::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The Pipeline to be updated.
     *
     * Generated from protobuf field <code>.google.cloud.eventarc.v1.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Eventarc\V1\Pipeline|null
     */
    public function getPipeline()
    {
        return $this->pipeline;
    }

    public function hasPipeline()
    {
        return isset($this->pipeline);
    }

    public function clearPipeline()
    {
        unset($this->pipeline);
    }

    /**
     * Required. The Pipeline to be updated.
     *
     * Generated from protobuf field <code>.google.cloud.eventarc.v1.Pipeline pipeline = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Eventarc\V1\Pipeline $var
     * @return $this
     */
    public function setPipeline($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Eventarc\V1\Pipeline::class);
        $this->pipeline = $var;

        return $this;
    }

    /**
     * Optional. The fields to be updated; only fields explicitly provided are
     * updated. If no field mask is provided, all provided fields in the request
     * are updated. To update all fields, provide a field mask of "*".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Optional. The fields to be updated; only fields explicitly provided are
     * updated. If no field mask is provided, all provided fields in the request
     * are updated. To update all fields, provide a field mask of "*".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

    /**
     * Optional. If set to true, and the Pipeline is not found, a new Pipeline
     * will be created. In this situation, `update_mask` is ignored.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getAllowMissing()
    {
        return $this->allow_missing;
    }

    /**
     * Optional. If set to true, and the Pipeline is not found, a new Pipeline
     * will be created. In this situation, `update_mask` is ignored.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setAllowMissing($var)
    {
        GPBUtil::checkBool($var);
        $this->allow_missing = $var;

        return $this;
    }

    /**
     * Optional. If set, validate the request and preview the review, but do not
     * post it.
     *
     * Generated from protobuf field <code>bool validate_only = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getValidateOnly()
    {
        return $this->validate_only;
    }

    /**
     * Optional. If set, validate the request and preview the review, but do not
     * post it.
     *
     * Generated from protobuf field <code>bool validate_only = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setValidateOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->validate_only = $var;

        return $this;
    }

}

