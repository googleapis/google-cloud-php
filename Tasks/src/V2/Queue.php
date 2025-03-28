<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/tasks/v2/queue.proto

namespace Google\Cloud\Tasks\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A queue is a container of related tasks. Queues are configured to manage
 * how those tasks are dispatched. Configurable properties include rate limits,
 * retry options, queue types, and others.
 *
 * Generated from protobuf message <code>google.cloud.tasks.v2.Queue</code>
 */
class Queue extends \Google\Protobuf\Internal\Message
{
    /**
     * Caller-specified and required in
     * [CreateQueue][google.cloud.tasks.v2.CloudTasks.CreateQueue], after which it
     * becomes output only.
     * The queue name.
     * The queue name must have the following format:
     * `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the queue's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `QUEUE_ID` can contain letters ([A-Za-z]), numbers ([0-9]), or
     *   hyphens (-). The maximum length is 100 characters.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * Overrides for
     * [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     * These settings apply only to
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in this
     * queue. [Http tasks][google.cloud.tasks.v2.HttpRequest] are not affected.
     * If set, `app_engine_routing_override` is used for all
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in the
     * queue, no matter what the setting is for the [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.AppEngineRouting app_engine_routing_override = 2;</code>
     */
    protected $app_engine_routing_override = null;
    /**
     * Rate limits for task dispatches.
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] and
     * [retry_config][google.cloud.tasks.v2.Queue.retry_config] are related
     * because they both control task attempts. However they control task attempts
     * in different ways:
     * * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] controls the total
     * rate of
     *   dispatches from a queue (i.e. all traffic dispatched from the
     *   queue, regardless of whether the dispatch is from a first
     *   attempt or a retry).
     * * [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls what
     * happens to
     *   particular a task after its first attempt fails. That is,
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls task
     *   retries (the second attempt, third attempt, etc).
     * The queue's actual dispatch rate is the result of:
     * * Number of tasks in the queue
     * * User-specified throttling:
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits],
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config], and the
     *   [queue's state][google.cloud.tasks.v2.Queue.state].
     * * System throttling due to `429` (Too Many Requests) or `503` (Service
     *   Unavailable) responses from the worker, high error rates, or to smooth
     *   sudden large traffic spikes.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RateLimits rate_limits = 3;</code>
     */
    protected $rate_limits = null;
    /**
     * Settings that determine the retry behavior.
     * * For tasks created using Cloud Tasks: the queue-level retry settings
     *   apply to all tasks in the queue that were created using Cloud Tasks.
     *   Retry settings cannot be set on individual tasks.
     * * For tasks created using the App Engine SDK: the queue-level retry
     *   settings apply to all tasks in the queue which do not have retry settings
     *   explicitly set on the task and were created by the App Engine SDK. See
     *   [App Engine
     *   documentation](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/retrying-tasks).
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RetryConfig retry_config = 4;</code>
     */
    protected $retry_config = null;
    /**
     * Output only. The state of the queue.
     * `state` can only be changed by calling
     * [PauseQueue][google.cloud.tasks.v2.CloudTasks.PauseQueue],
     * [ResumeQueue][google.cloud.tasks.v2.CloudTasks.ResumeQueue], or uploading
     * [queue.yaml/xml](https://cloud.google.com/appengine/docs/python/config/queueref).
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] cannot be used
     * to change `state`.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.Queue.State state = 5;</code>
     */
    protected $state = 0;
    /**
     * Output only. The last time this queue was purged.
     * All tasks that were [created][google.cloud.tasks.v2.Task.create_time]
     * before this time were purged.
     * A queue can be purged using
     * [PurgeQueue][google.cloud.tasks.v2.CloudTasks.PurgeQueue], the [App Engine
     * Task Queue SDK, or the Cloud
     * Console](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/deleting-tasks-and-queues#purging_all_tasks_from_a_queue).
     * Purge time will be truncated to the nearest microsecond. Purge
     * time will be unset if the queue has never been purged.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp purge_time = 6;</code>
     */
    protected $purge_time = null;
    /**
     * Configuration options for writing logs to
     * [Stackdriver Logging](https://cloud.google.com/logging/docs/). If this
     * field is unset, then no logs are written.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.StackdriverLoggingConfig stackdriver_logging_config = 9;</code>
     */
    protected $stackdriver_logging_config = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Caller-specified and required in
     *           [CreateQueue][google.cloud.tasks.v2.CloudTasks.CreateQueue], after which it
     *           becomes output only.
     *           The queue name.
     *           The queue name must have the following format:
     *           `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *           * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *              hyphens (-), colons (:), or periods (.).
     *              For more information, see
     *              [Identifying
     *              projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     *           * `LOCATION_ID` is the canonical ID for the queue's location.
     *              The list of available locations can be obtained by calling
     *              [ListLocations][google.cloud.location.Locations.ListLocations].
     *              For more information, see https://cloud.google.com/about/locations/.
     *           * `QUEUE_ID` can contain letters ([A-Za-z]), numbers ([0-9]), or
     *             hyphens (-). The maximum length is 100 characters.
     *     @type \Google\Cloud\Tasks\V2\AppEngineRouting $app_engine_routing_override
     *           Overrides for
     *           [task-level
     *           app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     *           These settings apply only to
     *           [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in this
     *           queue. [Http tasks][google.cloud.tasks.v2.HttpRequest] are not affected.
     *           If set, `app_engine_routing_override` is used for all
     *           [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in the
     *           queue, no matter what the setting is for the [task-level
     *           app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     *     @type \Google\Cloud\Tasks\V2\RateLimits $rate_limits
     *           Rate limits for task dispatches.
     *           [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] and
     *           [retry_config][google.cloud.tasks.v2.Queue.retry_config] are related
     *           because they both control task attempts. However they control task attempts
     *           in different ways:
     *           * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] controls the total
     *           rate of
     *             dispatches from a queue (i.e. all traffic dispatched from the
     *             queue, regardless of whether the dispatch is from a first
     *             attempt or a retry).
     *           * [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls what
     *           happens to
     *             particular a task after its first attempt fails. That is,
     *             [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls task
     *             retries (the second attempt, third attempt, etc).
     *           The queue's actual dispatch rate is the result of:
     *           * Number of tasks in the queue
     *           * User-specified throttling:
     *           [rate_limits][google.cloud.tasks.v2.Queue.rate_limits],
     *             [retry_config][google.cloud.tasks.v2.Queue.retry_config], and the
     *             [queue's state][google.cloud.tasks.v2.Queue.state].
     *           * System throttling due to `429` (Too Many Requests) or `503` (Service
     *             Unavailable) responses from the worker, high error rates, or to smooth
     *             sudden large traffic spikes.
     *     @type \Google\Cloud\Tasks\V2\RetryConfig $retry_config
     *           Settings that determine the retry behavior.
     *           * For tasks created using Cloud Tasks: the queue-level retry settings
     *             apply to all tasks in the queue that were created using Cloud Tasks.
     *             Retry settings cannot be set on individual tasks.
     *           * For tasks created using the App Engine SDK: the queue-level retry
     *             settings apply to all tasks in the queue which do not have retry settings
     *             explicitly set on the task and were created by the App Engine SDK. See
     *             [App Engine
     *             documentation](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/retrying-tasks).
     *     @type int $state
     *           Output only. The state of the queue.
     *           `state` can only be changed by calling
     *           [PauseQueue][google.cloud.tasks.v2.CloudTasks.PauseQueue],
     *           [ResumeQueue][google.cloud.tasks.v2.CloudTasks.ResumeQueue], or uploading
     *           [queue.yaml/xml](https://cloud.google.com/appengine/docs/python/config/queueref).
     *           [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] cannot be used
     *           to change `state`.
     *     @type \Google\Protobuf\Timestamp $purge_time
     *           Output only. The last time this queue was purged.
     *           All tasks that were [created][google.cloud.tasks.v2.Task.create_time]
     *           before this time were purged.
     *           A queue can be purged using
     *           [PurgeQueue][google.cloud.tasks.v2.CloudTasks.PurgeQueue], the [App Engine
     *           Task Queue SDK, or the Cloud
     *           Console](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/deleting-tasks-and-queues#purging_all_tasks_from_a_queue).
     *           Purge time will be truncated to the nearest microsecond. Purge
     *           time will be unset if the queue has never been purged.
     *     @type \Google\Cloud\Tasks\V2\StackdriverLoggingConfig $stackdriver_logging_config
     *           Configuration options for writing logs to
     *           [Stackdriver Logging](https://cloud.google.com/logging/docs/). If this
     *           field is unset, then no logs are written.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Tasks\V2\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * Caller-specified and required in
     * [CreateQueue][google.cloud.tasks.v2.CloudTasks.CreateQueue], after which it
     * becomes output only.
     * The queue name.
     * The queue name must have the following format:
     * `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the queue's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `QUEUE_ID` can contain letters ([A-Za-z]), numbers ([0-9]), or
     *   hyphens (-). The maximum length is 100 characters.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Caller-specified and required in
     * [CreateQueue][google.cloud.tasks.v2.CloudTasks.CreateQueue], after which it
     * becomes output only.
     * The queue name.
     * The queue name must have the following format:
     * `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the queue's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `QUEUE_ID` can contain letters ([A-Za-z]), numbers ([0-9]), or
     *   hyphens (-). The maximum length is 100 characters.
     *
     * Generated from protobuf field <code>string name = 1;</code>
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
     * Overrides for
     * [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     * These settings apply only to
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in this
     * queue. [Http tasks][google.cloud.tasks.v2.HttpRequest] are not affected.
     * If set, `app_engine_routing_override` is used for all
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in the
     * queue, no matter what the setting is for the [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.AppEngineRouting app_engine_routing_override = 2;</code>
     * @return \Google\Cloud\Tasks\V2\AppEngineRouting|null
     */
    public function getAppEngineRoutingOverride()
    {
        return $this->app_engine_routing_override;
    }

    public function hasAppEngineRoutingOverride()
    {
        return isset($this->app_engine_routing_override);
    }

    public function clearAppEngineRoutingOverride()
    {
        unset($this->app_engine_routing_override);
    }

    /**
     * Overrides for
     * [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     * These settings apply only to
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in this
     * queue. [Http tasks][google.cloud.tasks.v2.HttpRequest] are not affected.
     * If set, `app_engine_routing_override` is used for all
     * [App Engine tasks][google.cloud.tasks.v2.AppEngineHttpRequest] in the
     * queue, no matter what the setting is for the [task-level
     * app_engine_routing][google.cloud.tasks.v2.AppEngineHttpRequest.app_engine_routing].
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.AppEngineRouting app_engine_routing_override = 2;</code>
     * @param \Google\Cloud\Tasks\V2\AppEngineRouting $var
     * @return $this
     */
    public function setAppEngineRoutingOverride($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Tasks\V2\AppEngineRouting::class);
        $this->app_engine_routing_override = $var;

        return $this;
    }

    /**
     * Rate limits for task dispatches.
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] and
     * [retry_config][google.cloud.tasks.v2.Queue.retry_config] are related
     * because they both control task attempts. However they control task attempts
     * in different ways:
     * * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] controls the total
     * rate of
     *   dispatches from a queue (i.e. all traffic dispatched from the
     *   queue, regardless of whether the dispatch is from a first
     *   attempt or a retry).
     * * [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls what
     * happens to
     *   particular a task after its first attempt fails. That is,
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls task
     *   retries (the second attempt, third attempt, etc).
     * The queue's actual dispatch rate is the result of:
     * * Number of tasks in the queue
     * * User-specified throttling:
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits],
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config], and the
     *   [queue's state][google.cloud.tasks.v2.Queue.state].
     * * System throttling due to `429` (Too Many Requests) or `503` (Service
     *   Unavailable) responses from the worker, high error rates, or to smooth
     *   sudden large traffic spikes.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RateLimits rate_limits = 3;</code>
     * @return \Google\Cloud\Tasks\V2\RateLimits|null
     */
    public function getRateLimits()
    {
        return $this->rate_limits;
    }

    public function hasRateLimits()
    {
        return isset($this->rate_limits);
    }

    public function clearRateLimits()
    {
        unset($this->rate_limits);
    }

    /**
     * Rate limits for task dispatches.
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] and
     * [retry_config][google.cloud.tasks.v2.Queue.retry_config] are related
     * because they both control task attempts. However they control task attempts
     * in different ways:
     * * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits] controls the total
     * rate of
     *   dispatches from a queue (i.e. all traffic dispatched from the
     *   queue, regardless of whether the dispatch is from a first
     *   attempt or a retry).
     * * [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls what
     * happens to
     *   particular a task after its first attempt fails. That is,
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config] controls task
     *   retries (the second attempt, third attempt, etc).
     * The queue's actual dispatch rate is the result of:
     * * Number of tasks in the queue
     * * User-specified throttling:
     * [rate_limits][google.cloud.tasks.v2.Queue.rate_limits],
     *   [retry_config][google.cloud.tasks.v2.Queue.retry_config], and the
     *   [queue's state][google.cloud.tasks.v2.Queue.state].
     * * System throttling due to `429` (Too Many Requests) or `503` (Service
     *   Unavailable) responses from the worker, high error rates, or to smooth
     *   sudden large traffic spikes.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RateLimits rate_limits = 3;</code>
     * @param \Google\Cloud\Tasks\V2\RateLimits $var
     * @return $this
     */
    public function setRateLimits($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Tasks\V2\RateLimits::class);
        $this->rate_limits = $var;

        return $this;
    }

    /**
     * Settings that determine the retry behavior.
     * * For tasks created using Cloud Tasks: the queue-level retry settings
     *   apply to all tasks in the queue that were created using Cloud Tasks.
     *   Retry settings cannot be set on individual tasks.
     * * For tasks created using the App Engine SDK: the queue-level retry
     *   settings apply to all tasks in the queue which do not have retry settings
     *   explicitly set on the task and were created by the App Engine SDK. See
     *   [App Engine
     *   documentation](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/retrying-tasks).
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RetryConfig retry_config = 4;</code>
     * @return \Google\Cloud\Tasks\V2\RetryConfig|null
     */
    public function getRetryConfig()
    {
        return $this->retry_config;
    }

    public function hasRetryConfig()
    {
        return isset($this->retry_config);
    }

    public function clearRetryConfig()
    {
        unset($this->retry_config);
    }

    /**
     * Settings that determine the retry behavior.
     * * For tasks created using Cloud Tasks: the queue-level retry settings
     *   apply to all tasks in the queue that were created using Cloud Tasks.
     *   Retry settings cannot be set on individual tasks.
     * * For tasks created using the App Engine SDK: the queue-level retry
     *   settings apply to all tasks in the queue which do not have retry settings
     *   explicitly set on the task and were created by the App Engine SDK. See
     *   [App Engine
     *   documentation](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/retrying-tasks).
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.RetryConfig retry_config = 4;</code>
     * @param \Google\Cloud\Tasks\V2\RetryConfig $var
     * @return $this
     */
    public function setRetryConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Tasks\V2\RetryConfig::class);
        $this->retry_config = $var;

        return $this;
    }

    /**
     * Output only. The state of the queue.
     * `state` can only be changed by calling
     * [PauseQueue][google.cloud.tasks.v2.CloudTasks.PauseQueue],
     * [ResumeQueue][google.cloud.tasks.v2.CloudTasks.ResumeQueue], or uploading
     * [queue.yaml/xml](https://cloud.google.com/appengine/docs/python/config/queueref).
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] cannot be used
     * to change `state`.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.Queue.State state = 5;</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Output only. The state of the queue.
     * `state` can only be changed by calling
     * [PauseQueue][google.cloud.tasks.v2.CloudTasks.PauseQueue],
     * [ResumeQueue][google.cloud.tasks.v2.CloudTasks.ResumeQueue], or uploading
     * [queue.yaml/xml](https://cloud.google.com/appengine/docs/python/config/queueref).
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] cannot be used
     * to change `state`.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.Queue.State state = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Tasks\V2\Queue\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * Output only. The last time this queue was purged.
     * All tasks that were [created][google.cloud.tasks.v2.Task.create_time]
     * before this time were purged.
     * A queue can be purged using
     * [PurgeQueue][google.cloud.tasks.v2.CloudTasks.PurgeQueue], the [App Engine
     * Task Queue SDK, or the Cloud
     * Console](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/deleting-tasks-and-queues#purging_all_tasks_from_a_queue).
     * Purge time will be truncated to the nearest microsecond. Purge
     * time will be unset if the queue has never been purged.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp purge_time = 6;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getPurgeTime()
    {
        return $this->purge_time;
    }

    public function hasPurgeTime()
    {
        return isset($this->purge_time);
    }

    public function clearPurgeTime()
    {
        unset($this->purge_time);
    }

    /**
     * Output only. The last time this queue was purged.
     * All tasks that were [created][google.cloud.tasks.v2.Task.create_time]
     * before this time were purged.
     * A queue can be purged using
     * [PurgeQueue][google.cloud.tasks.v2.CloudTasks.PurgeQueue], the [App Engine
     * Task Queue SDK, or the Cloud
     * Console](https://cloud.google.com/appengine/docs/standard/python/taskqueue/push/deleting-tasks-and-queues#purging_all_tasks_from_a_queue).
     * Purge time will be truncated to the nearest microsecond. Purge
     * time will be unset if the queue has never been purged.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp purge_time = 6;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setPurgeTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->purge_time = $var;

        return $this;
    }

    /**
     * Configuration options for writing logs to
     * [Stackdriver Logging](https://cloud.google.com/logging/docs/). If this
     * field is unset, then no logs are written.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.StackdriverLoggingConfig stackdriver_logging_config = 9;</code>
     * @return \Google\Cloud\Tasks\V2\StackdriverLoggingConfig|null
     */
    public function getStackdriverLoggingConfig()
    {
        return $this->stackdriver_logging_config;
    }

    public function hasStackdriverLoggingConfig()
    {
        return isset($this->stackdriver_logging_config);
    }

    public function clearStackdriverLoggingConfig()
    {
        unset($this->stackdriver_logging_config);
    }

    /**
     * Configuration options for writing logs to
     * [Stackdriver Logging](https://cloud.google.com/logging/docs/). If this
     * field is unset, then no logs are written.
     *
     * Generated from protobuf field <code>.google.cloud.tasks.v2.StackdriverLoggingConfig stackdriver_logging_config = 9;</code>
     * @param \Google\Cloud\Tasks\V2\StackdriverLoggingConfig $var
     * @return $this
     */
    public function setStackdriverLoggingConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Tasks\V2\StackdriverLoggingConfig::class);
        $this->stackdriver_logging_config = $var;

        return $this;
    }

}

