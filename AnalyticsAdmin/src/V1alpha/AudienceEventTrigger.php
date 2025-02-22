<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/audience.proto

namespace Google\Analytics\Admin\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specifies an event to log when a user joins the Audience.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.AudienceEventTrigger</code>
 */
class AudienceEventTrigger extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The event name that will be logged.
     *
     * Generated from protobuf field <code>string event_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $event_name = '';
    /**
     * Required. When to log the event.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.AudienceEventTrigger.LogCondition log_condition = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $log_condition = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $event_name
     *           Required. The event name that will be logged.
     *     @type int $log_condition
     *           Required. When to log the event.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Analytics\Admin\V1Alpha\Audience::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The event name that will be logged.
     *
     * Generated from protobuf field <code>string event_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * Required. The event name that will be logged.
     *
     * Generated from protobuf field <code>string event_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setEventName($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_name = $var;

        return $this;
    }

    /**
     * Required. When to log the event.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.AudienceEventTrigger.LogCondition log_condition = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getLogCondition()
    {
        return $this->log_condition;
    }

    /**
     * Required. When to log the event.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.AudienceEventTrigger.LogCondition log_condition = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setLogCondition($var)
    {
        GPBUtil::checkEnum($var, \Google\Analytics\Admin\V1alpha\AudienceEventTrigger\LogCondition::class);
        $this->log_condition = $var;

        return $this;
    }

}

