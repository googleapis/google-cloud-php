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
 * https://github.com/google/googleapis/blob/master/google/container/v1/cluster_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Container\V1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\Cloud\Container\V1\AddonsConfig;
use Google\Cloud\Container\V1\CancelOperationRequest;
use Google\Cloud\Container\V1\Cluster;
use Google\Cloud\Container\V1\ClusterManagerGrpcClient;
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
use Google\Cloud\Container\V1\ListNodePoolsRequest;
use Google\Cloud\Container\V1\ListOperationsRequest;
use Google\Cloud\Container\V1\MaintenancePolicy;
use Google\Cloud\Container\V1\MasterAuth;
use Google\Cloud\Container\V1\NetworkPolicy;
use Google\Cloud\Container\V1\NodeManagement;
use Google\Cloud\Container\V1\NodePool;
use Google\Cloud\Container\V1\NodePoolAutoscaling;
use Google\Cloud\Container\V1\RollbackNodePoolUpgradeRequest;
use Google\Cloud\Container\V1\SetAddonsConfigRequest;
use Google\Cloud\Container\V1\SetLabelsRequest;
use Google\Cloud\Container\V1\SetLegacyAbacRequest;
use Google\Cloud\Container\V1\SetLocationsRequest;
use Google\Cloud\Container\V1\SetLoggingServiceRequest;
use Google\Cloud\Container\V1\SetMaintenancePolicyRequest;
use Google\Cloud\Container\V1\SetMasterAuthRequest;
use Google\Cloud\Container\V1\SetMasterAuthRequest_Action as Action;
use Google\Cloud\Container\V1\SetMonitoringServiceRequest;
use Google\Cloud\Container\V1\SetNetworkPolicyRequest;
use Google\Cloud\Container\V1\SetNodePoolAutoscalingRequest;
use Google\Cloud\Container\V1\SetNodePoolManagementRequest;
use Google\Cloud\Container\V1\SetNodePoolSizeRequest;
use Google\Cloud\Container\V1\StartIPRotationRequest;
use Google\Cloud\Container\V1\UpdateClusterRequest;
use Google\Cloud\Container\V1\UpdateMasterRequest;
use Google\Cloud\Container\V1\UpdateNodePoolRequest;
use Google\Cloud\Version;

