<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A request message for InterconnectAttachmentGroups.SetIamPolicy. See the method description for details.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.SetIamPolicyInterconnectAttachmentGroupRequest</code>
 */
class SetIamPolicyInterconnectAttachmentGroupRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The body resource for this request
     *
     * Generated from protobuf field <code>.google.cloud.compute.v1.GlobalSetPolicyRequest global_set_policy_request_resource = 337048498 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $global_set_policy_request_resource = null;
    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $project = '';
    /**
     * Name or id of the resource for this request.
     *
     * Generated from protobuf field <code>string resource = 195806222 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $resource = '';

    /**
     * @param string                                          $project                        Project ID for this request.
     * @param string                                          $resource                       Name or id of the resource for this request.
     * @param \Google\Cloud\Compute\V1\GlobalSetPolicyRequest $globalSetPolicyRequestResource The body resource for this request
     *
     * @return \Google\Cloud\Compute\V1\SetIamPolicyInterconnectAttachmentGroupRequest
     *
     * @experimental
     */
    public static function build(string $project, string $resource, \Google\Cloud\Compute\V1\GlobalSetPolicyRequest $globalSetPolicyRequestResource): self
    {
        return (new self())
            ->setProject($project)
            ->setResource($resource)
            ->setGlobalSetPolicyRequestResource($globalSetPolicyRequestResource);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Compute\V1\GlobalSetPolicyRequest $global_set_policy_request_resource
     *           The body resource for this request
     *     @type string $project
     *           Project ID for this request.
     *     @type string $resource
     *           Name or id of the resource for this request.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * The body resource for this request
     *
     * Generated from protobuf field <code>.google.cloud.compute.v1.GlobalSetPolicyRequest global_set_policy_request_resource = 337048498 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Compute\V1\GlobalSetPolicyRequest|null
     */
    public function getGlobalSetPolicyRequestResource()
    {
        return $this->global_set_policy_request_resource;
    }

    public function hasGlobalSetPolicyRequestResource()
    {
        return isset($this->global_set_policy_request_resource);
    }

    public function clearGlobalSetPolicyRequestResource()
    {
        unset($this->global_set_policy_request_resource);
    }

    /**
     * The body resource for this request
     *
     * Generated from protobuf field <code>.google.cloud.compute.v1.GlobalSetPolicyRequest global_set_policy_request_resource = 337048498 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Compute\V1\GlobalSetPolicyRequest $var
     * @return $this
     */
    public function setGlobalSetPolicyRequestResource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Compute\V1\GlobalSetPolicyRequest::class);
        $this->global_set_policy_request_resource = $var;

        return $this;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setProject($var)
    {
        GPBUtil::checkString($var, True);
        $this->project = $var;

        return $this;
    }

    /**
     * Name or id of the resource for this request.
     *
     * Generated from protobuf field <code>string resource = 195806222 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Name or id of the resource for this request.
     *
     * Generated from protobuf field <code>string resource = 195806222 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setResource($var)
    {
        GPBUtil::checkString($var, True);
        $this->resource = $var;

        return $this;
    }

}

