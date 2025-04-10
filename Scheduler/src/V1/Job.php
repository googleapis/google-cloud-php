<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/scheduler/v1/job.proto

namespace Google\Cloud\Scheduler\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Configuration for a job.
 * The maximum allowed size for a job is 1MB.
 *
 * Generated from protobuf message <code>google.cloud.scheduler.v1.Job</code>
 */
class Job extends \Google\Protobuf\Internal\Message
{
    /**
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob], after
     * which it becomes output only.
     * The job name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID/jobs/JOB_ID`.
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the job's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `JOB_ID` can contain only letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), or underscores (_). The maximum length is 500 characters.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob] or
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * A human-readable description for the job. This string must not contain
     * more than 500 characters.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     */
    protected $description = '';
    /**
     * Required, except when used with
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * Describes the schedule on which the job will be executed.
     * The schedule can be either of the following types:
     * * [Crontab](https://en.wikipedia.org/wiki/Cron#Overview)
     * * English-like
     * [schedule](https://cloud.google.com/scheduler/docs/configuring/cron-job-schedules)
     * As a general rule, execution `n + 1` of a job will not begin
     * until execution `n` has finished. Cloud Scheduler will never
     * allow two simultaneously outstanding executions. For example,
     * this implies that if the `n+1`th execution is scheduled to run at
     * 16:00 but the `n`th execution takes until 16:15, the `n+1`th
     * execution will not start until `16:15`.
     * A scheduled start time will be delayed if the previous
     * execution has not ended when its scheduled time occurs.
     * If [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] > 0 and
     * a job attempt fails, the job will be tried a total of
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times,
     * with exponential backoff, until the next scheduled start time. If
     * retry_count is 0, a job attempt will not be retried if it fails. Instead
     * the Cloud Scheduler system will wait for the next scheduled execution time.
     * Setting retry_count to 0 does not prevent failed jobs from running
     * according to schedule after the failure.
     *
     * Generated from protobuf field <code>string schedule = 20;</code>
     */
    protected $schedule = '';
    /**
     * Specifies the time zone to be used in interpreting
     * [schedule][google.cloud.scheduler.v1.Job.schedule]. The value of this field
     * must be a time zone name from the [tz
     * database](http://en.wikipedia.org/wiki/Tz_database).
     * Note that some time zones include a provision for
     * daylight savings time. The rules for daylight saving time are
     * determined by the chosen tz. For UTC use the string "utc". If a
     * time zone is not specified, the default will be in UTC (also known
     * as GMT).
     *
     * Generated from protobuf field <code>string time_zone = 21;</code>
     */
    protected $time_zone = '';
    /**
     * Output only. The creation time of the job.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp user_update_time = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $user_update_time = null;
    /**
     * Output only. State of the job.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.Job.State state = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $state = 0;
    /**
     * Output only. The response from the target for the last attempted execution.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $status = null;
    /**
     * Output only. The next time the job is scheduled. Note that this may be a
     * retry of a previously failed attempt or the next execution time
     * according to the schedule.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp schedule_time = 17 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $schedule_time = null;
    /**
     * Output only. The time the last job attempt started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp last_attempt_time = 18 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $last_attempt_time = null;
    /**
     * Settings that determine the retry behavior.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.RetryConfig retry_config = 19;</code>
     */
    protected $retry_config = null;
    /**
     * The deadline for job attempts. If the request handler does not respond by
     * this deadline then the request is cancelled and the attempt is marked as a
     * `DEADLINE_EXCEEDED` failure. The failed attempt can be viewed in
     * execution logs. Cloud Scheduler will retry the job according
     * to the [RetryConfig][google.cloud.scheduler.v1.RetryConfig].
     * The default and the allowed values depend on the type of target:
     * * For [HTTP targets][google.cloud.scheduler.v1.Job.http_target], the
     * default is 3 minutes. The deadline must be in the interval [15 seconds, 30
     * minutes].
     * * For [App Engine HTTP
     * targets][google.cloud.scheduler.v1.Job.app_engine_http_target], 0 indicates
     * that the request has the default deadline. The default deadline depends on
     * the scaling type of the service: 10 minutes for standard apps with
     * automatic scaling, 24 hours for standard apps with manual and basic
     * scaling, and 60 minutes for flex apps. If the request deadline is set, it
     * must be in the interval [15 seconds, 24 hours 15 seconds].
     * * For [Pub/Sub targets][google.cloud.scheduler.v1.Job.pubsub_target], this
     * field is ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration attempt_deadline = 22;</code>
     */
    protected $attempt_deadline = null;
    protected $target;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Optionally caller-specified in
     *           [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob], after
     *           which it becomes output only.
     *           The job name. For example:
     *           `projects/PROJECT_ID/locations/LOCATION_ID/jobs/JOB_ID`.
     *           * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *              hyphens (-), colons (:), or periods (.).
     *              For more information, see
     *              [Identifying
     *              projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     *           * `LOCATION_ID` is the canonical ID for the job's location.
     *              The list of available locations can be obtained by calling
     *              [ListLocations][google.cloud.location.Locations.ListLocations].
     *              For more information, see https://cloud.google.com/about/locations/.
     *           * `JOB_ID` can contain only letters ([A-Za-z]), numbers ([0-9]),
     *              hyphens (-), or underscores (_). The maximum length is 500 characters.
     *     @type string $description
     *           Optionally caller-specified in
     *           [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob] or
     *           [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     *           A human-readable description for the job. This string must not contain
     *           more than 500 characters.
     *     @type \Google\Cloud\Scheduler\V1\PubsubTarget $pubsub_target
     *           Pub/Sub target.
     *     @type \Google\Cloud\Scheduler\V1\AppEngineHttpTarget $app_engine_http_target
     *           App Engine HTTP target.
     *     @type \Google\Cloud\Scheduler\V1\HttpTarget $http_target
     *           HTTP target.
     *     @type string $schedule
     *           Required, except when used with
     *           [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     *           Describes the schedule on which the job will be executed.
     *           The schedule can be either of the following types:
     *           * [Crontab](https://en.wikipedia.org/wiki/Cron#Overview)
     *           * English-like
     *           [schedule](https://cloud.google.com/scheduler/docs/configuring/cron-job-schedules)
     *           As a general rule, execution `n + 1` of a job will not begin
     *           until execution `n` has finished. Cloud Scheduler will never
     *           allow two simultaneously outstanding executions. For example,
     *           this implies that if the `n+1`th execution is scheduled to run at
     *           16:00 but the `n`th execution takes until 16:15, the `n+1`th
     *           execution will not start until `16:15`.
     *           A scheduled start time will be delayed if the previous
     *           execution has not ended when its scheduled time occurs.
     *           If [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] > 0 and
     *           a job attempt fails, the job will be tried a total of
     *           [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times,
     *           with exponential backoff, until the next scheduled start time. If
     *           retry_count is 0, a job attempt will not be retried if it fails. Instead
     *           the Cloud Scheduler system will wait for the next scheduled execution time.
     *           Setting retry_count to 0 does not prevent failed jobs from running
     *           according to schedule after the failure.
     *     @type string $time_zone
     *           Specifies the time zone to be used in interpreting
     *           [schedule][google.cloud.scheduler.v1.Job.schedule]. The value of this field
     *           must be a time zone name from the [tz
     *           database](http://en.wikipedia.org/wiki/Tz_database).
     *           Note that some time zones include a provision for
     *           daylight savings time. The rules for daylight saving time are
     *           determined by the chosen tz. For UTC use the string "utc". If a
     *           time zone is not specified, the default will be in UTC (also known
     *           as GMT).
     *     @type \Google\Protobuf\Timestamp $user_update_time
     *           Output only. The creation time of the job.
     *     @type int $state
     *           Output only. State of the job.
     *     @type \Google\Rpc\Status $status
     *           Output only. The response from the target for the last attempted execution.
     *     @type \Google\Protobuf\Timestamp $schedule_time
     *           Output only. The next time the job is scheduled. Note that this may be a
     *           retry of a previously failed attempt or the next execution time
     *           according to the schedule.
     *     @type \Google\Protobuf\Timestamp $last_attempt_time
     *           Output only. The time the last job attempt started.
     *     @type \Google\Cloud\Scheduler\V1\RetryConfig $retry_config
     *           Settings that determine the retry behavior.
     *     @type \Google\Protobuf\Duration $attempt_deadline
     *           The deadline for job attempts. If the request handler does not respond by
     *           this deadline then the request is cancelled and the attempt is marked as a
     *           `DEADLINE_EXCEEDED` failure. The failed attempt can be viewed in
     *           execution logs. Cloud Scheduler will retry the job according
     *           to the [RetryConfig][google.cloud.scheduler.v1.RetryConfig].
     *           The default and the allowed values depend on the type of target:
     *           * For [HTTP targets][google.cloud.scheduler.v1.Job.http_target], the
     *           default is 3 minutes. The deadline must be in the interval [15 seconds, 30
     *           minutes].
     *           * For [App Engine HTTP
     *           targets][google.cloud.scheduler.v1.Job.app_engine_http_target], 0 indicates
     *           that the request has the default deadline. The default deadline depends on
     *           the scaling type of the service: 10 minutes for standard apps with
     *           automatic scaling, 24 hours for standard apps with manual and basic
     *           scaling, and 60 minutes for flex apps. If the request deadline is set, it
     *           must be in the interval [15 seconds, 24 hours 15 seconds].
     *           * For [Pub/Sub targets][google.cloud.scheduler.v1.Job.pubsub_target], this
     *           field is ignored.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Scheduler\V1\Job::initOnce();
        parent::__construct($data);
    }

    /**
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob], after
     * which it becomes output only.
     * The job name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID/jobs/JOB_ID`.
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the job's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `JOB_ID` can contain only letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), or underscores (_). The maximum length is 500 characters.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob], after
     * which it becomes output only.
     * The job name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID/jobs/JOB_ID`.
     * * `PROJECT_ID` can contain letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), colons (:), or periods (.).
     *    For more information, see
     *    [Identifying
     *    projects](https://cloud.google.com/resource-manager/docs/creating-managing-projects#identifying_projects)
     * * `LOCATION_ID` is the canonical ID for the job's location.
     *    The list of available locations can be obtained by calling
     *    [ListLocations][google.cloud.location.Locations.ListLocations].
     *    For more information, see https://cloud.google.com/about/locations/.
     * * `JOB_ID` can contain only letters ([A-Za-z]), numbers ([0-9]),
     *    hyphens (-), or underscores (_). The maximum length is 500 characters.
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
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob] or
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * A human-readable description for the job. This string must not contain
     * more than 500 characters.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Optionally caller-specified in
     * [CreateJob][google.cloud.scheduler.v1.CloudScheduler.CreateJob] or
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * A human-readable description for the job. This string must not contain
     * more than 500 characters.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Pub/Sub target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.PubsubTarget pubsub_target = 4;</code>
     * @return \Google\Cloud\Scheduler\V1\PubsubTarget|null
     */
    public function getPubsubTarget()
    {
        return $this->readOneof(4);
    }

    public function hasPubsubTarget()
    {
        return $this->hasOneof(4);
    }

    /**
     * Pub/Sub target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.PubsubTarget pubsub_target = 4;</code>
     * @param \Google\Cloud\Scheduler\V1\PubsubTarget $var
     * @return $this
     */
    public function setPubsubTarget($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Scheduler\V1\PubsubTarget::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * App Engine HTTP target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.AppEngineHttpTarget app_engine_http_target = 5;</code>
     * @return \Google\Cloud\Scheduler\V1\AppEngineHttpTarget|null
     */
    public function getAppEngineHttpTarget()
    {
        return $this->readOneof(5);
    }

    public function hasAppEngineHttpTarget()
    {
        return $this->hasOneof(5);
    }

    /**
     * App Engine HTTP target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.AppEngineHttpTarget app_engine_http_target = 5;</code>
     * @param \Google\Cloud\Scheduler\V1\AppEngineHttpTarget $var
     * @return $this
     */
    public function setAppEngineHttpTarget($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Scheduler\V1\AppEngineHttpTarget::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * HTTP target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.HttpTarget http_target = 6;</code>
     * @return \Google\Cloud\Scheduler\V1\HttpTarget|null
     */
    public function getHttpTarget()
    {
        return $this->readOneof(6);
    }

    public function hasHttpTarget()
    {
        return $this->hasOneof(6);
    }

    /**
     * HTTP target.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.HttpTarget http_target = 6;</code>
     * @param \Google\Cloud\Scheduler\V1\HttpTarget $var
     * @return $this
     */
    public function setHttpTarget($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Scheduler\V1\HttpTarget::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Required, except when used with
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * Describes the schedule on which the job will be executed.
     * The schedule can be either of the following types:
     * * [Crontab](https://en.wikipedia.org/wiki/Cron#Overview)
     * * English-like
     * [schedule](https://cloud.google.com/scheduler/docs/configuring/cron-job-schedules)
     * As a general rule, execution `n + 1` of a job will not begin
     * until execution `n` has finished. Cloud Scheduler will never
     * allow two simultaneously outstanding executions. For example,
     * this implies that if the `n+1`th execution is scheduled to run at
     * 16:00 but the `n`th execution takes until 16:15, the `n+1`th
     * execution will not start until `16:15`.
     * A scheduled start time will be delayed if the previous
     * execution has not ended when its scheduled time occurs.
     * If [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] > 0 and
     * a job attempt fails, the job will be tried a total of
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times,
     * with exponential backoff, until the next scheduled start time. If
     * retry_count is 0, a job attempt will not be retried if it fails. Instead
     * the Cloud Scheduler system will wait for the next scheduled execution time.
     * Setting retry_count to 0 does not prevent failed jobs from running
     * according to schedule after the failure.
     *
     * Generated from protobuf field <code>string schedule = 20;</code>
     * @return string
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Required, except when used with
     * [UpdateJob][google.cloud.scheduler.v1.CloudScheduler.UpdateJob].
     * Describes the schedule on which the job will be executed.
     * The schedule can be either of the following types:
     * * [Crontab](https://en.wikipedia.org/wiki/Cron#Overview)
     * * English-like
     * [schedule](https://cloud.google.com/scheduler/docs/configuring/cron-job-schedules)
     * As a general rule, execution `n + 1` of a job will not begin
     * until execution `n` has finished. Cloud Scheduler will never
     * allow two simultaneously outstanding executions. For example,
     * this implies that if the `n+1`th execution is scheduled to run at
     * 16:00 but the `n`th execution takes until 16:15, the `n+1`th
     * execution will not start until `16:15`.
     * A scheduled start time will be delayed if the previous
     * execution has not ended when its scheduled time occurs.
     * If [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] > 0 and
     * a job attempt fails, the job will be tried a total of
     * [retry_count][google.cloud.scheduler.v1.RetryConfig.retry_count] times,
     * with exponential backoff, until the next scheduled start time. If
     * retry_count is 0, a job attempt will not be retried if it fails. Instead
     * the Cloud Scheduler system will wait for the next scheduled execution time.
     * Setting retry_count to 0 does not prevent failed jobs from running
     * according to schedule after the failure.
     *
     * Generated from protobuf field <code>string schedule = 20;</code>
     * @param string $var
     * @return $this
     */
    public function setSchedule($var)
    {
        GPBUtil::checkString($var, True);
        $this->schedule = $var;

        return $this;
    }

    /**
     * Specifies the time zone to be used in interpreting
     * [schedule][google.cloud.scheduler.v1.Job.schedule]. The value of this field
     * must be a time zone name from the [tz
     * database](http://en.wikipedia.org/wiki/Tz_database).
     * Note that some time zones include a provision for
     * daylight savings time. The rules for daylight saving time are
     * determined by the chosen tz. For UTC use the string "utc". If a
     * time zone is not specified, the default will be in UTC (also known
     * as GMT).
     *
     * Generated from protobuf field <code>string time_zone = 21;</code>
     * @return string
     */
    public function getTimeZone()
    {
        return $this->time_zone;
    }

    /**
     * Specifies the time zone to be used in interpreting
     * [schedule][google.cloud.scheduler.v1.Job.schedule]. The value of this field
     * must be a time zone name from the [tz
     * database](http://en.wikipedia.org/wiki/Tz_database).
     * Note that some time zones include a provision for
     * daylight savings time. The rules for daylight saving time are
     * determined by the chosen tz. For UTC use the string "utc". If a
     * time zone is not specified, the default will be in UTC (also known
     * as GMT).
     *
     * Generated from protobuf field <code>string time_zone = 21;</code>
     * @param string $var
     * @return $this
     */
    public function setTimeZone($var)
    {
        GPBUtil::checkString($var, True);
        $this->time_zone = $var;

        return $this;
    }

    /**
     * Output only. The creation time of the job.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp user_update_time = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUserUpdateTime()
    {
        return $this->user_update_time;
    }

    public function hasUserUpdateTime()
    {
        return isset($this->user_update_time);
    }

    public function clearUserUpdateTime()
    {
        unset($this->user_update_time);
    }

    /**
     * Output only. The creation time of the job.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp user_update_time = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUserUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->user_update_time = $var;

        return $this;
    }

    /**
     * Output only. State of the job.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.Job.State state = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Output only. State of the job.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.Job.State state = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Scheduler\V1\Job\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * Output only. The response from the target for the last attempted execution.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Rpc\Status|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function hasStatus()
    {
        return isset($this->status);
    }

    public function clearStatus()
    {
        unset($this->status);
    }

    /**
     * Output only. The response from the target for the last attempted execution.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Rpc\Status $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkMessage($var, \Google\Rpc\Status::class);
        $this->status = $var;

        return $this;
    }

    /**
     * Output only. The next time the job is scheduled. Note that this may be a
     * retry of a previously failed attempt or the next execution time
     * according to the schedule.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp schedule_time = 17 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getScheduleTime()
    {
        return $this->schedule_time;
    }

    public function hasScheduleTime()
    {
        return isset($this->schedule_time);
    }

    public function clearScheduleTime()
    {
        unset($this->schedule_time);
    }

    /**
     * Output only. The next time the job is scheduled. Note that this may be a
     * retry of a previously failed attempt or the next execution time
     * according to the schedule.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp schedule_time = 17 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setScheduleTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->schedule_time = $var;

        return $this;
    }

    /**
     * Output only. The time the last job attempt started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp last_attempt_time = 18 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getLastAttemptTime()
    {
        return $this->last_attempt_time;
    }

    public function hasLastAttemptTime()
    {
        return isset($this->last_attempt_time);
    }

    public function clearLastAttemptTime()
    {
        unset($this->last_attempt_time);
    }

    /**
     * Output only. The time the last job attempt started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp last_attempt_time = 18 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setLastAttemptTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->last_attempt_time = $var;

        return $this;
    }

    /**
     * Settings that determine the retry behavior.
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.RetryConfig retry_config = 19;</code>
     * @return \Google\Cloud\Scheduler\V1\RetryConfig|null
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
     *
     * Generated from protobuf field <code>.google.cloud.scheduler.v1.RetryConfig retry_config = 19;</code>
     * @param \Google\Cloud\Scheduler\V1\RetryConfig $var
     * @return $this
     */
    public function setRetryConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Scheduler\V1\RetryConfig::class);
        $this->retry_config = $var;

        return $this;
    }

    /**
     * The deadline for job attempts. If the request handler does not respond by
     * this deadline then the request is cancelled and the attempt is marked as a
     * `DEADLINE_EXCEEDED` failure. The failed attempt can be viewed in
     * execution logs. Cloud Scheduler will retry the job according
     * to the [RetryConfig][google.cloud.scheduler.v1.RetryConfig].
     * The default and the allowed values depend on the type of target:
     * * For [HTTP targets][google.cloud.scheduler.v1.Job.http_target], the
     * default is 3 minutes. The deadline must be in the interval [15 seconds, 30
     * minutes].
     * * For [App Engine HTTP
     * targets][google.cloud.scheduler.v1.Job.app_engine_http_target], 0 indicates
     * that the request has the default deadline. The default deadline depends on
     * the scaling type of the service: 10 minutes for standard apps with
     * automatic scaling, 24 hours for standard apps with manual and basic
     * scaling, and 60 minutes for flex apps. If the request deadline is set, it
     * must be in the interval [15 seconds, 24 hours 15 seconds].
     * * For [Pub/Sub targets][google.cloud.scheduler.v1.Job.pubsub_target], this
     * field is ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration attempt_deadline = 22;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getAttemptDeadline()
    {
        return $this->attempt_deadline;
    }

    public function hasAttemptDeadline()
    {
        return isset($this->attempt_deadline);
    }

    public function clearAttemptDeadline()
    {
        unset($this->attempt_deadline);
    }

    /**
     * The deadline for job attempts. If the request handler does not respond by
     * this deadline then the request is cancelled and the attempt is marked as a
     * `DEADLINE_EXCEEDED` failure. The failed attempt can be viewed in
     * execution logs. Cloud Scheduler will retry the job according
     * to the [RetryConfig][google.cloud.scheduler.v1.RetryConfig].
     * The default and the allowed values depend on the type of target:
     * * For [HTTP targets][google.cloud.scheduler.v1.Job.http_target], the
     * default is 3 minutes. The deadline must be in the interval [15 seconds, 30
     * minutes].
     * * For [App Engine HTTP
     * targets][google.cloud.scheduler.v1.Job.app_engine_http_target], 0 indicates
     * that the request has the default deadline. The default deadline depends on
     * the scaling type of the service: 10 minutes for standard apps with
     * automatic scaling, 24 hours for standard apps with manual and basic
     * scaling, and 60 minutes for flex apps. If the request deadline is set, it
     * must be in the interval [15 seconds, 24 hours 15 seconds].
     * * For [Pub/Sub targets][google.cloud.scheduler.v1.Job.pubsub_target], this
     * field is ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration attempt_deadline = 22;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setAttemptDeadline($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->attempt_deadline = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->whichOneof("target");
    }

}

