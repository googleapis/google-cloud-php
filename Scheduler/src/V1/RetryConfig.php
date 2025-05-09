<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/scheduler/v1/job.proto

namespace Google\Cloud\Scheduler\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Settings that determine the retry behavior.
 * By default, if a job does not complete successfully (meaning that
 * an acknowledgement is not received from the handler, then it will be retried
 * with exponential backoff according to the settings in
 * [RetryConfig][google.cloud.scheduler.v1.RetryConfig].
 *
 * Generated from protobuf message <code>google.cloud.scheduler.v1.RetryConfig</code>
 */
class RetryConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * The number of attempts that the system will make to run a job using the
     * exponential backoff procedure described by
     * [max_doublings][google.cloud.scheduler.v1.RetryConfig.max_doublings].
     * The default value of retry_count is zero.
     * If retry_count is 0, a job attempt will not be retried if
     * it fails. Instead the Cloud Scheduler system will wait for the
     * next scheduled execution time. Setting retry_count to 0 does not prevent
     * failed jobs from running according to schedule after the failure.
     * If retry_count is set to a non-zero number then Cloud Scheduler
     * will retry failed attempts, using exponential backoff,
     * retry_count times, or until the next scheduled execution time,
     * whichever comes first.
     * Values greater than 5 and negative values are not allowed.
     *
     * Generated from protobuf field <code>int32 retry_count = 1;</code>
     */
    protected $retry_count = 0;
    /**
     * The time limit for retrying a failed job, measured from time when an
     * execution was first attempted. If specified with
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count], the job
     * will be retried until both limits are reached.
     * The default value for max_retry_duration is zero, which means retry
     * duration is unlimited.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_retry_duration = 2;</code>
     */
    protected $max_retry_duration = null;
    /**
     * The minimum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 5 seconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration min_backoff_duration = 3;</code>
     */
    protected $min_backoff_duration = null;
    /**
     * The maximum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 1 hour.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_backoff_duration = 4;</code>
     */
    protected $max_backoff_duration = null;
    /**
     * The time between retries will double `max_doublings` times.
     * A job's retry interval starts at
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration],
     * then doubles `max_doublings` times, then increases linearly, and finally
     * retries at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * up to [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count]
     * times.
     * For example, if
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration]
     * is 10s,
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * is 300s, and `max_doublings` is 3, then the job will first be retried in
     * 10s. The retry interval will double three times, and then increase linearly
     * by 2^3 * 10s.  Finally, the job will retry at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * until the job has been attempted
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times.
     * Thus, the requests will retry at 10s, 20s, 40s, 80s, 160s, 240s, 300s,
     * 300s, ....
     * The default value of this field is 5.
     *
     * Generated from protobuf field <code>int32 max_doublings = 5;</code>
     */
    protected $max_doublings = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $retry_count
     *           The number of attempts that the system will make to run a job using the
     *           exponential backoff procedure described by
     *           [max_doublings][google.cloud.scheduler.v1.RetryConfig.max_doublings].
     *           The default value of retry_count is zero.
     *           If retry_count is 0, a job attempt will not be retried if
     *           it fails. Instead the Cloud Scheduler system will wait for the
     *           next scheduled execution time. Setting retry_count to 0 does not prevent
     *           failed jobs from running according to schedule after the failure.
     *           If retry_count is set to a non-zero number then Cloud Scheduler
     *           will retry failed attempts, using exponential backoff,
     *           retry_count times, or until the next scheduled execution time,
     *           whichever comes first.
     *           Values greater than 5 and negative values are not allowed.
     *     @type \Google\Protobuf\Duration $max_retry_duration
     *           The time limit for retrying a failed job, measured from time when an
     *           execution was first attempted. If specified with
     *           [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count], the job
     *           will be retried until both limits are reached.
     *           The default value for max_retry_duration is zero, which means retry
     *           duration is unlimited.
     *     @type \Google\Protobuf\Duration $min_backoff_duration
     *           The minimum amount of time to wait before retrying a job after
     *           it fails.
     *           The default value of this field is 5 seconds.
     *     @type \Google\Protobuf\Duration $max_backoff_duration
     *           The maximum amount of time to wait before retrying a job after
     *           it fails.
     *           The default value of this field is 1 hour.
     *     @type int $max_doublings
     *           The time between retries will double `max_doublings` times.
     *           A job's retry interval starts at
     *           [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration],
     *           then doubles `max_doublings` times, then increases linearly, and finally
     *           retries at intervals of
     *           [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     *           up to [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count]
     *           times.
     *           For example, if
     *           [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration]
     *           is 10s,
     *           [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     *           is 300s, and `max_doublings` is 3, then the job will first be retried in
     *           10s. The retry interval will double three times, and then increase linearly
     *           by 2^3 * 10s.  Finally, the job will retry at intervals of
     *           [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     *           until the job has been attempted
     *           [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times.
     *           Thus, the requests will retry at 10s, 20s, 40s, 80s, 160s, 240s, 300s,
     *           300s, ....
     *           The default value of this field is 5.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Scheduler\V1\Job::initOnce();
        parent::__construct($data);
    }

    /**
     * The number of attempts that the system will make to run a job using the
     * exponential backoff procedure described by
     * [max_doublings][google.cloud.scheduler.v1.RetryConfig.max_doublings].
     * The default value of retry_count is zero.
     * If retry_count is 0, a job attempt will not be retried if
     * it fails. Instead the Cloud Scheduler system will wait for the
     * next scheduled execution time. Setting retry_count to 0 does not prevent
     * failed jobs from running according to schedule after the failure.
     * If retry_count is set to a non-zero number then Cloud Scheduler
     * will retry failed attempts, using exponential backoff,
     * retry_count times, or until the next scheduled execution time,
     * whichever comes first.
     * Values greater than 5 and negative values are not allowed.
     *
     * Generated from protobuf field <code>int32 retry_count = 1;</code>
     * @return int
     */
    public function getRetryCount()
    {
        return $this->retry_count;
    }

    /**
     * The number of attempts that the system will make to run a job using the
     * exponential backoff procedure described by
     * [max_doublings][google.cloud.scheduler.v1.RetryConfig.max_doublings].
     * The default value of retry_count is zero.
     * If retry_count is 0, a job attempt will not be retried if
     * it fails. Instead the Cloud Scheduler system will wait for the
     * next scheduled execution time. Setting retry_count to 0 does not prevent
     * failed jobs from running according to schedule after the failure.
     * If retry_count is set to a non-zero number then Cloud Scheduler
     * will retry failed attempts, using exponential backoff,
     * retry_count times, or until the next scheduled execution time,
     * whichever comes first.
     * Values greater than 5 and negative values are not allowed.
     *
     * Generated from protobuf field <code>int32 retry_count = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setRetryCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->retry_count = $var;

        return $this;
    }

    /**
     * The time limit for retrying a failed job, measured from time when an
     * execution was first attempted. If specified with
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count], the job
     * will be retried until both limits are reached.
     * The default value for max_retry_duration is zero, which means retry
     * duration is unlimited.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_retry_duration = 2;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getMaxRetryDuration()
    {
        return $this->max_retry_duration;
    }

    public function hasMaxRetryDuration()
    {
        return isset($this->max_retry_duration);
    }

    public function clearMaxRetryDuration()
    {
        unset($this->max_retry_duration);
    }

    /**
     * The time limit for retrying a failed job, measured from time when an
     * execution was first attempted. If specified with
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count], the job
     * will be retried until both limits are reached.
     * The default value for max_retry_duration is zero, which means retry
     * duration is unlimited.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_retry_duration = 2;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setMaxRetryDuration($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->max_retry_duration = $var;

        return $this;
    }

    /**
     * The minimum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 5 seconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration min_backoff_duration = 3;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getMinBackoffDuration()
    {
        return $this->min_backoff_duration;
    }

    public function hasMinBackoffDuration()
    {
        return isset($this->min_backoff_duration);
    }

    public function clearMinBackoffDuration()
    {
        unset($this->min_backoff_duration);
    }

    /**
     * The minimum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 5 seconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration min_backoff_duration = 3;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setMinBackoffDuration($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->min_backoff_duration = $var;

        return $this;
    }

    /**
     * The maximum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 1 hour.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_backoff_duration = 4;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getMaxBackoffDuration()
    {
        return $this->max_backoff_duration;
    }

    public function hasMaxBackoffDuration()
    {
        return isset($this->max_backoff_duration);
    }

    public function clearMaxBackoffDuration()
    {
        unset($this->max_backoff_duration);
    }

    /**
     * The maximum amount of time to wait before retrying a job after
     * it fails.
     * The default value of this field is 1 hour.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration max_backoff_duration = 4;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setMaxBackoffDuration($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->max_backoff_duration = $var;

        return $this;
    }

    /**
     * The time between retries will double `max_doublings` times.
     * A job's retry interval starts at
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration],
     * then doubles `max_doublings` times, then increases linearly, and finally
     * retries at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * up to [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count]
     * times.
     * For example, if
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration]
     * is 10s,
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * is 300s, and `max_doublings` is 3, then the job will first be retried in
     * 10s. The retry interval will double three times, and then increase linearly
     * by 2^3 * 10s.  Finally, the job will retry at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * until the job has been attempted
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times.
     * Thus, the requests will retry at 10s, 20s, 40s, 80s, 160s, 240s, 300s,
     * 300s, ....
     * The default value of this field is 5.
     *
     * Generated from protobuf field <code>int32 max_doublings = 5;</code>
     * @return int
     */
    public function getMaxDoublings()
    {
        return $this->max_doublings;
    }

    /**
     * The time between retries will double `max_doublings` times.
     * A job's retry interval starts at
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration],
     * then doubles `max_doublings` times, then increases linearly, and finally
     * retries at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * up to [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count]
     * times.
     * For example, if
     * [min_backoff_duration][google.cloud.scheduler.v1.RetryConfig.min_backoff_duration]
     * is 10s,
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * is 300s, and `max_doublings` is 3, then the job will first be retried in
     * 10s. The retry interval will double three times, and then increase linearly
     * by 2^3 * 10s.  Finally, the job will retry at intervals of
     * [max_backoff_duration][google.cloud.scheduler.v1.RetryConfig.max_backoff_duration]
     * until the job has been attempted
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times.
     * Thus, the requests will retry at 10s, 20s, 40s, 80s, 160s, 240s, 300s,
     * 300s, ....
     * The default value of this field is 5.
     *
     * Generated from protobuf field <code>int32 max_doublings = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setMaxDoublings($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_doublings = $var;

        return $this;
    }

}

