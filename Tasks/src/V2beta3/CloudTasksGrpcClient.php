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
namespace Google\Cloud\Tasks\V2beta3;

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
     * @param \Google\Cloud\Tasks\V2beta3\ListQueuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListQueues(\Google\Cloud\Tasks\V2beta3\ListQueuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/ListQueues',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\ListQueuesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a queue.
     * @param \Google\Cloud\Tasks\V2beta3\GetQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetQueue(\Google\Cloud\Tasks\V2beta3\GetQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/GetQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
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
     * @param \Google\Cloud\Tasks\V2beta3\CreateQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateQueue(\Google\Cloud\Tasks\V2beta3\CreateQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/CreateQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
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
     * @param \Google\Cloud\Tasks\V2beta3\UpdateQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateQueue(\Google\Cloud\Tasks\V2beta3\UpdateQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/UpdateQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
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
     * @param \Google\Cloud\Tasks\V2beta3\DeleteQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteQueue(\Google\Cloud\Tasks\V2beta3\DeleteQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/DeleteQueue',
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
     * @param \Google\Cloud\Tasks\V2beta3\PurgeQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeQueue(\Google\Cloud\Tasks\V2beta3\PurgeQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/PurgeQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses the queue.
     *
     * If a queue is paused then the system will stop dispatching tasks
     * until the queue is resumed via
     * [ResumeQueue][google.cloud.tasks.v2beta3.CloudTasks.ResumeQueue]. Tasks can still be added
     * when the queue is paused. A queue is paused if its
     * [state][google.cloud.tasks.v2beta3.Queue.state] is [PAUSED][google.cloud.tasks.v2beta3.Queue.State.PAUSED].
     * @param \Google\Cloud\Tasks\V2beta3\PauseQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseQueue(\Google\Cloud\Tasks\V2beta3\PauseQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/PauseQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Resume a queue.
     *
     * This method resumes a queue after it has been
     * [PAUSED][google.cloud.tasks.v2beta3.Queue.State.PAUSED] or
     * [DISABLED][google.cloud.tasks.v2beta3.Queue.State.DISABLED]. The state of a queue is stored
     * in the queue's [state][google.cloud.tasks.v2beta3.Queue.state]; after calling this method it
     * will be set to [RUNNING][google.cloud.tasks.v2beta3.Queue.State.RUNNING].
     *
     * WARNING: Resuming many high-QPS queues at the same time can
     * lead to target overloading. If you are resuming high-QPS
     * queues, follow the 500/50/5 pattern described in
     * [Managing Cloud Tasks Scaling
     * Risks](https://cloud.google.com/tasks/docs/manage-cloud-task-scaling).
     * @param \Google\Cloud\Tasks\V2beta3\ResumeQueueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeQueue(\Google\Cloud\Tasks\V2beta3\ResumeQueueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/ResumeQueue',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Queue', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a [Queue][google.cloud.tasks.v2beta3.Queue].
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
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy for a [Queue][google.cloud.tasks.v2beta3.Queue]. Replaces any existing
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
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on a [Queue][google.cloud.tasks.v2beta3.Queue].
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
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the tasks in a queue.
     *
     * By default, only the [BASIC][google.cloud.tasks.v2beta3.Task.View.BASIC] view is retrieved
     * due to performance considerations;
     * [response_view][google.cloud.tasks.v2beta3.ListTasksRequest.response_view] controls the
     * subset of information which is returned.
     *
     * The tasks may be returned in any order. The ordering may change at any
     * time.
     * @param \Google\Cloud\Tasks\V2beta3\ListTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTasks(\Google\Cloud\Tasks\V2beta3\ListTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/ListTasks',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\ListTasksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a task.
     * @param \Google\Cloud\Tasks\V2beta3\GetTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTask(\Google\Cloud\Tasks\V2beta3\GetTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/GetTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a task and adds it to a queue.
     *
     * Tasks cannot be updated after creation; there is no UpdateTask command.
     *
     * * The maximum task size is 100KB.
     * @param \Google\Cloud\Tasks\V2beta3\CreateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTask(\Google\Cloud\Tasks\V2beta3\CreateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/CreateTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a task.
     *
     * A task can be deleted if it is scheduled or dispatched. A task
     * cannot be deleted if it has executed successfully or permanently
     * failed.
     * @param \Google\Cloud\Tasks\V2beta3\DeleteTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTask(\Google\Cloud\Tasks\V2beta3\DeleteTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/DeleteTask',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Forces a task to run now.
     *
     * When this method is called, Cloud Tasks will dispatch the task, even if
     * the task is already running, the queue has reached its [RateLimits][google.cloud.tasks.v2beta3.RateLimits] or
     * is [PAUSED][google.cloud.tasks.v2beta3.Queue.State.PAUSED].
     *
     * This command is meant to be used for manual debugging. For
     * example, [RunTask][google.cloud.tasks.v2beta3.CloudTasks.RunTask] can be used to retry a failed
     * task after a fix has been made or to manually force a task to be
     * dispatched now.
     *
     * The dispatched task is returned. That is, the task that is returned
     * contains the [status][Task.status] after the task is dispatched but
     * before the task is received by its target.
     *
     * If Cloud Tasks receives a successful response from the task's
     * target, then the task will be deleted; otherwise the task's
     * [schedule_time][google.cloud.tasks.v2beta3.Task.schedule_time] will be reset to the time that
     * [RunTask][google.cloud.tasks.v2beta3.CloudTasks.RunTask] was called plus the retry delay specified
     * in the queue's [RetryConfig][google.cloud.tasks.v2beta3.RetryConfig].
     *
     * [RunTask][google.cloud.tasks.v2beta3.CloudTasks.RunTask] returns
     * [NOT_FOUND][google.rpc.Code.NOT_FOUND] when it is called on a
     * task that has already succeeded or permanently failed.
     * @param \Google\Cloud\Tasks\V2beta3\RunTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunTask(\Google\Cloud\Tasks\V2beta3\RunTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tasks.v2beta3.CloudTasks/RunTask',
        $argument,
        ['\Google\Cloud\Tasks\V2beta3\Task', 'decode'],
        $metadata, $options);
    }

}
