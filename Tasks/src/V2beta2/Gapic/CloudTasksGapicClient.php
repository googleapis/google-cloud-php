<?php
/*
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/tasks/v2beta2/cloudtasks.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Tasks\V2beta2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Tasks\V2beta2\AcknowledgeTaskRequest;
use Google\Cloud\Tasks\V2beta2\CancelLeaseRequest;
use Google\Cloud\Tasks\V2beta2\CreateQueueRequest;
use Google\Cloud\Tasks\V2beta2\CreateTaskRequest;
use Google\Cloud\Tasks\V2beta2\DeleteQueueRequest;
use Google\Cloud\Tasks\V2beta2\DeleteTaskRequest;
use Google\Cloud\Tasks\V2beta2\GetQueueRequest;
use Google\Cloud\Tasks\V2beta2\GetTaskRequest;
use Google\Cloud\Tasks\V2beta2\LeaseTasksRequest;
use Google\Cloud\Tasks\V2beta2\LeaseTasksResponse;
use Google\Cloud\Tasks\V2beta2\ListQueuesRequest;
use Google\Cloud\Tasks\V2beta2\ListQueuesResponse;
use Google\Cloud\Tasks\V2beta2\ListTasksRequest;
use Google\Cloud\Tasks\V2beta2\ListTasksResponse;
use Google\Cloud\Tasks\V2beta2\PauseQueueRequest;
use Google\Cloud\Tasks\V2beta2\PurgeQueueRequest;
use Google\Cloud\Tasks\V2beta2\Queue;
use Google\Cloud\Tasks\V2beta2\RenewLeaseRequest;
use Google\Cloud\Tasks\V2beta2\ResumeQueueRequest;
use Google\Cloud\Tasks\V2beta2\RunTaskRequest;
use Google\Cloud\Tasks\V2beta2\Task;
use Google\Cloud\Tasks\V2beta2\Task\View;
use Google\Cloud\Tasks\V2beta2\UpdateQueueRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;

/**
 * Service Description: Cloud Tasks allows developers to manage the execution of background
 * work in their applications.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $cloudTasksClient = new CloudTasksClient();
 * try {
 *     $response = $cloudTasksClient->listQueues();
 * } finally {
 *     $cloudTasksClient->close();
 * }
 * ```
 *
 * @experimental
 */
class CloudTasksGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.tasks.v2beta2.CloudTasks';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'cloudtasks.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/cloud_tasks_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/cloud_tasks_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/cloud_tasks_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/cloud_tasks_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'cloudtasks.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Lists queues.
     *
     * Queues are returned in lexicographical order.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->listQueues();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The location name.
     *          For example: `projects/PROJECT_ID/locations/LOCATION_ID`
     *     @type string $filter
     *          `filter` can be used to specify a subset of queues. Any [Queue][google.cloud.tasks.v2beta2.Queue]
     *          field can be used as a filter and several operators as supported.
     *          For example: `<=, <, >=, >, !=, =, :`. The filter syntax is the same as
     *          described in
     *          [Stackdriver's Advanced Logs
     *          Filters](https://cloud.google.com/logging/docs/view/advanced_filters).
     *
     *          Sample filter "app_engine_http_target: *".
     *
     *          Note that using filters might cause fewer queues than the
     *          requested_page size to be returned.
     *     @type int $pageSize
     *          Requested page size.
     *
     *          The maximum page size is 9800. If unspecified, the page size will
     *          be the maximum. Fewer queues than requested might be returned,
     *          even if more queues exist; use the
     *          [next_page_token][google.cloud.tasks.v2beta2.ListQueuesResponse.next_page_token] in the
     *          response to determine if more queues exist.
     *     @type string $pageToken
     *          A token identifying the page of results to return.
     *
     *          To request the first page results, page_token must be empty. To
     *          request the next page of results, page_token must be the value of
     *          [next_page_token][google.cloud.tasks.v2beta2.ListQueuesResponse.next_page_token] returned
     *          from the previous call to [ListQueues][google.cloud.tasks.v2beta2.CloudTasks.ListQueues]
     *          method. It is an error to switch the value of the
     *          [filter][google.cloud.tasks.v2beta2.ListQueuesRequest.filter] while iterating through pages.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\ListQueuesResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listQueues(array $optionalArgs = [])
    {
        $request = new ListQueuesRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListQueues',
            ListQueuesResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a queue.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->getQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The resource name of the queue. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getQueue(array $optionalArgs = [])
    {
        $request = new GetQueueRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->createQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The location name in which the queue will be created.
     *          For example: `projects/PROJECT_ID/locations/LOCATION_ID`
     *
     *          The list of allowed locations can be obtained by calling Cloud
     *          Tasks' implementation of
     *          [ListLocations][google.cloud.location.Locations.ListLocations].
     *     @type Queue $queue
     *          Required. The queue to create.
     *
     *          [Queue's name][google.cloud.tasks.v2beta2.Queue.name] cannot be the same as an existing queue.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createQueue(array $optionalArgs = [])
    {
        $request = new CreateQueueRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['queue'])) {
            $request->setQueue($optionalArgs['queue']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->updateQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type Queue $queue
     *          Required. The queue to create or update.
     *
     *          The queue's [name][google.cloud.tasks.v2beta2.Queue.name] must be specified.
     *
     *          Output only fields cannot be modified using UpdateQueue.
     *          Any value specified for an output only field will be ignored.
     *          The queue's [name][google.cloud.tasks.v2beta2.Queue.name] cannot be changed.
     *     @type FieldMask $updateMask
     *          A mask used to specify which fields of the queue are being updated.
     *
     *          If empty, then all fields will be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateQueue(array $optionalArgs = [])
    {
        $request = new UpdateQueueRequest();
        if (isset($optionalArgs['queue'])) {
            $request->setQueue($optionalArgs['queue']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'queue.name' => $request->getQueue()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $cloudTasksClient->deleteQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteQueue(array $optionalArgs = [])
    {
        $request = new DeleteQueueRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteQueue',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Purges a queue by deleting all of its tasks.
     *
     * All tasks created before this method is called are permanently deleted.
     *
     * Purge operations can take up to one minute to take effect. Tasks
     * might be dispatched before the purge takes effect. A purge is irreversible.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->purgeQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function purgeQueue(array $optionalArgs = [])
    {
        $request = new PurgeQueueRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'PurgeQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Pauses the queue.
     *
     * If a queue is paused then the system will stop dispatching tasks
     * until the queue is resumed via
     * [ResumeQueue][google.cloud.tasks.v2beta2.CloudTasks.ResumeQueue]. Tasks can still be added
     * when the queue is paused. A queue is paused if its
     * [state][google.cloud.tasks.v2beta2.Queue.state] is [PAUSED][google.cloud.tasks.v2beta2.Queue.State.PAUSED].
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->pauseQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function pauseQueue(array $optionalArgs = [])
    {
        $request = new PauseQueueRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'PauseQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->resumeQueue();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Queue
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function resumeQueue(array $optionalArgs = [])
    {
        $request = new ResumeQueueRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ResumeQueue',
            Queue::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->getIamPolicy();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $resource
     *          REQUIRED: The resource for which the policy is being requested.
     *          See the operation documentation for the appropriate value for this field.
     *     @type GetPolicyOptions $options
     *          OPTIONAL: A `GetPolicyOptions` object for specifying options to
     *          `GetIamPolicy`. This field is only used by Cloud IAM.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy(array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        if (isset($optionalArgs['resource'])) {
            $request->setResource($optionalArgs['resource']);
        }
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->setIamPolicy();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $resource
     *          REQUIRED: The resource for which the policy is being specified.
     *          See the operation documentation for the appropriate value for this field.
     *     @type Policy $policy
     *          REQUIRED: The complete policy to be applied to the `resource`. The size of
     *          the policy is limited to a few 10s of KB. An empty policy is a
     *          valid policy but certain Cloud Platform services (such as Projects)
     *          might reject them.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy(array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        if (isset($optionalArgs['resource'])) {
            $request->setResource($optionalArgs['resource']);
        }
        if (isset($optionalArgs['policy'])) {
            $request->setPolicy($optionalArgs['policy']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns permissions that a caller has on a [Queue][google.cloud.tasks.v2beta2.Queue].
     * If the resource does not exist, this will return an empty set of
     * permissions, not a [NOT_FOUND][google.rpc.Code.NOT_FOUND] error.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->testIamPermissions();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $resource
     *          REQUIRED: The resource for which the policy detail is being requested.
     *          See the operation documentation for the appropriate value for this field.
     *     @type string[] $permissions
     *          The set of permissions to check for the `resource`. Permissions with
     *          wildcards (such as '*' or 'storage.*') are not allowed. For more
     *          information see
     *          [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions(array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        if (isset($optionalArgs['resource'])) {
            $request->setResource($optionalArgs['resource']);
        }
        if (isset($optionalArgs['permissions'])) {
            $request->setPermissions($optionalArgs['permissions']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->listTasks();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type int $pageSize
     *          Maximum page size.
     *
     *          Fewer tasks than requested might be returned, even if more tasks exist; use
     *          [next_page_token][google.cloud.tasks.v2beta2.ListTasksResponse.next_page_token] in the response to
     *          determine if more tasks exist.
     *
     *          The maximum page size is 1000. If unspecified, the page size will be the
     *          maximum.
     *     @type string $pageToken
     *          A token identifying the page of results to return.
     *
     *          To request the first page results, page_token must be empty. To
     *          request the next page of results, page_token must be the value of
     *          [next_page_token][google.cloud.tasks.v2beta2.ListTasksResponse.next_page_token] returned
     *          from the previous call to [ListTasks][google.cloud.tasks.v2beta2.CloudTasks.ListTasks]
     *          method.
     *
     *          The page token is valid for only 2 hours.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\ListTasksResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listTasks(array $optionalArgs = [])
    {
        $request = new ListTasksRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListTasks',
            ListTasksResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a task.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->getTask();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Task
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getTask(array $optionalArgs = [])
    {
        $request = new GetTaskRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetTask',
            Task::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a task and adds it to a queue.
     *
     * Tasks cannot be updated after creation; there is no UpdateTask command.
     *
     * * For [App Engine queues][google.cloud.tasks.v2beta2.AppEngineHttpTarget], the maximum task size is
     *   100KB.
     * * For [pull queues][google.cloud.tasks.v2beta2.PullTarget], the maximum task size is 1MB.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->createTask();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *
     *          The queue must already exist.
     *     @type Task $task
     *          Required. The task to add.
     *
     *          Task names have the following format:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`.
     *          The user can optionally specify a task [name][google.cloud.tasks.v2beta2.Task.name]. If a
     *          name is not specified then the system will generate a random
     *          unique task id, which will be set in the task returned in the
     *          [response][google.cloud.tasks.v2beta2.Task.name].
     *
     *          If [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] is not set or is in the
     *          past then Cloud Tasks will set it to the current time.
     *
     *          Task De-duplication:
     *
     *          Explicitly specifying a task ID enables task de-duplication.  If
     *          a task's ID is identical to that of an existing task or a task
     *          that was deleted or completed recently then the call will fail
     *          with [ALREADY_EXISTS][google.rpc.Code.ALREADY_EXISTS].
     *          If the task's queue was created using Cloud Tasks, then another task with
     *          the same name can't be created for ~1hour after the original task was
     *          deleted or completed. If the task's queue was created using queue.yaml or
     *          queue.xml, then another task with the same name can't be created
     *          for ~9days after the original task was deleted or completed.
     *
     *          Because there is an extra lookup cost to identify duplicate task
     *          names, these [CreateTask][google.cloud.tasks.v2beta2.CloudTasks.CreateTask] calls have significantly
     *          increased latency. Using hashed strings for the task id or for
     *          the prefix of the task id is recommended. Choosing task ids that
     *          are sequential or have sequential prefixes, for example using a
     *          timestamp, causes an increase in latency and error rates in all
     *          task commands. The infrastructure relies on an approximately
     *          uniform distribution of task ids to store and serve tasks
     *          efficiently.
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Task
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createTask(array $optionalArgs = [])
    {
        $request = new CreateTaskRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['task'])) {
            $request->setTask($optionalArgs['task']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTask',
            Task::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a task.
     *
     * A task can be deleted if it is scheduled or dispatched. A task
     * cannot be deleted if it has completed successfully or permanently
     * failed.
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $cloudTasksClient->deleteTask();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteTask(array $optionalArgs = [])
    {
        $request = new DeleteTaskRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTask',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->leaseTasks();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The queue name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
     *     @type int $maxTasks
     *          The maximum number of tasks to lease.
     *
     *          The system will make a best effort to return as close to as
     *          `max_tasks` as possible.
     *
     *          The largest that `max_tasks` can be is 1000.
     *
     *          The maximum total size of a [lease tasks response][google.cloud.tasks.v2beta2.LeaseTasksResponse] is
     *          32 MB. If the sum of all task sizes requested reaches this limit,
     *          fewer tasks than requested are returned.
     *     @type Duration $leaseDuration
     *          Required. The duration of the lease.
     *
     *          Each task returned in the [response][google.cloud.tasks.v2beta2.LeaseTasksResponse] will
     *          have its [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] set to the current
     *          time plus the `lease_duration`. The task is leased until its
     *          [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time]; thus, the task will not be
     *          returned to another [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] call
     *          before its [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time].
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type string $filter
     *          `filter` can be used to specify a subset of tasks to lease.
     *
     *          When `filter` is set to `tag=<my-tag>` then the
     *          [response][google.cloud.tasks.v2beta2.LeaseTasksResponse] will contain only tasks whose
     *          [tag][google.cloud.tasks.v2beta2.PullMessage.tag] is equal to `<my-tag>`. `<my-tag>` must be
     *          less than 500 characters.
     *
     *          When `filter` is set to `tag_function=oldest_tag()`, only tasks which have
     *          the same tag as the task with the oldest
     *          [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] will be returned.
     *
     *          Grammar Syntax:
     *
     *          * `filter = "tag=" tag | "tag_function=" function`
     *
     *          * `tag = string`
     *
     *          * `function = "oldest_tag()"`
     *
     *          The `oldest_tag()` function returns tasks which have the same tag as the
     *          oldest task (ordered by schedule time).
     *
     *          SDK compatibility: Although the SDK allows tags to be either
     *          string or
     *          [bytes](https://cloud.google.com/appengine/docs/standard/java/javadoc/com/google/appengine/api/taskqueue/TaskOptions.html#tag-byte:A-),
     *          only UTF-8 encoded tags can be used in Cloud Tasks. Tag which
     *          aren't UTF-8 encoded can't be used in the
     *          [filter][google.cloud.tasks.v2beta2.LeaseTasksRequest.filter] and the task's
     *          [tag][google.cloud.tasks.v2beta2.PullMessage.tag] will be displayed as empty in Cloud Tasks.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\LeaseTasksResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function leaseTasks(array $optionalArgs = [])
    {
        $request = new LeaseTasksRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['maxTasks'])) {
            $request->setMaxTasks($optionalArgs['maxTasks']);
        }
        if (isset($optionalArgs['leaseDuration'])) {
            $request->setLeaseDuration($optionalArgs['leaseDuration']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'LeaseTasks',
            LeaseTasksResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $cloudTasksClient->acknowledgeTask();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type Timestamp $scheduleTime
     *          Required. The task's current schedule time, available in the
     *          [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] returned by
     *          [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] response or
     *          [RenewLease][google.cloud.tasks.v2beta2.CloudTasks.RenewLease] response. This restriction is
     *          to ensure that your worker currently holds the lease.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function acknowledgeTask(array $optionalArgs = [])
    {
        $request = new AcknowledgeTaskRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['scheduleTime'])) {
            $request->setScheduleTime($optionalArgs['scheduleTime']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'AcknowledgeTask',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Renew the current lease of a pull task.
     *
     * The worker can use this method to extend the lease by a new
     * duration, starting from now. The new task lease will be
     * returned in the task's [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time].
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->renewLease();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type Timestamp $scheduleTime
     *          Required. The task's current schedule time, available in the
     *          [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] returned by
     *          [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] response or
     *          [RenewLease][google.cloud.tasks.v2beta2.CloudTasks.RenewLease] response. This restriction is
     *          to ensure that your worker currently holds the lease.
     *     @type Duration $leaseDuration
     *          Required. The desired new lease duration, starting from now.
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Task
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function renewLease(array $optionalArgs = [])
    {
        $request = new RenewLeaseRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['scheduleTime'])) {
            $request->setScheduleTime($optionalArgs['scheduleTime']);
        }
        if (isset($optionalArgs['leaseDuration'])) {
            $request->setLeaseDuration($optionalArgs['leaseDuration']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RenewLease',
            Task::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Cancel a pull task's lease.
     *
     * The worker can use this method to cancel a task's lease by
     * setting its [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] to now. This will
     * make the task available to be leased to the next caller of
     * [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks].
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->cancelLease();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type Timestamp $scheduleTime
     *          Required. The task's current schedule time, available in the
     *          [schedule_time][google.cloud.tasks.v2beta2.Task.schedule_time] returned by
     *          [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] response or
     *          [RenewLease][google.cloud.tasks.v2beta2.CloudTasks.RenewLease] response. This restriction is
     *          to ensure that your worker currently holds the lease.
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Task
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function cancelLease(array $optionalArgs = [])
    {
        $request = new CancelLeaseRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['scheduleTime'])) {
            $request->setScheduleTime($optionalArgs['scheduleTime']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CancelLease',
            Task::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudTasksClient = new CloudTasksClient();
     * try {
     *     $response = $cloudTasksClient->runTask();
     * } finally {
     *     $cloudTasksClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. The task name. For example:
     *          `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
     *     @type int $responseView
     *          The response_view specifies which subset of the [Task][google.cloud.tasks.v2beta2.Task] will be
     *          returned.
     *
     *          By default response_view is [BASIC][google.cloud.tasks.v2beta2.Task.View.BASIC]; not all
     *          information is retrieved by default because some data, such as
     *          payloads, might be desirable to return only when needed because
     *          of its large size or because of the sensitivity of data that it
     *          contains.
     *
     *          Authorization for [FULL][google.cloud.tasks.v2beta2.Task.View.FULL] requires
     *          `cloudtasks.tasks.fullView` [Google IAM](https://cloud.google.com/iam/)
     *          permission on the [Task][google.cloud.tasks.v2beta2.Task] resource.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Tasks\V2beta2\Task\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Tasks\V2beta2\Task
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function runTask(array $optionalArgs = [])
    {
        $request = new RunTaskRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['responseView'])) {
            $request->setResponseView($optionalArgs['responseView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RunTask',
            Task::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
