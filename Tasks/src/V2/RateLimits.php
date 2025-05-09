<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/tasks/v2/queue.proto

namespace Google\Cloud\Tasks\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Rate limits.
 * This message determines the maximum rate that tasks can be dispatched by a
 * queue, regardless of whether the dispatch is a first task attempt or a retry.
 * Note: The debugging command,
 * [RunTask][google.cloud.tasks.v2.CloudTasks.RunTask], will run a task even if
 * the queue has reached its [RateLimits][google.cloud.tasks.v2.RateLimits].
 *
 * Generated from protobuf message <code>google.cloud.tasks.v2.RateLimits</code>
 */
class RateLimits extends \Google\Protobuf\Internal\Message
{
    /**
     * The maximum rate at which tasks are dispatched from this queue.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * * The maximum allowed value is 500.
     * This field has the same meaning as
     * [rate in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#rate).
     *
     * Generated from protobuf field <code>double max_dispatches_per_second = 1;</code>
     */
    protected $max_dispatches_per_second = 0.0;
    /**
     * Output only. The max burst size.
     * Max burst size limits how fast tasks in queue are processed when
     * many tasks are in the queue and the rate is high. This field
     * allows the queue to have a high rate so processing starts shortly
     * after a task is enqueued, but still limits resource usage when
     * many tasks are enqueued in a short period of time.
     * The [token bucket](https://wikipedia.org/wiki/Token_Bucket)
     * algorithm is used to control the rate of task dispatches. Each
     * queue has a token bucket that holds tokens, up to the maximum
     * specified by `max_burst_size`. Each time a task is dispatched, a
     * token is removed from the bucket. Tasks will be dispatched until
     * the queue's bucket runs out of tokens. The bucket will be
     * continuously refilled with new tokens based on
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * Cloud Tasks will pick the value of `max_burst_size` based on the
     * value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * For queues that were created or updated using
     * `queue.yaml/xml`, `max_burst_size` is equal to
     * [bucket_size](https://cloud.google.com/appengine/docs/standard/python/config/queueref#bucket_size).
     * Since `max_burst_size` is output only, if
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] is called on a
     * queue created by `queue.yaml/xml`, `max_burst_size` will be reset based on
     * the value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second],
     * regardless of whether
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second]
     * is updated.
     *
     * Generated from protobuf field <code>int32 max_burst_size = 2;</code>
     */
    protected $max_burst_size = 0;
    /**
     * The maximum number of concurrent tasks that Cloud Tasks allows
     * to be dispatched for this queue. After this threshold has been
     * reached, Cloud Tasks stops dispatching tasks until the number of
     * concurrent requests decreases.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * The maximum allowed value is 5,000.
     * This field has the same meaning as
     * [max_concurrent_requests in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#max_concurrent_requests).
     *
     * Generated from protobuf field <code>int32 max_concurrent_dispatches = 3;</code>
     */
    protected $max_concurrent_dispatches = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $max_dispatches_per_second
     *           The maximum rate at which tasks are dispatched from this queue.
     *           If unspecified when the queue is created, Cloud Tasks will pick the
     *           default.
     *           * The maximum allowed value is 500.
     *           This field has the same meaning as
     *           [rate in
     *           queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#rate).
     *     @type int $max_burst_size
     *           Output only. The max burst size.
     *           Max burst size limits how fast tasks in queue are processed when
     *           many tasks are in the queue and the rate is high. This field
     *           allows the queue to have a high rate so processing starts shortly
     *           after a task is enqueued, but still limits resource usage when
     *           many tasks are enqueued in a short period of time.
     *           The [token bucket](https://wikipedia.org/wiki/Token_Bucket)
     *           algorithm is used to control the rate of task dispatches. Each
     *           queue has a token bucket that holds tokens, up to the maximum
     *           specified by `max_burst_size`. Each time a task is dispatched, a
     *           token is removed from the bucket. Tasks will be dispatched until
     *           the queue's bucket runs out of tokens. The bucket will be
     *           continuously refilled with new tokens based on
     *           [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     *           Cloud Tasks will pick the value of `max_burst_size` based on the
     *           value of
     *           [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     *           For queues that were created or updated using
     *           `queue.yaml/xml`, `max_burst_size` is equal to
     *           [bucket_size](https://cloud.google.com/appengine/docs/standard/python/config/queueref#bucket_size).
     *           Since `max_burst_size` is output only, if
     *           [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] is called on a
     *           queue created by `queue.yaml/xml`, `max_burst_size` will be reset based on
     *           the value of
     *           [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second],
     *           regardless of whether
     *           [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second]
     *           is updated.
     *     @type int $max_concurrent_dispatches
     *           The maximum number of concurrent tasks that Cloud Tasks allows
     *           to be dispatched for this queue. After this threshold has been
     *           reached, Cloud Tasks stops dispatching tasks until the number of
     *           concurrent requests decreases.
     *           If unspecified when the queue is created, Cloud Tasks will pick the
     *           default.
     *           The maximum allowed value is 5,000.
     *           This field has the same meaning as
     *           [max_concurrent_requests in
     *           queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#max_concurrent_requests).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Tasks\V2\Queue::initOnce();
        parent::__construct($data);
    }

    /**
     * The maximum rate at which tasks are dispatched from this queue.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * * The maximum allowed value is 500.
     * This field has the same meaning as
     * [rate in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#rate).
     *
     * Generated from protobuf field <code>double max_dispatches_per_second = 1;</code>
     * @return float
     */
    public function getMaxDispatchesPerSecond()
    {
        return $this->max_dispatches_per_second;
    }

    /**
     * The maximum rate at which tasks are dispatched from this queue.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * * The maximum allowed value is 500.
     * This field has the same meaning as
     * [rate in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#rate).
     *
     * Generated from protobuf field <code>double max_dispatches_per_second = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setMaxDispatchesPerSecond($var)
    {
        GPBUtil::checkDouble($var);
        $this->max_dispatches_per_second = $var;

        return $this;
    }

    /**
     * Output only. The max burst size.
     * Max burst size limits how fast tasks in queue are processed when
     * many tasks are in the queue and the rate is high. This field
     * allows the queue to have a high rate so processing starts shortly
     * after a task is enqueued, but still limits resource usage when
     * many tasks are enqueued in a short period of time.
     * The [token bucket](https://wikipedia.org/wiki/Token_Bucket)
     * algorithm is used to control the rate of task dispatches. Each
     * queue has a token bucket that holds tokens, up to the maximum
     * specified by `max_burst_size`. Each time a task is dispatched, a
     * token is removed from the bucket. Tasks will be dispatched until
     * the queue's bucket runs out of tokens. The bucket will be
     * continuously refilled with new tokens based on
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * Cloud Tasks will pick the value of `max_burst_size` based on the
     * value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * For queues that were created or updated using
     * `queue.yaml/xml`, `max_burst_size` is equal to
     * [bucket_size](https://cloud.google.com/appengine/docs/standard/python/config/queueref#bucket_size).
     * Since `max_burst_size` is output only, if
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] is called on a
     * queue created by `queue.yaml/xml`, `max_burst_size` will be reset based on
     * the value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second],
     * regardless of whether
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second]
     * is updated.
     *
     * Generated from protobuf field <code>int32 max_burst_size = 2;</code>
     * @return int
     */
    public function getMaxBurstSize()
    {
        return $this->max_burst_size;
    }

    /**
     * Output only. The max burst size.
     * Max burst size limits how fast tasks in queue are processed when
     * many tasks are in the queue and the rate is high. This field
     * allows the queue to have a high rate so processing starts shortly
     * after a task is enqueued, but still limits resource usage when
     * many tasks are enqueued in a short period of time.
     * The [token bucket](https://wikipedia.org/wiki/Token_Bucket)
     * algorithm is used to control the rate of task dispatches. Each
     * queue has a token bucket that holds tokens, up to the maximum
     * specified by `max_burst_size`. Each time a task is dispatched, a
     * token is removed from the bucket. Tasks will be dispatched until
     * the queue's bucket runs out of tokens. The bucket will be
     * continuously refilled with new tokens based on
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * Cloud Tasks will pick the value of `max_burst_size` based on the
     * value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second].
     * For queues that were created or updated using
     * `queue.yaml/xml`, `max_burst_size` is equal to
     * [bucket_size](https://cloud.google.com/appengine/docs/standard/python/config/queueref#bucket_size).
     * Since `max_burst_size` is output only, if
     * [UpdateQueue][google.cloud.tasks.v2.CloudTasks.UpdateQueue] is called on a
     * queue created by `queue.yaml/xml`, `max_burst_size` will be reset based on
     * the value of
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second],
     * regardless of whether
     * [max_dispatches_per_second][google.cloud.tasks.v2.RateLimits.max_dispatches_per_second]
     * is updated.
     *
     * Generated from protobuf field <code>int32 max_burst_size = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setMaxBurstSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_burst_size = $var;

        return $this;
    }

    /**
     * The maximum number of concurrent tasks that Cloud Tasks allows
     * to be dispatched for this queue. After this threshold has been
     * reached, Cloud Tasks stops dispatching tasks until the number of
     * concurrent requests decreases.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * The maximum allowed value is 5,000.
     * This field has the same meaning as
     * [max_concurrent_requests in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#max_concurrent_requests).
     *
     * Generated from protobuf field <code>int32 max_concurrent_dispatches = 3;</code>
     * @return int
     */
    public function getMaxConcurrentDispatches()
    {
        return $this->max_concurrent_dispatches;
    }

    /**
     * The maximum number of concurrent tasks that Cloud Tasks allows
     * to be dispatched for this queue. After this threshold has been
     * reached, Cloud Tasks stops dispatching tasks until the number of
     * concurrent requests decreases.
     * If unspecified when the queue is created, Cloud Tasks will pick the
     * default.
     * The maximum allowed value is 5,000.
     * This field has the same meaning as
     * [max_concurrent_requests in
     * queue.yaml/xml](https://cloud.google.com/appengine/docs/standard/python/config/queueref#max_concurrent_requests).
     *
     * Generated from protobuf field <code>int32 max_concurrent_dispatches = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setMaxConcurrentDispatches($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_concurrent_dispatches = $var;

        return $this;
    }

}

