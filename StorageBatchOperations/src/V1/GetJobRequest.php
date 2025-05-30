<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/storagebatchoperations/v1/storage_batch_operations.proto

namespace Google\Cloud\StorageBatchOperations\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message for getting a Job
 *
 * Generated from protobuf message <code>google.cloud.storagebatchoperations.v1.GetJobRequest</code>
 */
class GetJobRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. `name` of the job to retrieve.
     * Format: projects/{project_id}/locations/global/jobs/{job_id} .
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. `name` of the job to retrieve.
     *                     Format: projects/{project_id}/locations/global/jobs/{job_id} . Please see
     *                     {@see StorageBatchOperationsClient::jobName()} for help formatting this field.
     *
     * @return \Google\Cloud\StorageBatchOperations\V1\GetJobRequest
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
     *           Required. `name` of the job to retrieve.
     *           Format: projects/{project_id}/locations/global/jobs/{job_id} .
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Storagebatchoperations\V1\StorageBatchOperations::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. `name` of the job to retrieve.
     * Format: projects/{project_id}/locations/global/jobs/{job_id} .
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. `name` of the job to retrieve.
     * Format: projects/{project_id}/locations/global/jobs/{job_id} .
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

