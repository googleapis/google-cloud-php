<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/apphub/v1/apphub_service.proto

namespace Google\Cloud\AppHub\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for DetachServiceProjectAttachment.
 *
 * Generated from protobuf message <code>google.cloud.apphub.v1.DetachServiceProjectAttachmentRequest</code>
 */
class DetachServiceProjectAttachmentRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Service project id and location to detach from a host project.
     * Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. Service project id and location to detach from a host project.
     *                     Only global location is supported. Expected format:
     *                     `projects/{project}/locations/{location}`. Please see
     *                     {@see AppHubClient::locationName()} for help formatting this field.
     *
     * @return \Google\Cloud\AppHub\V1\DetachServiceProjectAttachmentRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. Service project id and location to detach from a host project.
     *           Only global location is supported. Expected format:
     *           `projects/{project}/locations/{location}`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Apphub\V1\ApphubService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Service project id and location to detach from a host project.
     * Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. Service project id and location to detach from a host project.
     * Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
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

}

