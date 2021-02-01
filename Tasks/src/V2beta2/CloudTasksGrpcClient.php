<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Tasks\V2beta2;

/**
 * Cloud Tasks allows developers to manage the execution of background
 * work in their applications.
 */
class CloudTasksGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists queues.
     *
     * Queues are returned in lexicographical order.
     * @param \Google\Cloud\Tasks\V2beta2\ListQueuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListQueues(\Google\Cloud\Tasks\V2beta2\ListQueuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/ListQueues',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\ListQueuesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a queue.
     * @param \Google\Cloud\Tasks\V2beta2\GetQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetQueue(\Google\Cloud\Tasks\V2beta2\GetQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/GetQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a queue.
     *
     * Queues created with this method allow tasks to live for a maximum of 31
     * days. After a task is 31 days old, the task will be deleted regardless of whether
     * it was dispatched or not.
     *
     * WARNING: Using this method may have unintended side effects if you are
     * using an App Engine `queue.yaml` or `queue.xml` file to manage your queues.
     * Read
     * [Overview of Queue Management and
     * queue.yaml](https://cloud.google.com/tasks/docs/queue-yaml) before using
     * this method.
     * @param \Google\Cloud\Tasks\V2beta2\CreateQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateQueue(\Google\Cloud\Tasks\V2beta2\CreateQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/CreateQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a queue.
     *
     * This method creates the queue if it does not exist and updates
     * the queue if it does exist.
     *
     * Queues created with this method allow tasks to live for a maximum of 31
     * days. After a task is 31 days old, the task will be deleted regardless of whether
     * it was dispatched or not.
     *
     * WARNING: Using this method may have unintended side effects if you are
     * using an App Engine `queue.yaml` or `queue.xml` file to manage your queues.
     * Read
     * [Overview of Queue Management and
     * queue.yaml](https://cloud.google.com/tasks/docs/queue-yaml) before using
     * this method.
     * @param \Google\Cloud\Tasks\V2beta2\UpdateQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateQueue(\Google\Cloud\Tasks\V2beta2\UpdateQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/UpdateQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a queue.
     *
     * This command will delete the queue even if it has tasks in it.
     *
     * Note: If you delete a queue, a queue with the same name can't be created
     * for 7 days.
     *
     * WARNING: Using this method may have unintended side effects if you are
     * using an App Engine `queue.yaml` or `queue.xml` file to manage your queues.
     * Read
     * [Overview of Queue Management and
     * queue.yaml](https://cloud.google.com/tasks/docs/queue-yaml) before using
     * this method.
     * @param \Google\Cloud\Tasks\V2beta2\DeleteQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteQueue(\Google\Cloud\Tasks\V2beta2\DeleteQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/DeleteQueue',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Purges a queue by deleting all of its tasks.
     *
     * All tasks created before this method is called are permanently deleted.
     *
     * Purge operations can take up to one minute to take effect. Tasks
     * might be dispatched before the purge takes effect. A purge is irreversible.
     * @param \Google\Cloud\Tasks\V2beta2\PurgeQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeQueue(\Google\Cloud\Tasks\V2beta2\PurgeQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/PurgeQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses the queue.
     *
     * If a queue is paused then the system will stop dispatching tasks
     * until the queue is resumed via
     * [ResumeQueue][google.cloud.tasks.v2beta2.CloudTasks.ResumeQueue]. Tasks can still be added
     * when the queue is paused. A queue is paused if its
     * [state][google.cloud.tasks.v2beta2.Queue.state] is [PAUSED][google.cloud.tasks.v2beta2.Queue.State.PAUSED].
     * @param \Google\Cloud\Tasks\V2beta2\PauseQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseQueue(\Google\Cloud\Tasks\V2beta2\PauseQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/PauseQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Resume a queue.
     *
     * This method resumes a queue after it has been
     * [PAUSED][google.cloud.tasks.v2beta2.Queue.State.PAUSED] or
     * [DISABLED][google.cloud.tasks.v2beta2.Queue.State.DISABLED]. The state of a queue is stored
     * in the queue's [state][google.cloud.tasks.v2beta2.Queue.state]; after calling this method it
     * will be set to [RUNNING][google.cloud.tasks.v2beta2.Queue.State.RUNNING].
     *
     * WARNING: Resuming many high-QPS queues at the same time can
     * lead to target overloading. If you are resuming high-QPS
     * queues, follow the 500/50/5 pattern described in
     * [Managing Cloud Tasks Scaling
     * Risks](https://cloud.google.com/tasks/docs/manage-cloud-task-scaling).
     * @param \Google\Cloud\Tasks\V2beta2\ResumeQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeQueue(\Google\Cloud\Tasks\V2beta2\ResumeQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/ResumeQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a [Queue][google.cloud.tasks.v2beta2.Queue].
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     *
     * Authorization requires the following
     * [Google IAM](https://cloud.google.com/iam) permission on the specified
     * resource parent:
     *
     * * `cloudtasks.queues.getIamPolicy`
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy for a [Queue][google.cloud.tasks.v2beta2.Queue]. Replaces any existing
     * policy.
     *
     * Note: The Cloud Console does not check queue-level IAM permissions yet.
     * Project-level permissions are required to use the Cloud Console.
     *
     * Authorization requires the following
     * [Google IAM](https://cloud.google.com/iam) permission on the specified
     * resource parent:
     *
     * * `cloudtasks.queues.setIamPolicy`
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on a [Queue][google.cloud.tasks.v2beta2.Queue].
     * If the resource does not exist, this will return an empty set of
     * permissions, not a [NOT_FOUND][google.rpc.Code.NOT_FOUND] error.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the tasks in a queue.
     *
     * By default, only the [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC] view is retrieved
     * due to performance considerations;
     * [response_view][google.cloud.tasks.v2beta2.ListTasksRequest.response_view] controls the
     * subset of information which is returned.
     *
     * The tasks may be returned in any order. The ordering may change at any
     * time.
     * @param \Google\Cloud\Tasks\V2beta2\ListTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTasks(\Google\Cloud\Tasks\V2beta2\ListTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/ListTasks',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\ListTasksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a task.
     * @param \Google\Cloud\Tasks\V2beta2\GetTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTask(\Google\Cloud\Tasks\V2beta2\GetTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/GetTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a task and adds it to a queue.
     *
     * Tasks cannot be updated after creation; there is no UpdateTask command.
     *
     * * For [App Engine queues][google.cloud.tasks.v2beta2.AppEngineHttpTarget], the maximum task size is
     *   100KB.
     * * For [pull queues][google.cloud.tasks.v2beta2.PullTarget], the maximum task size is 1MB.
     * @param \Google\Cloud\Tasks\V2beta2\CreateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTask(\Google\Cloud\Tasks\V2beta2\CreateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/CreateTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a task.
     *
     * A task can be deleted if it is scheduled or dispatched. A task
     * cannot be deleted if it has completed successfully or permanently
     * failed.
     * @param \Google\Cloud\Tasks\V2beta2\DeleteTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTask(\Google\Cloud\Tasks\V2beta2\DeleteTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/DeleteTask',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Leases tasks from a pull queue for
     * [lease_duration][google.cloud.tasks.v2beta2.LeaseTasksRequest.lease_duration].
     *
     * This method is invoked by the worker to obtain a lease. The
     * worker must acknowledge the task via
     * [AcknowledgeTask][google.cloud.tasks.v2beta2.CloudTasks.AcknowledgeTask] after they have
     * performed the work associated with the task.
     *
     * The [payload][google.cloud.tasks.v2beta2.PullMessage.payload] is intended to store data that
     * the worker needs to perform the work associated with the task. To
     * return the payloads in the [response][google.cloud.tasks.v2beta2.LeaseTasksResponse], set
     * [response_view][google.cloud.tasks.v2beta2.LeaseTasksRequest.response_view] to
     * [FULL][google.cloud.tasks.v2beta2.Task.View.FULL].
     *
     * A maximum of 10 qps of [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks]
     * requests are allowed per
     * queue. [RESOURCE_EXHAUSTED][google.rpc.Code.RESOURCE_EXHAUSTED]
     * is returned when this limit is
     * exceeded. [RESOURCE_EXHAUSTED][google.rpc.Code.RESOURCE_EXHAUSTED]
     * is also returned when
     * [max_tasks_dispatched_per_second][google.cloud.tasks.v2beta2.RateLimits.max_tasks_dispatched_per_second]
     * is exceeded.
     * @param \Google\Cloud\Tasks\V2beta2\LeaseTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LeaseTasks(\Google\Cloud\Tasks\V2beta2\LeaseTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/LeaseTasks',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\LeaseTasksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Acknowledges a pull task.
     *
     * The worker, that is, the entity that
     * [leased][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] this task must call this method
     * to indicate that the work associated with the task has finished.
     *
     * The worker must acknowledge a task within the
     * [lease_duration][google.cloud.tasks.v2beta2.LeaseTasksRequest.lease_duration] or the lease
     * will expire and the task will become available to be leased
     * again. After the task is acknowledged, it will not be returned
     * by a later [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks],
     * [GetTask][google.cloud.tasks.v2beta2.CloudTasks.GetTask], or
     * [ListTasks][google.cloud.tasks.v2beta2.CloudTasks.ListTasks].
     * @param \Google\Cloud\Tasks\V2beta2\AcknowledgeTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AcknowledgeTask(\Google\Cloud\Tasks\V2beta2\AcknowledgeTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/AcknowledgeTask',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Renew the current lease of a pull task.
     *
     * The worker can use this method to extend the lease by a new
     * duration, starting from now. The new task lease will be
     * returned in the task's [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time].
     * @param \Google\Cloud\Tasks\V2beta2\RenewLeaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RenewLease(\Google\Cloud\Tasks\V2beta2\RenewLeaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/RenewLease',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancel a pull task's lease.
     *
     * The worker can use this method to cancel a task's lease by
     * setting its [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] to now. This will
     * make the task available to be leased to the next caller of
     * [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks].
     * @param \Google\Cloud\Tasks\V2beta2\CancelLeaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelLease(\Google\Cloud\Tasks\V2beta2\CancelLeaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/CancelLease',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Forces a task to run now.
     *
     * When this method is called, Cloud Tasks will dispatch the task, even if
     * the task is already running, the queue has reached its [RateLimits][google.cloud.tasks.v2beta2.RateLimits] or
     * is [PAUSED][google.cloud.tasks.v2beta2.Queue.State.PAUSED].
     *
     * This command is meant to be used for manual debugging. For
     * example, [RunTask][google.cloud.tasks.v2beta2.CloudTasks.RunTask] can be used to retry a failed
     * task after a fix has been made or to manually force a task to be
     * dispatched now.
     *
     * The dispatched task is returned. That is, the task that is returned
     * contains the [status][google.cloud.tasks.v2beta2.Task.status] after the task is dispatched but
     * before the task is received by its target.
     *
     * If Cloud Tasks receives a successful response from the task's
     * target, then the task will be deleted; otherwise the task's
     * [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] will be reset to the time that
     * [RunTask][google.cloud.tasks.v2beta2.CloudTasks.RunTask] was called plus the retry delay specified
     * in the queue's [RetryConfig][google.cloud.tasks.v2beta2.RetryConfig].
     *
     * [RunTask][google.cloud.tasks.v2beta2.CloudTasks.RunTask] returns
     * [NOT_FOUND][google.rpc.Code.NOT_FOUND] when it is called on a
     * task that has already succeeded or permanently failed.
     *
     * [RunTask][google.cloud.tasks.v2beta2.CloudTasks.RunTask] cannot be called on a
     * [pull task][google.cloud.tasks.v2beta2.PullMessage].
     * @param \Google\Cloud\Tasks\V2beta2\RunTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunTask(\Google\Cloud\Tasks\V2beta2\RunTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta2.CloudTasks/RunTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta2\Task', 'decode'],
        $metadata, $options);
    }

}
