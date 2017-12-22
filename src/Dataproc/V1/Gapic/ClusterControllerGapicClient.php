<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
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
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PageStreamingDescriptor;
use Google\Cloud\Dataproc\V1\Cluster;
use Google\Cloud\Dataproc\V1\ClusterControllerGrpcClient;
use Google\Cloud\Dataproc\V1\CreateClusterRequest;
use Google\Cloud\Dataproc\V1\DeleteClusterRequest;
use Google\Cloud\Dataproc\V1\DiagnoseClusterRequest;
use Google\Cloud\Dataproc\V1\GetClusterRequest;
use Google\Cloud\Dataproc\V1\ListClustersRequest;
use Google\Cloud\Dataproc\V1\UpdateClusterRequest;
use Google\Cloud\Version;
use Google\Protobuf\FieldMask;

/**
 * Service Description: The ClusterControllerService provides methods to manage clusters
 * of Google Compute Engine instances.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $clusterControllerClient = new ClusterControllerClient();
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

    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $clusterControllerStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getPageStreamingDescriptors()
    {
        $listClustersPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getClusters',
                ]);

        $pageStreamingDescriptors = [
            'listClusters' => $listClustersPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getLongRunningDescriptors()
    {
        return [
            'createCluster' => [
                'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
            ],
            'updateCluster' => [
                'operationReturnType' => '\Google\Cloud\Dataproc\V1\Cluster',
                'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
            ],
            'deleteCluster' => [
                'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                'metadataReturnType' => '\Google\Cloud\Dataproc\V1\ClusterOperationMetadata',
            ],
            'diagnoseCluster' => [
                'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                'metadataReturnType' => '\Google\Cloud\Dataproc\V1\DiagnoseClusterResults',
            ],
        ];
    }

    private static function getGapicVersion()
    {
        if (!self::$gapicVersionLoaded) {
            if (file_exists(__DIR__.'/../VERSION')) {
                self::$gapicVersion = trim(file_get_contents(__DIR__.'/../VERSION'));
            } elseif (class_exists(Version::class)) {
                self::$gapicVersion = Version::VERSION;
            }
            self::$gapicVersionLoaded = true;
        }

        return self::$gapicVersion;
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\ApiCore\LongRunning\OperationsClient
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
     * @return \Google\ApiCore\OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $lroDescriptors = self::getLongRunningDescriptors();
        if (!is_null($methodName) && array_key_exists($methodName, $lroDescriptors)) {
            $options = $lroDescriptors[$methodName];
        } else {
            $options = [];
        }
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
     *     @type \Grpc\Channel $channel
     *           A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
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
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/cluster_controller_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['retryingOverride']);
            unset($operationsClientOptions['clientConfigPath']);
            $this->operationsClient = new OperationsClient($operationsClientOptions);
        }

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'createCluster' => $defaultDescriptors,
            'updateCluster' => $defaultDescriptors,
            'deleteCluster' => $defaultDescriptors,
            'getCluster' => $defaultDescriptors,
            'listClusters' => $defaultDescriptors,
            'diagnoseCluster' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.dataproc.v1.ClusterController',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createClusterControllerStubFunction = function ($hostname, $opts, $channel) {
            return new ClusterControllerGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createClusterControllerStubFunction', $options)) {
            $createClusterControllerStubFunction = $options['createClusterControllerStubFunction'];
        }
        $this->clusterControllerStub = $this->grpcCredentialsHelper->createStub($createClusterControllerStubFunction);
    }

    /**
     * Creates a cluster in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($projectId, $region, $cluster, $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setCluster($cluster);

        $defaultCallSettings = $this->defaultCallSettings['createCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'CreateCluster',
            $mergedSettings,
            $this->descriptors['createCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates a cluster in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['updateCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'UpdateCluster',
            $mergedSettings,
            $this->descriptors['updateCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a cluster in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($projectId, $region, $clusterName, $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

        $defaultCallSettings = $this->defaultCallSettings['deleteCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'DeleteCluster',
            $mergedSettings,
            $this->descriptors['deleteCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the resource representation for a cluster in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Cluster
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($projectId, $region, $clusterName, $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

        $defaultCallSettings = $this->defaultCallSettings['getCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'GetCluster',
            $mergedSettings,
            $this->descriptors['getCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists all regions/{region}/clusters in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['listClusters'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'ListClusters',
            $mergedSettings,
            $this->descriptors['listClusters']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets cluster diagnostic information.
     * After the operation completes, the Operation.response field
     * contains `DiagnoseClusterOutputLocation`.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterControllerClient = new ClusterControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function diagnoseCluster($projectId, $region, $clusterName, $optionalArgs = [])
    {
        $request = new DiagnoseClusterRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setClusterName($clusterName);

        $defaultCallSettings = $this->defaultCallSettings['diagnoseCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterControllerStub,
            'DiagnoseCluster',
            $mergedSettings,
            $this->descriptors['diagnoseCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->clusterControllerStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