/**
 * Service Description: Google Container Engine Cluster Manager v1.
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
 *     $clusterManagerClient = new ClusterManagerClient();
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $clusterManagerStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'container.googleapis.com'.
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
     *                          Defaults to the scopes for the Google Container Engine API.
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
            'clientConfigPath' => __DIR__.'/../resources/cluster_manager_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'listClusters' => $defaultDescriptors,
            'getCluster' => $defaultDescriptors,
            'createCluster' => $defaultDescriptors,
            'updateCluster' => $defaultDescriptors,
            'updateNodePool' => $defaultDescriptors,
            'setNodePoolAutoscaling' => $defaultDescriptors,
            'setLoggingService' => $defaultDescriptors,
            'setMonitoringService' => $defaultDescriptors,
            'setAddonsConfig' => $defaultDescriptors,
            'setLocations' => $defaultDescriptors,
            'updateMaster' => $defaultDescriptors,
            'setMasterAuth' => $defaultDescriptors,
            'deleteCluster' => $defaultDescriptors,
            'listOperations' => $defaultDescriptors,
            'getOperation' => $defaultDescriptors,
            'cancelOperation' => $defaultDescriptors,
            'getServerConfig' => $defaultDescriptors,
            'listNodePools' => $defaultDescriptors,
            'getNodePool' => $defaultDescriptors,
            'createNodePool' => $defaultDescriptors,
            'deleteNodePool' => $defaultDescriptors,
            'rollbackNodePoolUpgrade' => $defaultDescriptors,
            'setNodePoolManagement' => $defaultDescriptors,
            'setLabels' => $defaultDescriptors,
            'setLegacyAbac' => $defaultDescriptors,
            'startIPRotation' => $defaultDescriptors,
            'completeIPRotation' => $defaultDescriptors,
            'setNodePoolSize' => $defaultDescriptors,
            'setNetworkPolicy' => $defaultDescriptors,
            'setMaintenancePolicy' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.container.v1.ClusterManager',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createClusterManagerStubFunction = function ($hostname, $opts, $channel) {
            return new ClusterManagerGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createClusterManagerStubFunction', $options)) {
            $createClusterManagerStubFunction = $options['createClusterManagerStubFunction'];
        }
        $this->clusterManagerStub = $this->grpcCredentialsHelper->createStub($createClusterManagerStubFunction);
    }

    /**
     * Lists all clusters owned by a project in either the specified zone or all
     * zones.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\ListClustersResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($projectId, $zone, $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        $defaultCallSettings = $this->defaultCallSettings['listClusters'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
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
     * Gets the details of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Cluster
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($projectId, $zone, $clusterId, $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        $defaultCallSettings = $this->defaultCallSettings['getCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
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
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($projectId, $zone, $cluster, $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setCluster($cluster);

        $defaultCallSettings = $this->defaultCallSettings['createCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
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
     * Updates the settings of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateCluster($projectId, $zone, $clusterId, $update, $optionalArgs = [])
    {
        $request = new UpdateClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setUpdate($update);

        $defaultCallSettings = $this->defaultCallSettings['updateCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
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
     * Updates the version and/or image type of a specific node pool.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateNodePool($projectId, $zone, $clusterId, $nodePoolId, $nodeVersion, $imageType, $optionalArgs = [])
    {
        $request = new UpdateNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setNodeVersion($nodeVersion);
        $request->setImageType($imageType);

        $defaultCallSettings = $this->defaultCallSettings['updateNodePool'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'UpdateNodePool',
            $mergedSettings,
            $this->descriptors['updateNodePool']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the autoscaling settings of a specific node pool.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolAutoscaling($projectId, $zone, $clusterId, $nodePoolId, $autoscaling, $optionalArgs = [])
    {
        $request = new SetNodePoolAutoscalingRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setAutoscaling($autoscaling);

        $defaultCallSettings = $this->defaultCallSettings['setNodePoolAutoscaling'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetNodePoolAutoscaling',
            $mergedSettings,
            $this->descriptors['setNodePoolAutoscaling']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the logging service of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setLoggingService($projectId, $zone, $clusterId, $loggingService, $optionalArgs = [])
    {
        $request = new SetLoggingServiceRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setLoggingService($loggingService);

        $defaultCallSettings = $this->defaultCallSettings['setLoggingService'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetLoggingService',
            $mergedSettings,
            $this->descriptors['setLoggingService']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the monitoring service of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setMonitoringService($projectId, $zone, $clusterId, $monitoringService, $optionalArgs = [])
    {
        $request = new SetMonitoringServiceRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMonitoringService($monitoringService);

        $defaultCallSettings = $this->defaultCallSettings['setMonitoringService'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetMonitoringService',
            $mergedSettings,
            $this->descriptors['setMonitoringService']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the addons of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setAddonsConfig($projectId, $zone, $clusterId, $addonsConfig, $optionalArgs = [])
    {
        $request = new SetAddonsConfigRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setAddonsConfig($addonsConfig);

        $defaultCallSettings = $this->defaultCallSettings['setAddonsConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetAddonsConfig',
            $mergedSettings,
            $this->descriptors['setAddonsConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the locations of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setLocations($projectId, $zone, $clusterId, $locations, $optionalArgs = [])
    {
        $request = new SetLocationsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setLocations($locations);

        $defaultCallSettings = $this->defaultCallSettings['setLocations'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetLocations',
            $mergedSettings,
            $this->descriptors['setLocations']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates the master of a specific cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateMaster($projectId, $zone, $clusterId, $masterVersion, $optionalArgs = [])
    {
        $request = new UpdateMasterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMasterVersion($masterVersion);

        $defaultCallSettings = $this->defaultCallSettings['updateMaster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'UpdateMaster',
            $mergedSettings,
            $this->descriptors['updateMaster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Used to set master auth materials. Currently supports :-
     * Changing the admin password of a specific cluster.
     * This can be either via password generation or explicitly set the password.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
     *     $projectId = '';
     *     $zone = '';
     *     $clusterId = '';
     *     $action = Action::UNKNOWN;
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setMasterAuth($projectId, $zone, $clusterId, $action, $update, $optionalArgs = [])
    {
        $request = new SetMasterAuthRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setAction($action);
        $request->setUpdate($update);

        $defaultCallSettings = $this->defaultCallSettings['setMasterAuth'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetMasterAuth',
            $mergedSettings,
            $this->descriptors['setMasterAuth']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($projectId, $zone, $clusterId, $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        $defaultCallSettings = $this->defaultCallSettings['deleteCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
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
     * Lists all operations in a project in a specific zone or all zones.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\ListOperationsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listOperations($projectId, $zone, $optionalArgs = [])
    {
        $request = new ListOperationsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        $defaultCallSettings = $this->defaultCallSettings['listOperations'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'ListOperations',
            $mergedSettings,
            $this->descriptors['listOperations']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the specified operation.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getOperation($projectId, $zone, $operationId, $optionalArgs = [])
    {
        $request = new GetOperationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setOperationId($operationId);

        $defaultCallSettings = $this->defaultCallSettings['getOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'GetOperation',
            $mergedSettings,
            $this->descriptors['getOperation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Cancels the specified operation.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function cancelOperation($projectId, $zone, $operationId, $optionalArgs = [])
    {
        $request = new CancelOperationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setOperationId($operationId);

        $defaultCallSettings = $this->defaultCallSettings['cancelOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'CancelOperation',
            $mergedSettings,
            $this->descriptors['cancelOperation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns configuration info about the Container Engine service.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\ServerConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getServerConfig($projectId, $zone, $optionalArgs = [])
    {
        $request = new GetServerConfigRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);

        $defaultCallSettings = $this->defaultCallSettings['getServerConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'GetServerConfig',
            $mergedSettings,
            $this->descriptors['getServerConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the node pools for a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\ListNodePoolsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listNodePools($projectId, $zone, $clusterId, $optionalArgs = [])
    {
        $request = new ListNodePoolsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        $defaultCallSettings = $this->defaultCallSettings['listNodePools'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'ListNodePools',
            $mergedSettings,
            $this->descriptors['listNodePools']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Retrieves the node pool requested.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\NodePool
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getNodePool($projectId, $zone, $clusterId, $nodePoolId, $optionalArgs = [])
    {
        $request = new GetNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        $defaultCallSettings = $this->defaultCallSettings['getNodePool'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'GetNodePool',
            $mergedSettings,
            $this->descriptors['getNodePool']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a node pool for a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createNodePool($projectId, $zone, $clusterId, $nodePool, $optionalArgs = [])
    {
        $request = new CreateNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePool($nodePool);

        $defaultCallSettings = $this->defaultCallSettings['createNodePool'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'CreateNodePool',
            $mergedSettings,
            $this->descriptors['createNodePool']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a node pool from a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteNodePool($projectId, $zone, $clusterId, $nodePoolId, $optionalArgs = [])
    {
        $request = new DeleteNodePoolRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        $defaultCallSettings = $this->defaultCallSettings['deleteNodePool'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'DeleteNodePool',
            $mergedSettings,
            $this->descriptors['deleteNodePool']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Roll back the previously Aborted or Failed NodePool upgrade.
     * This will be an no-op if the last upgrade successfully completed.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function rollbackNodePoolUpgrade($projectId, $zone, $clusterId, $nodePoolId, $optionalArgs = [])
    {
        $request = new RollbackNodePoolUpgradeRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);

        $defaultCallSettings = $this->defaultCallSettings['rollbackNodePoolUpgrade'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'RollbackNodePoolUpgrade',
            $mergedSettings,
            $this->descriptors['rollbackNodePoolUpgrade']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the NodeManagement options for a node pool.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolManagement($projectId, $zone, $clusterId, $nodePoolId, $management, $optionalArgs = [])
    {
        $request = new SetNodePoolManagementRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setManagement($management);

        $defaultCallSettings = $this->defaultCallSettings['setNodePoolManagement'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetNodePoolManagement',
            $mergedSettings,
            $this->descriptors['setNodePoolManagement']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets labels on a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setLabels($projectId, $zone, $clusterId, $resourceLabels, $labelFingerprint, $optionalArgs = [])
    {
        $request = new SetLabelsRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setResourceLabels($resourceLabels);
        $request->setLabelFingerprint($labelFingerprint);

        $defaultCallSettings = $this->defaultCallSettings['setLabels'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetLabels',
            $mergedSettings,
            $this->descriptors['setLabels']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Enables or disables the ABAC authorization mechanism on a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setLegacyAbac($projectId, $zone, $clusterId, $enabled, $optionalArgs = [])
    {
        $request = new SetLegacyAbacRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setEnabled($enabled);

        $defaultCallSettings = $this->defaultCallSettings['setLegacyAbac'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetLegacyAbac',
            $mergedSettings,
            $this->descriptors['setLegacyAbac']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Start master IP rotation.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function startIPRotation($projectId, $zone, $clusterId, $optionalArgs = [])
    {
        $request = new StartIPRotationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        $defaultCallSettings = $this->defaultCallSettings['startIPRotation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'StartIPRotation',
            $mergedSettings,
            $this->descriptors['startIPRotation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Completes master IP rotation.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function completeIPRotation($projectId, $zone, $clusterId, $optionalArgs = [])
    {
        $request = new CompleteIPRotationRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);

        $defaultCallSettings = $this->defaultCallSettings['completeIPRotation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'CompleteIPRotation',
            $mergedSettings,
            $this->descriptors['completeIPRotation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the size of a specific node pool.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolSize($projectId, $zone, $clusterId, $nodePoolId, $nodeCount, $optionalArgs = [])
    {
        $request = new SetNodePoolSizeRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNodePoolId($nodePoolId);
        $request->setNodeCount($nodeCount);

        $defaultCallSettings = $this->defaultCallSettings['setNodePoolSize'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetNodePoolSize',
            $mergedSettings,
            $this->descriptors['setNodePoolSize']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Enables/Disables Network Policy for a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setNetworkPolicy($projectId, $zone, $clusterId, $networkPolicy, $optionalArgs = [])
    {
        $request = new SetNetworkPolicyRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setNetworkPolicy($networkPolicy);

        $defaultCallSettings = $this->defaultCallSettings['setNetworkPolicy'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetNetworkPolicy',
            $mergedSettings,
            $this->descriptors['setNetworkPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the maintenance policy for a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $clusterManagerClient = new ClusterManagerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy, $optionalArgs = [])
    {
        $request = new SetMaintenancePolicyRequest();
        $request->setProjectId($projectId);
        $request->setZone($zone);
        $request->setClusterId($clusterId);
        $request->setMaintenancePolicy($maintenancePolicy);

        $defaultCallSettings = $this->defaultCallSettings['setMaintenancePolicy'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->clusterManagerStub,
            'SetMaintenancePolicy',
            $mergedSettings,
            $this->descriptors['setMaintenancePolicy']
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
        $this->clusterManagerStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
