<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/tasks/v2/cloudtasks.proto

namespace Google\Cloud\Tasks\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [PurgeQueue][google.cloud.tasks.v2.CloudTasks.PurgeQueue].
 *
 * Generated from protobuf message <code>google.cloud.tasks.v2.PurgeQueueRequest</code>
 */
class PurgeQueueRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The queue name. For example:
     * `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The queue name. For example:
     *                     `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *                     Please see {@see CloudTasksClient::queueName()} for help formatting this field.
     *
     * @return \Google\Cloud\Tasks\V2\PurgeQueueRequest
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
     *           Required. The queue name. For example:
     *           `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Tasks\V2\Cloudtasks::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The queue name. For example:
     * `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The queue name. For example:
     * `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
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

