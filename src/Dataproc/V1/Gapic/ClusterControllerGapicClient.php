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
 * https://github.com/google/googleapis/blob/master/google/cloud/dataproc/v1/clusters.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Dataproc\V1\Cluster;
use Google\Cloud\Dataproc\V1\CreateClusterRequest;
use Google\Cloud\Dataproc\V1\DeleteClusterRequest;
use Google\Cloud\Dataproc\V1\DiagnoseClusterRequest;
use Google\Cloud\Dataproc\V1\GetClusterRequest;
use Google\Cloud\Dataproc\V1\ListClustersRequest;
use Google\Cloud\Dataproc\V1\ListClustersResponse;
use Google\Cloud\Dataproc\V1\UpdateClusterRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: The ClusterControllerService provides methods to manage clusters
 * of Google Compute Engine instances.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
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
 *       $result = $operationResponse->getResult();
 *       // doSomethingWith($result)
 *     } else {
 *       $error = $operationResponse->getError();
 *       // handleError($error)
 *     }
 *
 *     // OR start the operation, keep the operation name, and resume later
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
    const SERVICE_NAME = 'google.cloud.dataproc.v1.ClusterController';

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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/cluster_controller_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/cluster_controller_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/cluster_controller_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dataproc.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl().
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this option is unused.
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Google Cloud Dataproc API.
     *     @type string $clientConfigPath
     *           Path to a JSON file containing client method configuration, including retry settings.
     *           Specify this setting to specify the retry behavior of all methods on the client.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder. The retry settings provided in this option can be overridden
     *           by settings in $retryingOverride
     *     @type array $retryingOverride
     *           An associative array in which the keys are method names (e.g. 'createFoo'), and
     *           the values are retry settings to use for that method. The retry settings for each
     *           method can be a {@see Google\ApiCore\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\ApiCore\RetrySettings}
     *           for example usage. Passing a value of null is equivalent to a value of
     *           ['retriesEnabled' => false]. Retry settings provided in this setting override the
     *           settings in $clientConfigPath.
     *     @type callable $authHttpHandler A handler used to deliver PSR-7 requests specifically
     *           for authentication. Should match a signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $options += self::getClientDefaults();
        $this->setClientOptions($options);
        $this->pluckArray([
            'serviceName',
            'clientConfigPath',
            'descriptorsConfigPath',
        ], $options);
        $this->operationsClient = $this->pluck('operationsClient', $options, false)
            ?: new OperationsClient($options);
    }

    /**
     * Creates a cluster in a project.
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
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
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
    public function createCluster($projectId, $region, $cluster, $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setCluster($cluster);

        return $this->startOperationsCall(
            'CreateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates a cluster in a project.
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
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
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
     * <strong>Note:</strong> Currently, only the following fields can be updated:
     *
     *  <table>
     *  <tbody>
     *  <tr>
     *  <td><strong>Mask</strong></td>
     *  <td><strong>Purpose</strong></td>
     *  </tr>
     *  <tr>
     *  <td><strong><em>labels</em></strong></td>
     *  <td>Update labels</td>
     *  </tr>
     *  <tr>
     *  <td><strong><em>config.worker_config.num_instances</em></strong></td>
     *  <td>Resize primary worker group</td>
     *  </tr>
     *  <tr>
     *  <td><strong><em>config.secondary_worker_config.num_instances</em></strong></td>
     *  <td>Resize secondary worker group</td>
     *  </tr>
     *  </tbody>
     *  </table>
     * @param array $optionalArgs {
     *                            Optional.
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
    public function updateCluster($projectId, $region, $clusterName, $cluster, $updateMask, $optionalArgs = [])
    {
        $request = new UpdateClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);
        $request->setCluster($cluster);
        $request->setUpdateMask($updateMask);

        return $this->startOperationsCall(
            'UpdateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes a cluster in a project.
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
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
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
    public function deleteCluster($projectId, $region, $clusterName, $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

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
     * @return \Google\Cloud\Dataproc\V1\Cluster
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($projectId, $region, $clusterName, $optionalArgs = [])
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
     *     // Iterate through all elements
     *     $pagedResponse = $clusterControllerClient->listClusters($projectId, $region);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $clusterControllerClient->listClusters($projectId, $region);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
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
     *          Optional. A filter constraining the clusters to list. Filters are
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
    public function listClusters($projectId, $region, $optionalArgs = [])
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
     * Gets cluster diagnostic information.
     * After the operation completes, the Operation.response field
     * contains `DiagnoseClusterOutputLocation`.
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
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
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
    public function diagnoseCluster($projectId, $region, $clusterName, $optionalArgs = [])
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
