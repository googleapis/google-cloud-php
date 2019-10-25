<?php
/*
 * Copyright 2019 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/dataproc/v1beta2/clusters.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1beta2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Dataproc\V1beta2\Cluster;
use Google\Cloud\Dataproc\V1beta2\ClusterOperationMetadata;
use Google\Cloud\Dataproc\V1beta2\CreateClusterRequest;
use Google\Cloud\Dataproc\V1beta2\DeleteClusterRequest;
use Google\Cloud\Dataproc\V1beta2\DiagnoseClusterRequest;
use Google\Cloud\Dataproc\V1beta2\GetClusterRequest;
use Google\Cloud\Dataproc\V1beta2\ListClustersRequest;
use Google\Cloud\Dataproc\V1beta2\ListClustersResponse;
use Google\Cloud\Dataproc\V1beta2\UpdateClusterRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;

/**
 * Service Description: The ClusterControllerService provides methods to manage clusters
 * of Compute Engine instances.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $clusterControllerClient = new ClusterControllerClient();
 * try {
 *     $projectId = '';
 *     $region = '';
 *     $cluster = new Cluster();
 *     $operationResponse = $clusterControllerClient->createCluster($projectId, $region, $cluster);
 *     $operationResponse->pollUntilComplete();
 *     if ($operationResponse->operationSucceeded()) {
 *         $result = $operationResponse->getResult();
 *         // doSomethingWith($result)
 *     } else {
 *         $error = $operationResponse->getError();
 *         // handleError($error)
 *     }
 *
 *
 *     // Alternatively:
 *
 *     // start the operation, keep the operation name, and resume later
 *     $operationResponse = $clusterControllerClient->createCluster($projectId, $region, $cluster);
 *     $operationName = $operationResponse->getName();
 *     // ... do other work
 *     $newOperationResponse = $clusterControllerClient->resumeOperation($operationName, 'createCluster');
 *     while (!$newOperationResponse->isDone()) {
 *         // ... do other work
 *         $newOperationResponse->reload();
 *     }
 *     if ($newOperationResponse->operationSucceeded()) {
 *       $result = $newOperationResponse->getResult();
 *       // doSomethingWith($result)
 *     } else {
 *       $error = $newOperationResponse->getError();
 *       // handleError($error)
 *     }
 * } finally {
 *     $clusterControllerClient->close();
 * }
 * ```
 *
 * @experimental
 */
class ClusterControllerGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dataproc.v1beta2.ClusterController';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'dataproc.googleapis.com';

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

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/cluster_controller_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/cluster_controller_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/cluster_controller_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/cluster_controller_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
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
     *           as "<uri>:<port>". Default 'dataproc.googleapis.com:443'.
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Creates a cluster in a project. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [ClusterOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1beta2#clusteroperationmetadata).
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $cluster = new Cluster();
     *     $operationResponse = $clusterControllerClient->createCluster($projectId, $region, $cluster);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $clusterControllerClient->createCluster($projectId, $region, $cluster);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $clusterControllerClient->resumeOperation($operationName, 'createCluster');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string  $projectId    Required. The ID of the Google Cloud Platform project that the cluster
     *                              belongs to.
     * @param string  $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param Cluster $cluster      Required. The cluster to create.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type string $requestId
     *          Optional. A unique id used to identify the request. If the server
     *          receives two [CreateClusterRequest][google.cloud.dataproc.v1beta2.CreateClusterRequest] requests  with the same
     *          id, then the second request will be ignored and the
     *          first [google.longrunning.Operation][google.longrunning.Operation] created and stored in the backend
     *          is returned.
     *
     *          It is recommended to always set this value to a
     *          [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier).
     *
     *          The id must contain only letters (a-z, A-Z), numbers (0-9),
     *          underscores (_), and hyphens (-). The maximum length is 40 characters.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($projectId, $region, $cluster, array $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setCluster($cluster);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        return $this->startOperationsCall(
            'CreateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates a cluster in a project. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [ClusterOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1beta2#clusteroperationmetadata).
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $clusterName = '';
     *     $cluster = new Cluster();
     *     $updateMask = new FieldMask();
     *     $operationResponse = $clusterControllerClient->updateCluster($projectId, $region, $clusterName, $cluster, $updateMask);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $clusterControllerClient->updateCluster($projectId, $region, $clusterName, $cluster, $updateMask);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $clusterControllerClient->resumeOperation($operationName, 'updateCluster');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string    $projectId   Required. The ID of the Google Cloud Platform project the
     *                               cluster belongs to.
     * @param string    $region      Required. The Cloud Dataproc region in which to handle the request.
     * @param string    $clusterName Required. The cluster name.
     * @param Cluster   $cluster     Required. The changes to the cluster.
     * @param FieldMask $updateMask  Required. Specifies the path, relative to `Cluster`, of
     *                               the field to update. For example, to change the number of workers
     *                               in a cluster to 5, the `update_mask` parameter would be
     *                               specified as `config.worker_config.num_instances`,
     *                               and the `PATCH` request body would specify the new value, as follows:
     *
     *     {
     *       "config":{
     *         "workerConfig":{
     *           "numInstances":"5"
     *         }
     *       }
     *     }
     *
     * Similarly, to change the number of preemptible workers in a cluster to 5,
     * the `update_mask` parameter would be
     * `config.secondary_worker_config.num_instances`, and the `PATCH` request
     * body would be set as follows:
     *
     *     {
     *       "config":{
     *         "secondaryWorkerConfig":{
     *           "numInstances":"5"
     *         }
     *       }
     *     }
     * <strong>Note:</strong> currently only the following fields can be updated:
     *
     * <table>
     * <tr>
     * <td><strong>Mask</strong></td><td><strong>Purpose</strong></td>
     * </tr>
     * <tr>
     * <td>labels</td><td>Updates labels</td>
     * </tr>
     * <tr>
     * <td>config.worker_config.num_instances</td><td>Resize primary worker
     * group</td>
     * </tr>
     * <tr>
     * <td>config.secondary_worker_config.num_instances</td><td>Resize secondary
     * worker group</td>
     * </tr>
     * <tr>
     * <td>config.lifecycle_config.auto_delete_ttl</td><td>Reset MAX TTL
     * duration</td>
     * </tr>
     * <tr>
     * <td>config.lifecycle_config.auto_delete_time</td><td>Update MAX TTL
     * deletion timestamp</td>
     * </tr>
     * <tr>
     * <td>config.lifecycle_config.idle_delete_ttl</td><td>Update Idle TTL
     * duration</td>
     * </tr>
     * <tr>
     * <td>config.autoscaling_config.policy_uri</td><td>Use, stop using, or change
     * autoscaling policies</td>
     * </tr>
     * </table>
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type Duration $gracefulDecommissionTimeout
     *          Optional. Timeout for graceful YARN decomissioning. Graceful
     *          decommissioning allows removing nodes from the cluster without
     *          interrupting jobs in progress. Timeout specifies how long to wait for jobs
     *          in progress to finish before forcefully removing nodes (and potentially
     *          interrupting jobs). Default timeout is 0 (for forceful decommission), and
     *          the maximum allowed timeout is 1 day.
     *
     *          Only supported on Dataproc image versions 1.2 and higher.
     *     @type string $requestId
     *          Optional. A unique id used to identify the request. If the server
     *          receives two [UpdateClusterRequest][google.cloud.dataproc.v1beta2.UpdateClusterRequest] requests  with the same
     *          id, then the second request will be ignored and the
     *          first [google.longrunning.Operation][google.longrunning.Operation] created and stored in the
     *          backend is returned.
     *
     *          It is recommended to always set this value to a
     *          [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier).
     *
     *          The id must contain only letters (a-z, A-Z), numbers (0-9),
     *          underscores (_), and hyphens (-). The maximum length is 40 characters.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCluster($projectId, $region, $clusterName, $cluster, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);
        $request->setCluster($cluster);
        $request->setUpdateMask($updateMask);
        if (isset($optionalArgs['gracefulDecommissionTimeout'])) {
            $request->setGracefulDecommissionTimeout($optionalArgs['gracefulDecommissionTimeout']);
        }
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        return $this->startOperationsCall(
            'UpdateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes a cluster in a project. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [ClusterOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1beta2#clusteroperationmetadata).
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $clusterName = '';
     *     $operationResponse = $clusterControllerClient->deleteCluster($projectId, $region, $clusterName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $clusterControllerClient->deleteCluster($projectId, $region, $clusterName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $clusterControllerClient->resumeOperation($operationName, 'deleteCluster');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the cluster
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $clusterName  Required. The cluster name.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $clusterUuid
     *          Optional. Specifying the `cluster_uuid` means the RPC should fail
     *          (with error NOT_FOUND) if cluster with specified UUID does not exist.
     *     @type string $requestId
     *          Optional. A unique id used to identify the request. If the server
     *          receives two [DeleteClusterRequest][google.cloud.dataproc.v1beta2.DeleteClusterRequest] requests  with the same
     *          id, then the second request will be ignored and the
     *          first [google.longrunning.Operation][google.longrunning.Operation] created and stored in the
     *          backend is returned.
     *
     *          It is recommended to always set this value to a
     *          [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier).
     *
     *          The id must contain only letters (a-z, A-Z), numbers (0-9),
     *          underscores (_), and hyphens (-). The maximum length is 40 characters.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($projectId, $region, $clusterName, array $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);
        if (isset($optionalArgs['clusterUuid'])) {
            $request->setClusterUuid($optionalArgs['clusterUuid']);
        }
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        return $this->startOperationsCall(
            'DeleteCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets the resource representation for a cluster in a project.
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $clusterName = '';
     *     $response = $clusterControllerClient->getCluster($projectId, $region, $clusterName);
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the cluster
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $clusterName  Required. The cluster name.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1beta2\Cluster
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($projectId, $region, $clusterName, array $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

        return $this->startCall(
            'GetCluster',
            Cluster::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all regions/{region}/clusters in a project.
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $clusterControllerClient->listClusters($projectId, $region);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $clusterControllerClient->listClusters($projectId, $region);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the cluster
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          Optional.  A filter constraining the clusters to list. Filters are
     *          case-sensitive and have the following syntax:
     *
     *          field = value [AND [field = value]] ...
     *
     *          where **field** is one of `status.state`, `clusterName`, or `labels.[KEY]`,
     *          and `[KEY]` is a label key. **value** can be `*` to match all values.
     *          `status.state` can be one of the following: `ACTIVE`, `INACTIVE`,
     *          `CREATING`, `RUNNING`, `ERROR`, `DELETING`, or `UPDATING`. `ACTIVE`
     *          contains the `CREATING`, `UPDATING`, and `RUNNING` states. `INACTIVE`
     *          contains the `DELETING` and `ERROR` states.
     *          `clusterName` is the name of the cluster provided at creation time.
     *          Only the logical `AND` operator is supported; space-separated items are
     *          treated as having an implicit `AND` operator.
     *
     *          Example filter:
     *
     *          status.state = ACTIVE AND clusterName = mycluster
     *          AND labels.env = staging AND labels.starred = *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($projectId, $region, array $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListClusters',
            $optionalArgs,
            ListClustersResponse::class,
            $request
        );
    }

    /**
     * Gets cluster diagnostic information. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [ClusterOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1beta2#clusteroperationmetadata).
     * After the operation completes,
     * [Operation.response][google.longrunning.Operation.response]
     * contains
     * [Empty](https://cloud.google.comgoogle.protobuf.Empty).
     *
     * Sample code:
     * ```
     * $clusterControllerClient = new ClusterControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $clusterName = '';
     *     $operationResponse = $clusterControllerClient->diagnoseCluster($projectId, $region, $clusterName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $clusterControllerClient->diagnoseCluster($projectId, $region, $clusterName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $clusterControllerClient->resumeOperation($operationName, 'diagnoseCluster');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $clusterControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the cluster
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $clusterName  Required. The cluster name.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function diagnoseCluster($projectId, $region, $clusterName, array $optionalArgs = [])
    {
        $request = new DiagnoseClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

        return $this->startOperationsCall(
            'DiagnoseCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}
