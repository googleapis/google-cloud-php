<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/tasks.proto

namespace Google\Cloud\Dataplex\V1\Task;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Task scheduling and trigger settings.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.Task.TriggerSpec</code>
 */
class TriggerSpec extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Immutable. Trigger type of the user-specified Task.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Task.TriggerSpec.Type type = 5 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $type = 0;
    /**
     * Optional. The first run of the task will be after this time.
     * If not specified, the task will run shortly after being submitted if
     * ON_DEMAND and based on the schedule if RECURRING.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $start_time = null;
    /**
     * Optional. Prevent the task from executing.
     * This does not cancel already running tasks. It is intended to temporarily
     * disable RECURRING tasks.
     *
     * Generated from protobuf field <code>bool disabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $disabled = false;
    /**
     * Optional. Number of retry attempts before aborting.
     * Set to zero to never attempt to retry a failed task.
     *
     * Generated from protobuf field <code>int32 max_retries = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $max_retries = 0;
    protected $trigger;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type
     *           Required. Immutable. Trigger type of the user-specified Task.
     *     @type \Google\Protobuf\Timestamp $start_time
     *           Optional. The first run of the task will be after this time.
     *           If not specified, the task will run shortly after being submitted if
     *           ON_DEMAND and based on the schedule if RECURRING.
     *     @type bool $disabled
     *           Optional. Prevent the task from executing.
     *           This does not cancel already running tasks. It is intended to temporarily
     *           disable RECURRING tasks.
     *     @type int $max_retries
     *           Optional. Number of retry attempts before aborting.
     *           Set to zero to never attempt to retry a failed task.
     *     @type string $schedule
     *           Optional. Cron schedule (https://en.wikipedia.org/wiki/Cron) for
     *           running tasks periodically. To explicitly set a timezone to the cron
     *           tab, apply a prefix in the cron tab: "CRON_TZ=${IANA_TIME_ZONE}" or
     *           "TZ=${IANA_TIME_ZONE}". The ${IANA_TIME_ZONE} may only be a valid
     *           string from IANA time zone database. For example,
     *           `CRON_TZ=America/New_York 1 * * * *`, or `TZ=America/New_York 1 * * *
     *           *`. This field is required for RECURRING tasks.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\Tasks::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Immutable. Trigger type of the user-specified Task.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Task.TriggerSpec.Type type = 5 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = IMMUTABLE];</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Required. Immutable. Trigger type of the user-specified Task.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Task.TriggerSpec.Type type = 5 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = IMMUTABLE];</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Dataplex\V1\Task\TriggerSpec\Type::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Optional. The first run of the task will be after this time.
     * If not specified, the task will run shortly after being submitted if
     * ON_DEMAND and based on the schedule if RECURRING.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    public function hasStartTime()
    {
        return isset($this->start_time);
    }

    public function clearStartTime()
    {
        unset($this->start_time);
    }

    /**
     * Optional. The first run of the task will be after this time.
     * If not specified, the task will run shortly after being submitted if
     * ON_DEMAND and based on the schedule if RECURRING.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setStartTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->start_time = $var;

        return $this;
    }

    /**
     * Optional. Prevent the task from executing.
     * This does not cancel already running tasks. It is intended to temporarily
     * disable RECURRING tasks.
     *
     * Generated from protobuf field <code>bool disabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Optional. Prevent the task from executing.
     * This does not cancel already running tasks. It is intended to temporarily
     * disable RECURRING tasks.
     *
     * Generated from protobuf field <code>bool disabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setDisabled($var)
    {
        GPBUtil::checkBool($var);
        $this->disabled = $var;

        return $this;
    }

    /**
     * Optional. Number of retry attempts before aborting.
     * Set to zero to never attempt to retry a failed task.
     *
     * Generated from protobuf field <code>int32 max_retries = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getMaxRetries()
    {
        return $this->max_retries;
    }

    /**
     * Optional. Number of retry attempts before aborting.
     * Set to zero to never attempt to retry a failed task.
     *
     * Generated from protobuf field <code>int32 max_retries = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setMaxRetries($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_retries = $var;

        return $this;
    }

    /**
     * Optional. Cron schedule (https://en.wikipedia.org/wiki/Cron) for
     * running tasks periodically. To explicitly set a timezone to the cron
     * tab, apply a prefix in the cron tab: "CRON_TZ=${IANA_TIME_ZONE}" or
     * "TZ=${IANA_TIME_ZONE}". The ${IANA_TIME_ZONE} may only be a valid
     * string from IANA time zone database. For example,
     * `CRON_TZ=America/New_York 1 * * * *`, or `TZ=America/New_York 1 * * *
     * *`. This field is required for RECURRING tasks.
     *
     * Generated from protobuf field <code>string schedule = 100 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getSchedule()
    {
        return $this->readOneof(100);
    }

    public function hasSchedule()
    {
        return $this->hasOneof(100);
    }

    /**
     * Optional. Cron schedule (https://en.wikipedia.org/wiki/Cron) for
     * running tasks periodically. To explicitly set a timezone to the cron
     * tab, apply a prefix in the cron tab: "CRON_TZ=${IANA_TIME_ZONE}" or
     * "TZ=${IANA_TIME_ZONE}". The ${IANA_TIME_ZONE} may only be a valid
     * string from IANA time zone database. For example,
     * `CRON_TZ=America/New_York 1 * * * *`, or `TZ=America/New_York 1 * * *
     * *`. This field is required for RECURRING tasks.
     *
     * Generated from protobuf field <code>string schedule = 100 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setSchedule($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(100, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getTrigger()
    {
        return $this->whichOneof("trigger");
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(TriggerSpec::class, \Google\Cloud\Dataplex\V1\Task_TriggerSpec::class);
