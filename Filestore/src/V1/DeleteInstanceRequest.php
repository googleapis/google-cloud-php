<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/filestore/v1/cloud_filestore_service.proto

namespace Google\Cloud\Filestore\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * DeleteInstanceRequest deletes an instance.
 *
 * Generated from protobuf message <code>google.cloud.filestore.v1.DeleteInstanceRequest</code>
 */
class DeleteInstanceRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The instance resource name, in the format
     * `projects/{project_id}/locations/{location}/instances/{instance_id}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * If set to true, all snapshots of the instance will also be deleted.
     * (Otherwise, the request will only work if the instance has no snapshots.)
     *
     * Generated from protobuf field <code>bool force = 2;</code>
     */
    protected $force = false;

    /**
     * @param string $name Required. The instance resource name, in the format
     *                     `projects/{project_id}/locations/{location}/instances/{instance_id}`
     *                     Please see {@see CloudFilestoreManagerClient::instanceName()} for help formatting this field.
     *
     * @return \Google\Cloud\Filestore\V1\DeleteInstanceRequest
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
     *           Required. The instance resource name, in the format
     *           `projects/{project_id}/locations/{location}/instances/{instance_id}`
     *     @type bool $force
     *           If set to true, all snapshots of the instance will also be deleted.
     *           (Otherwise, the request will only work if the instance has no snapshots.)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Filestore\V1\CloudFilestoreService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The instance resource name, in the format
     * `projects/{project_id}/locations/{location}/instances/{instance_id}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The instance resource name, in the format
     * `projects/{project_id}/locations/{location}/instances/{instance_id}`
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
     * If set to true, all snapshots of the instance will also be deleted.
     * (Otherwise, the request will only work if the instance has no snapshots.)
     *
     * Generated from protobuf field <code>bool force = 2;</code>
     * @return bool
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * If set to true, all snapshots of the instance will also be deleted.
     * (Otherwise, the request will only work if the instance has no snapshots.)
     *
     * Generated from protobuf field <code>bool force = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setForce($var)
    {
        GPBUtil::checkBool($var);
        $this->force = $var;

        return $this;
    }

}

