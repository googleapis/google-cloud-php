<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/cloudbuild/v1/cloudbuild.proto

namespace Google\Cloud\Build\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Returns the `BuildTrigger` with the specified ID.
 *
 * Generated from protobuf message <code>google.devtools.cloudbuild.v1.GetBuildTriggerRequest</code>
 */
class GetBuildTriggerRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The name of the `Trigger` to retrieve.
     * Format: `projects/{project}/locations/{location}/triggers/{trigger}`
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Required. ID of the project that owns the trigger.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $project_id = '';
    /**
     * Required. Identifier (`id` or `name`) of the `BuildTrigger` to get.
     *
     * Generated from protobuf field <code>string trigger_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $trigger_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The name of the `Trigger` to retrieve.
     *           Format: `projects/{project}/locations/{location}/triggers/{trigger}`
     *     @type string $project_id
     *           Required. ID of the project that owns the trigger.
     *     @type string $trigger_id
     *           Required. Identifier (`id` or `name`) of the `BuildTrigger` to get.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Devtools\Cloudbuild\V1\Cloudbuild::initOnce();
        parent::__construct($data);
    }

    /**
     * The name of the `Trigger` to retrieve.
     * Format: `projects/{project}/locations/{location}/triggers/{trigger}`
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name of the `Trigger` to retrieve.
     * Format: `projects/{project}/locations/{location}/triggers/{trigger}`
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.resource_reference) = {</code>
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
     * Required. ID of the project that owns the trigger.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Required. ID of the project that owns the trigger.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setProjectId($var)
    {
        GPBUtil::checkString($var, True);
        $this->project_id = $var;

        return $this;
    }

    /**
     * Required. Identifier (`id` or `name`) of the `BuildTrigger` to get.
     *
     * Generated from protobuf field <code>string trigger_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getTriggerId()
    {
        return $this->trigger_id;
    }

    /**
     * Required. Identifier (`id` or `name`) of the `BuildTrigger` to get.
     *
     * Generated from protobuf field <code>string trigger_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setTriggerId($var)
    {
        GPBUtil::checkString($var, True);
        $this->trigger_id = $var;

        return $this;
    }

}
