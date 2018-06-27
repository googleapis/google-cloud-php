<?php
/*
 * Copyright 2017 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/container/v1/cluster_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Container\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Container\V1\AddonsConfig;
use Google\Cloud\Container\V1\CancelOperationRequest;
use Google\Cloud\Container\V1\Cluster;
use Google\Cloud\Container\V1\ClusterUpdate;
use Google\Cloud\Container\V1\CompleteIPRotationRequest;
use Google\Cloud\Container\V1\CreateClusterRequest;
use Google\Cloud\Container\V1\CreateNodePoolRequest;
use Google\Cloud\Container\V1\DeleteClusterRequest;
use Google\Cloud\Container\V1\DeleteNodePoolRequest;
use Google\Cloud\Container\V1\GetClusterRequest;
use Google\Cloud\Container\V1\GetNodePoolRequest;
use Google\Cloud\Container\V1\GetOperationRequest;
use Google\Cloud\Container\V1\GetServerConfigRequest;
use Google\Cloud\Container\V1\ListClustersRequest;
use Google\Cloud\Container\V1\ListClustersResponse;
use Google\Cloud\Container\V1\ListNodePoolsRequest;
use Google\Cloud\Container\V1\ListNodePoolsResponse;
use Google\Cloud\Container\V1\ListOperationsRequest;
use Google\Cloud\Container\V1\ListOperationsResponse;
use Google\Cloud\Container\V1\MaintenancePolicy;
use Google\Cloud\Container\V1\MasterAuth;
use Google\Cloud\Container\V1\NetworkPolicy;
use Google\Cloud\Container\V1\NodeManagement;
use Google\Cloud\Container\V1\NodePool;
use Google\Cloud\Container\V1\NodePoolAutoscaling;
use Google\Cloud\Container\V1\Operation;
use Google\Cloud\Container\V1\RollbackNodePoolUpgradeRequest;
use Google\Cloud\Container\V1\ServerConfig;
use Google\Cloud\Container\V1\SetAddonsConfigRequest;
use Google\Cloud\Container\V1\SetLabelsRequest;
use Google\Cloud\Container\V1\SetLegacyAbacRequest;
use Google\Cloud\Container\V1\SetLocationsRequest;
use Google\Cloud\Container\V1\SetLoggingServiceRequest;
use Google\Cloud\Container\V1\SetMaintenancePolicyRequest;
use Google\Cloud\Container\V1\SetMasterAuthRequest;
use Google\Cloud\Container\V1\SetMasterAuthRequest_Action;
use Google\Cloud\Container\V1\SetMonitoringServiceRequest;
use Google\Cloud\Container\V1\SetNetworkPolicyRequest;
use Google\Cloud\Container\V1\SetNodePoolAutoscalingRequest;
use Google\Cloud\Container\V1\SetNodePoolManagementRequest;
use Google\Cloud\Container\V1\SetNodePoolSizeRequest;
use Google\Cloud\Container\V1\StartIPRotationRequest;
use Google\Cloud\Container\V1\UpdateClusterRequest;
use Google\Cloud\Container\V1\UpdateMasterRequest;
use Google\Cloud\Container\V1\UpdateNodePoolRequest;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Google Container Engine Cluster Manager v1.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $clusterManagerClient = new ClusterManagerClient();
 * try {
 *     $projectId = '';
 *     $zone = '';
 *     $response = $clusterManagerClient->listClusters($projectId, $zone);
 * } finally {
 *     $clusterManagerClient->close();
 * }
 * ```
 *
 * @experimental
 */
class ClusterManagerGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.container.v1.ClusterManager';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'container.googleapis.com';

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
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/cluster_manager_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/cluster_manager_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/cluster_manager_rest_client_config.php',
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
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'container.googleapis.com:443'.
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
     *           object is provided, any settings in $transportConfig, and any $serviceAddress
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
     * Lists all clusters owned by a project in either the specified zone or all
     * zones.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $response = $clusterManagerClient->listClusters($projectId, $zone);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides, or "-" for all zones.
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
     * @return \Google\Cloud\Container\V1\ListClustersResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($projectId, $zone, array $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        return $this->startCall(
            'ListClusters',
            ListClustersResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the details of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $response = $clusterManagerClient->getCluster($projectId, $zone, $clusterId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to retrieve.
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
     * @return \Google\Cloud\Container\V1\Cluster
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($projectId, $zone, $clusterId, array $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        return $this->startCall(
            'GetCluster',
            Cluster::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a cluster, consisting of the specified number and type of Google
     * Compute Engine instances.
     *
     * By default, the cluster is created in the project's
     * [default network](https://cloud.google.com/compute/docs/networks-and-firewalls#networks).
     *
     * One firewall is added for the cluster. After cluster creation,
     * the cluster creates routes for each node to allow the containers
     * on that node to communicate with all other instances in the
     * cluster.
     *
     * Finally, an entry is added to the project's global metadata indicating
     * which CIDR range is being used by the cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $cluster = new Cluster();
     *     $response = $clusterManagerClient->createCluster($projectId, $zone, $cluster);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string  $projectId    The Google Developers Console [project ID or project
     *                              number](https://support.google.com/cloud/answer/6158840).
     * @param string  $zone         The name of the Google Compute Engine
     *                              [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                              resides.
     * @param Cluster $cluster      A [cluster
     *                              resource](https://cloud.google.com/container-engine/reference/rest/v1/projects.zones.clusters)
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($projectId, $zone, $cluster, array $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setCluster($cluster);

        return $this->startCall(
            'CreateCluster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the settings of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $update = new ClusterUpdate();
     *     $response = $clusterManagerClient->updateCluster($projectId, $zone, $clusterId, $update);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string        $projectId    The Google Developers Console [project ID or project
     *                                    number](https://support.google.com/cloud/answer/6158840).
     * @param string        $zone         The name of the Google Compute Engine
     *                                    [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                    resides.
     * @param string        $clusterId    The name of the cluster to upgrade.
     * @param ClusterUpdate $update       A description of the update.
     * @param array         $optionalArgs {
     *                                    Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCluster($projectId, $zone, $clusterId, $update, array $optionalArgs = [])
    {
        $request = new UpdateClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setUpdate($update);

        return $this->startCall(
            'UpdateCluster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the version and/or image type of a specific node pool.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $nodeVersion = '';
     *     $imageType = '';
     *     $response = $clusterManagerClient->updateNodePool($projectId, $zone, $clusterId, $nodePoolId, $nodeVersion, $imageType);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to upgrade.
     * @param string $nodePoolId   The name of the node pool to upgrade.
     * @param string $nodeVersion  The Kubernetes version to change the nodes to (typically an
     *                             upgrade). Use `-` to upgrade to the latest version supported by
     *                             the server.
     * @param string $imageType    The desired image type for the node pool.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateNodePool($projectId, $zone, $clusterId, $nodePoolId, $nodeVersion, $imageType, array $optionalArgs = [])
    {
        $request = new UpdateNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setNodeVersion($nodeVersion);
        $request->setImageType($imageType);

        return $this->startCall(
            'UpdateNodePool',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the autoscaling settings of a specific node pool.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $autoscaling = new NodePoolAutoscaling();
     *     $response = $clusterManagerClient->setNodePoolAutoscaling($projectId, $zone, $clusterId, $nodePoolId, $autoscaling);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string              $projectId    The Google Developers Console [project ID or project
     *                                          number](https://support.google.com/cloud/answer/6158840).
     * @param string              $zone         The name of the Google Compute Engine
     *                                          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                          resides.
     * @param string              $clusterId    The name of the cluster to upgrade.
     * @param string              $nodePoolId   The name of the node pool to upgrade.
     * @param NodePoolAutoscaling $autoscaling  Autoscaling configuration for the node pool.
     * @param array               $optionalArgs {
     *                                          Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolAutoscaling($projectId, $zone, $clusterId, $nodePoolId, $autoscaling, array $optionalArgs = [])
    {
        $request = new SetNodePoolAutoscalingRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setAutoscaling($autoscaling);

        return $this->startCall(
            'SetNodePoolAutoscaling',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the logging service of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $loggingService = '';
     *     $response = $clusterManagerClient->setLoggingService($projectId, $zone, $clusterId, $loggingService);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId      The Google Developers Console [project ID or project
     *                               number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone           The name of the Google Compute Engine
     *                               [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                               resides.
     * @param string $clusterId      The name of the cluster to upgrade.
     * @param string $loggingService The logging service the cluster should use to write metrics.
     *                               Currently available options:
     *
     * * "logging.googleapis.com" - the Google Cloud Logging service
     * * "none" - no metrics will be exported from the cluster
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLoggingService($projectId, $zone, $clusterId, $loggingService, array $optionalArgs = [])
    {
        $request = new SetLoggingServiceRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setLoggingService($loggingService);

        return $this->startCall(
            'SetLoggingService',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the monitoring service of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $monitoringService = '';
     *     $response = $clusterManagerClient->setMonitoringService($projectId, $zone, $clusterId, $monitoringService);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId         The Google Developers Console [project ID or project
     *                                  number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone              The name of the Google Compute Engine
     *                                  [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                  resides.
     * @param string $clusterId         The name of the cluster to upgrade.
     * @param string $monitoringService The monitoring service the cluster should use to write metrics.
     *                                  Currently available options:
     *
     * * "monitoring.googleapis.com" - the Google Cloud Monitoring service
     * * "none" - no metrics will be exported from the cluster
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMonitoringService($projectId, $zone, $clusterId, $monitoringService, array $optionalArgs = [])
    {
        $request = new SetMonitoringServiceRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMonitoringService($monitoringService);

        return $this->startCall(
            'SetMonitoringService',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the addons of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $addonsConfig = new AddonsConfig();
     *     $response = $clusterManagerClient->setAddonsConfig($projectId, $zone, $clusterId, $addonsConfig);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string       $projectId    The Google Developers Console [project ID or project
     *                                   number](https://support.google.com/cloud/answer/6158840).
     * @param string       $zone         The name of the Google Compute Engine
     *                                   [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                   resides.
     * @param string       $clusterId    The name of the cluster to upgrade.
     * @param AddonsConfig $addonsConfig The desired configurations for the various addons available to run in the
     *                                   cluster.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setAddonsConfig($projectId, $zone, $clusterId, $addonsConfig, array $optionalArgs = [])
    {
        $request = new SetAddonsConfigRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setAddonsConfig($addonsConfig);

        return $this->startCall(
            'SetAddonsConfig',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the locations of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $locations = [];
     *     $response = $clusterManagerClient->setLocations($projectId, $zone, $clusterId, $locations);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string   $projectId The Google Developers Console [project ID or project
     *                            number](https://support.google.com/cloud/answer/6158840).
     * @param string   $zone      The name of the Google Compute Engine
     *                            [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                            resides.
     * @param string   $clusterId The name of the cluster to upgrade.
     * @param string[] $locations The desired list of Google Compute Engine
     *                            [locations](https://cloud.google.com/compute/docs/zones#available) in which the cluster's nodes
     *                            should be located. Changing the locations a cluster is in will result
     *                            in nodes being either created or removed from the cluster, depending on
     *                            whether locations are being added or removed.
     *
     * This list must always include the cluster's primary zone.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLocations($projectId, $zone, $clusterId, $locations, array $optionalArgs = [])
    {
        $request = new SetLocationsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setLocations($locations);

        return $this->startCall(
            'SetLocations',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the master of a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $masterVersion = '';
     *     $response = $clusterManagerClient->updateMaster($projectId, $zone, $clusterId, $masterVersion);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId     The Google Developers Console [project ID or project
     *                              number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone          The name of the Google Compute Engine
     *                              [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                              resides.
     * @param string $clusterId     The name of the cluster to upgrade.
     * @param string $masterVersion The Kubernetes version to change the master to. The only valid value is the
     *                              latest supported version. Use "-" to have the server automatically select
     *                              the latest version.
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateMaster($projectId, $zone, $clusterId, $masterVersion, array $optionalArgs = [])
    {
        $request = new UpdateMasterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMasterVersion($masterVersion);

        return $this->startCall(
            'UpdateMaster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Used to set master auth materials. Currently supports :-
     * Changing the admin password of a specific cluster.
     * This can be either via password generation or explicitly set the password.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $action = SetMasterAuthRequest_Action::UNKNOWN;
     *     $update = new MasterAuth();
     *     $response = $clusterManagerClient->setMasterAuth($projectId, $zone, $clusterId, $action, $update);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string     $projectId    The Google Developers Console [project ID or project
     *                                 number](https://support.google.com/cloud/answer/6158840).
     * @param string     $zone         The name of the Google Compute Engine
     *                                 [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                 resides.
     * @param string     $clusterId    The name of the cluster to upgrade.
     * @param int        $action       The exact form of action to be taken on the master auth.
     *                                 For allowed values, use constants defined on {@see \Google\Cloud\Container\V1\SetMasterAuthRequest_Action}
     * @param MasterAuth $update       A description of the update.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMasterAuth($projectId, $zone, $clusterId, $action, $update, array $optionalArgs = [])
    {
        $request = new SetMasterAuthRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setAction($action);
        $request->setUpdate($update);

        return $this->startCall(
            'SetMasterAuth',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the cluster, including the Kubernetes endpoint and all worker
     * nodes.
     *
     * Firewalls and routes that were configured during cluster creation
     * are also deleted.
     *
     * Other Google Compute Engine resources that might be in use by the cluster
     * (e.g. load balancer resources) will not be deleted if they weren't present
     * at the initial create time.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $response = $clusterManagerClient->deleteCluster($projectId, $zone, $clusterId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to delete.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($projectId, $zone, $clusterId, array $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        return $this->startCall(
            'DeleteCluster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all operations in a project in a specific zone or all zones.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $response = $clusterManagerClient->listOperations($projectId, $zone);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine [zone](https://cloud.google.com/compute/docs/zones#available)
     *                             to return operations for, or `-` for all zones.
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
     * @return \Google\Cloud\Container\V1\ListOperationsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listOperations($projectId, $zone, array $optionalArgs = [])
    {
        $request = new ListOperationsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        return $this->startCall(
            'ListOperations',
            ListOperationsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the specified operation.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $operationId = '';
     *     $response = $clusterManagerClient->getOperation($projectId, $zone, $operationId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $operationId  The server-assigned `name` of the operation.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getOperation($projectId, $zone, $operationId, array $optionalArgs = [])
    {
        $request = new GetOperationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setOperationId($operationId);

        return $this->startCall(
            'GetOperation',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Cancels the specified operation.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $operationId = '';
     *     $clusterManagerClient->cancelOperation($projectId, $zone, $operationId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the operation resides.
     * @param string $operationId  The server-assigned `name` of the operation.
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
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function cancelOperation($projectId, $zone, $operationId, array $optionalArgs = [])
    {
        $request = new CancelOperationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setOperationId($operationId);

        return $this->startCall(
            'CancelOperation',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns configuration info about the Container Engine service.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $response = $clusterManagerClient->getServerConfig($projectId, $zone);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine [zone](https://cloud.google.com/compute/docs/zones#available)
     *                             to return operations for.
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
     * @return \Google\Cloud\Container\V1\ServerConfig
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getServerConfig($projectId, $zone, array $optionalArgs = [])
    {
        $request = new GetServerConfigRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        return $this->startCall(
            'GetServerConfig',
            ServerConfig::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the node pools for a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $response = $clusterManagerClient->listNodePools($projectId, $zone, $clusterId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster.
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
     * @return \Google\Cloud\Container\V1\ListNodePoolsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listNodePools($projectId, $zone, $clusterId, array $optionalArgs = [])
    {
        $request = new ListNodePoolsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        return $this->startCall(
            'ListNodePools',
            ListNodePoolsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Retrieves the node pool requested.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $response = $clusterManagerClient->getNodePool($projectId, $zone, $clusterId, $nodePoolId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster.
     * @param string $nodePoolId   The name of the node pool.
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
     * @return \Google\Cloud\Container\V1\NodePool
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getNodePool($projectId, $zone, $clusterId, $nodePoolId, array $optionalArgs = [])
    {
        $request = new GetNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        return $this->startCall(
            'GetNodePool',
            NodePool::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a node pool for a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePool = new NodePool();
     *     $response = $clusterManagerClient->createNodePool($projectId, $zone, $clusterId, $nodePool);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string   $projectId    The Google Developers Console [project ID or project
     *                               number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string   $zone         The name of the Google Compute Engine
     *                               [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                               resides.
     * @param string   $clusterId    The name of the cluster.
     * @param NodePool $nodePool     The node pool to create.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createNodePool($projectId, $zone, $clusterId, $nodePool, array $optionalArgs = [])
    {
        $request = new CreateNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePool($nodePool);

        return $this->startCall(
            'CreateNodePool',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a node pool from a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $response = $clusterManagerClient->deleteNodePool($projectId, $zone, $clusterId, $nodePoolId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster.
     * @param string $nodePoolId   The name of the node pool to delete.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteNodePool($projectId, $zone, $clusterId, $nodePoolId, array $optionalArgs = [])
    {
        $request = new DeleteNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        return $this->startCall(
            'DeleteNodePool',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Roll back the previously Aborted or Failed NodePool upgrade.
     * This will be an no-op if the last upgrade successfully completed.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $response = $clusterManagerClient->rollbackNodePoolUpgrade($projectId, $zone, $clusterId, $nodePoolId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to rollback.
     * @param string $nodePoolId   The name of the node pool to rollback.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function rollbackNodePoolUpgrade($projectId, $zone, $clusterId, $nodePoolId, array $optionalArgs = [])
    {
        $request = new RollbackNodePoolUpgradeRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        return $this->startCall(
            'RollbackNodePoolUpgrade',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the NodeManagement options for a node pool.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $management = new NodeManagement();
     *     $response = $clusterManagerClient->setNodePoolManagement($projectId, $zone, $clusterId, $nodePoolId, $management);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string         $projectId    The Google Developers Console [project ID or project
     *                                     number](https://support.google.com/cloud/answer/6158840).
     * @param string         $zone         The name of the Google Compute Engine
     *                                     [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                     resides.
     * @param string         $clusterId    The name of the cluster to update.
     * @param string         $nodePoolId   The name of the node pool to update.
     * @param NodeManagement $management   NodeManagement configuration for the node pool.
     * @param array          $optionalArgs {
     *                                     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolManagement($projectId, $zone, $clusterId, $nodePoolId, $management, array $optionalArgs = [])
    {
        $request = new SetNodePoolManagementRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setManagement($management);

        return $this->startCall(
            'SetNodePoolManagement',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets labels on a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $resourceLabels = [];
     *     $labelFingerprint = '';
     *     $response = $clusterManagerClient->setLabels($projectId, $zone, $clusterId, $resourceLabels, $labelFingerprint);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId        The Google Developers Console [project ID or project
     *                                 number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone             The name of the Google Compute Engine
     *                                 [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                 resides.
     * @param string $clusterId        The name of the cluster.
     * @param array  $resourceLabels   The labels to set for that cluster.
     * @param string $labelFingerprint The fingerprint of the previous set of labels for this resource,
     *                                 used to detect conflicts. The fingerprint is initially generated by
     *                                 Container Engine and changes after every request to modify or update
     *                                 labels. You must always provide an up-to-date fingerprint hash when
     *                                 updating or changing labels. Make a <code>get()</code> request to the
     *                                 resource to get the latest fingerprint.
     * @param array  $optionalArgs     {
     *                                 Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLabels($projectId, $zone, $clusterId, $resourceLabels, $labelFingerprint, array $optionalArgs = [])
    {
        $request = new SetLabelsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setResourceLabels($resourceLabels);
        $request->setLabelFingerprint($labelFingerprint);

        return $this->startCall(
            'SetLabels',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Enables or disables the ABAC authorization mechanism on a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $enabled = false;
     *     $response = $clusterManagerClient->setLegacyAbac($projectId, $zone, $clusterId, $enabled);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to update.
     * @param bool   $enabled      Whether ABAC authorization will be enabled in the cluster.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLegacyAbac($projectId, $zone, $clusterId, $enabled, array $optionalArgs = [])
    {
        $request = new SetLegacyAbacRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setEnabled($enabled);

        return $this->startCall(
            'SetLegacyAbac',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Start master IP rotation.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $response = $clusterManagerClient->startIPRotation($projectId, $zone, $clusterId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function startIPRotation($projectId, $zone, $clusterId, array $optionalArgs = [])
    {
        $request = new StartIPRotationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        return $this->startCall(
            'StartIPRotation',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Completes master IP rotation.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $response = $clusterManagerClient->completeIPRotation($projectId, $zone, $clusterId);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function completeIPRotation($projectId, $zone, $clusterId, array $optionalArgs = [])
    {
        $request = new CompleteIPRotationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        return $this->startCall(
            'CompleteIPRotation',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the size of a specific node pool.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $nodePoolId = '';
     *     $nodeCount = 0;
     *     $response = $clusterManagerClient->setNodePoolSize($projectId, $zone, $clusterId, $nodePoolId, $nodeCount);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $projectId    The Google Developers Console [project ID or project
     *                             number](https://support.google.com/cloud/answer/6158840).
     * @param string $zone         The name of the Google Compute Engine
     *                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                             resides.
     * @param string $clusterId    The name of the cluster to update.
     * @param string $nodePoolId   The name of the node pool to update.
     * @param int    $nodeCount    The desired node count for the pool.
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
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolSize($projectId, $zone, $clusterId, $nodePoolId, $nodeCount, array $optionalArgs = [])
    {
        $request = new SetNodePoolSizeRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setNodeCount($nodeCount);

        return $this->startCall(
            'SetNodePoolSize',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Enables/Disables Network Policy for a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $networkPolicy = new NetworkPolicy();
     *     $response = $clusterManagerClient->setNetworkPolicy($projectId, $zone, $clusterId, $networkPolicy);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string        $projectId     The Google Developers Console [project ID or project
     *                                     number](https://developers.google.com/console/help/new/#projectnumber).
     * @param string        $zone          The name of the Google Compute Engine
     *                                     [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                     resides.
     * @param string        $clusterId     The name of the cluster.
     * @param NetworkPolicy $networkPolicy Configuration options for the NetworkPolicy feature.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNetworkPolicy($projectId, $zone, $clusterId, $networkPolicy, array $optionalArgs = [])
    {
        $request = new SetNetworkPolicyRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNetworkPolicy($networkPolicy);

        return $this->startCall(
            'SetNetworkPolicy',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the maintenance policy for a cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $maintenancePolicy = new MaintenancePolicy();
     *     $response = $clusterManagerClient->setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string            $projectId         The Google Developers Console [project ID or project
     *                                             number](https://support.google.com/cloud/answer/6158840).
     * @param string            $zone              The name of the Google Compute Engine
     *                                             [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *                                             resides.
     * @param string            $clusterId         The name of the cluster to update.
     * @param MaintenancePolicy $maintenancePolicy The maintenance policy to be set for the cluster. An empty field
     *                                             clears the existing maintenance policy.
     * @param array             $optionalArgs      {
     *                                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy, array $optionalArgs = [])
    {
        $request = new SetMaintenancePolicyRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMaintenancePolicy($maintenancePolicy);

        return $this->startCall(
            'SetMaintenancePolicy',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
