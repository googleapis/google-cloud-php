<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/snooze_service.proto

namespace Google\Cloud\Monitoring\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The message definition for retrieving a `Snooze`. Users must specify the
 * field, `name`, which identifies the `Snooze`.
 *
 * Generated from protobuf message <code>google.monitoring.v3.GetSnoozeRequest</code>
 */
class GetSnoozeRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The ID of the `Snooze` to retrieve. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]/snoozes/[SNOOZE_ID]
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The ID of the `Snooze` to retrieve. The format is:
     *
     *                     projects/[PROJECT_ID_OR_NUMBER]/snoozes/[SNOOZE_ID]
     *                     Please see {@see SnoozeServiceClient::snoozeName()} for help formatting this field.
     *
     * @return \Google\Cloud\Monitoring\V3\GetSnoozeRequest
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
     *           Required. The ID of the `Snooze` to retrieve. The format is:
     *               projects/[PROJECT_ID_OR_NUMBER]/snoozes/[SNOOZE_ID]
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Monitoring\V3\SnoozeService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The ID of the `Snooze` to retrieve. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]/snoozes/[SNOOZE_ID]
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The ID of the `Snooze` to retrieve. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]/snoozes/[SNOOZE_ID]
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

