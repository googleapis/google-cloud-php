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
 * https://github.com/google/googleapis/blob/master/google/container/v1beta1/cluster_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Container\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Container\V1beta1\AddonsConfig;
use Google\Cloud\Container\V1beta1\CancelOperationRequest;
use Google\Cloud\Container\V1beta1\Cluster;
use Google\Cloud\Container\V1beta1\ClusterUpdate;
use Google\Cloud\Container\V1beta1\CompleteIPRotationRequest;
use Google\Cloud\Container\V1beta1\CreateClusterRequest;
use Google\Cloud\Container\V1beta1\CreateNodePoolRequest;
use Google\Cloud\Container\V1beta1\DeleteClusterRequest;
use Google\Cloud\Container\V1beta1\DeleteNodePoolRequest;
use Google\Cloud\Container\V1beta1\GetClusterRequest;
use Google\Cloud\Container\V1beta1\GetNodePoolRequest;
use Google\Cloud\Container\V1beta1\GetOperationRequest;
use Google\Cloud\Container\V1beta1\GetServerConfigRequest;
use Google\Cloud\Container\V1beta1\ListClustersRequest;
use Google\Cloud\Container\V1beta1\ListClustersResponse;
use Google\Cloud\Container\V1beta1\ListLocationsRequest;
use Google\Cloud\Container\V1beta1\ListLocationsResponse;
use Google\Cloud\Container\V1beta1\ListNodePoolsRequest;
use Google\Cloud\Container\V1beta1\ListNodePoolsResponse;
use Google\Cloud\Container\V1beta1\ListOperationsRequest;
use Google\Cloud\Container\V1beta1\ListOperationsResponse;
use Google\Cloud\Container\V1beta1\ListUsableSubnetworksRequest;
use Google\Cloud\Container\V1beta1\ListUsableSubnetworksResponse;
use Google\Cloud\Container\V1beta1\MaintenancePolicy;
use Google\Cloud\Container\V1beta1\MasterAuth;
use Google\Cloud\Container\V1beta1\NetworkPolicy;
use Google\Cloud\Container\V1beta1\NodeManagement;
use Google\Cloud\Container\V1beta1\NodePool;
use Google\Cloud\Container\V1beta1\NodePoolAutoscaling;
use Google\Cloud\Container\V1beta1\Operation;
use Google\Cloud\Container\V1beta1\RollbackNodePoolUpgradeRequest;
use Google\Cloud\Container\V1beta1\ServerConfig;
use Google\Cloud\Container\V1beta1\SetAddonsConfigRequest;
use Google\Cloud\Container\V1beta1\SetLabelsRequest;
use Google\Cloud\Container\V1beta1\SetLegacyAbacRequest;
use Google\Cloud\Container\V1beta1\SetLocationsRequest;
use Google\Cloud\Container\V1beta1\SetLoggingServiceRequest;
use Google\Cloud\Container\V1beta1\SetMaintenancePolicyRequest;
use Google\Cloud\Container\V1beta1\SetMasterAuthRequest;
use Google\Cloud\Container\V1beta1\SetMasterAuthRequest_Action;
use Google\Cloud\Container\V1beta1\SetMonitoringServiceRequest;
use Google\Cloud\Container\V1beta1\SetNetworkPolicyRequest;
use Google\Cloud\Container\V1beta1\SetNodePoolAutoscalingRequest;
use Google\Cloud\Container\V1beta1\SetNodePoolManagementRequest;
use Google\Cloud\Container\V1beta1\SetNodePoolSizeRequest;
use Google\Cloud\Container\V1beta1\StartIPRotationRequest;
use Google\Cloud\Container\V1beta1\UpdateClusterRequest;
use Google\Cloud\Container\V1beta1\UpdateMasterRequest;
use Google\Cloud\Container\V1beta1\UpdateNodePoolRequest;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Google Kubernetes Engine Cluster Manager v1beta1.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $clusterManagerClient = new ClusterManagerClient();
 * try {
 *     $formattedParent = $clusterManagerClient->locationName('[PROJECT]', '[LOCATION]');
 *     $response = $clusterManagerClient->listClusters($formattedParent);
 * } finally {
 *     $clusterManagerClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class ClusterManagerGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.container.v1beta1.ClusterManager';

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
    private static $projectNameTemplate;
    private static $locationNameTemplate;
    private static $clusterNameTemplate;
    private static $nodePoolNameTemplate;
    private static $operationNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/cluster_manager_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/cluster_manager_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/cluster_manager_grpc_config.json',
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

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (self::$locationNameTemplate == null) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getClusterNameTemplate()
    {
        if (self::$clusterNameTemplate == null) {
            self::$clusterNameTemplate = new PathTemplate('projects/{project}/locations/{location}/clusters/{cluster}');
        }

        return self::$clusterNameTemplate;
    }

    private static function getNodePoolNameTemplate()
    {
        if (self::$nodePoolNameTemplate == null) {
            self::$nodePoolNameTemplate = new PathTemplate('projects/{project}/locations/{location}/clusters/{cluster}/nodePools/{node_pool}');
        }

        return self::$nodePoolNameTemplate;
    }

    private static function getOperationNameTemplate()
    {
        if (self::$operationNameTemplate == null) {
            self::$operationNameTemplate = new PathTemplate('projects/{project}/locations/{location}/operations/{operation}');
        }

        return self::$operationNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'cluster' => self::getClusterNameTemplate(),
                'nodePool' => self::getNodePoolNameTemplate(),
                'operation' => self::getOperationNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $project
     * @param string $location
     *
     * @return string The formatted location resource.
     * @experimental
     */
    public static function locationName($project, $location)
    {
        return self::getLocationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a cluster resource.
     *
     * @param string $project
     * @param string $location
     * @param string $cluster
     *
     * @return string The formatted cluster resource.
     * @experimental
     */
    public static function clusterName($project, $location, $cluster)
    {
        return self::getClusterNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'cluster' => $cluster,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a node_pool resource.
     *
     * @param string $project
     * @param string $location
     * @param string $cluster
     * @param string $nodePool
     *
     * @return string The formatted node_pool resource.
     * @experimental
     */
    public static function nodePoolName($project, $location, $cluster, $nodePool)
    {
        return self::getNodePoolNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'cluster' => $cluster,
            'node_pool' => $nodePool,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a operation resource.
     *
     * @param string $project
     * @param string $location
     * @param string $operation
     *
     * @return string The formatted operation resource.
     * @experimental
     */
    public static function operationName($project, $location, $operation)
    {
        return self::getOperationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'operation' => $operation,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - location: projects/{project}/locations/{location}
     * - cluster: projects/{project}/locations/{location}/clusters/{cluster}
     * - nodePool: projects/{project}/locations/{location}/clusters/{cluster}/nodePools/{node_pool}
     * - operation: projects/{project}/locations/{location}/operations/{operation}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
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
     *     $formattedParent = $clusterManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $clusterManagerClient->listClusters($formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent (project and location) where the clusters will be listed.
     *                             Specified in the format 'projects/&#42;/locations/*'.
     *                             Location "-" matches all zones and all regions.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides, or "-" for all zones.
     *          This field has been deprecated and replaced by the parent field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\ListClustersResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($parent, array $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }

        return $this->startCall(
            'ListClusters',
            ListClustersResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the details for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->getCluster($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster) of the cluster to retrieve.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to retrieve.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Cluster
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($name, array $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $cluster = new Cluster();
     *     $formattedParent = $clusterManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $clusterManagerClient->createCluster($cluster, $formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param Cluster $cluster      A [cluster
     *                              resource](https://cloud.google.com/container-engine/reference/rest/v1beta1/projects.zones.clusters)
     * @param string  $parent       The parent (project and location) where the cluster will be created.
     *                              Specified in the format 'projects/&#42;/locations/*'.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the parent field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($cluster, $parent, array $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setCluster($cluster);
        $request->setParent($parent);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }

        return $this->startCall(
            'CreateCluster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the settings for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $update = new ClusterUpdate();
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->updateCluster($update, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param ClusterUpdate $update       A description of the update.
     * @param string        $name         The name (project, location, cluster) of the cluster to update.
     *                                    Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array         $optionalArgs {
     *                                    Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCluster($update, $name, array $optionalArgs = [])
    {
        $request = new UpdateClusterRequest();
        $request->setUpdate($update);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $nodeVersion = '';
     *     $imageType = '';
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->updateNodePool($nodeVersion, $imageType, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $nodeVersion The Kubernetes version to change the nodes to (typically an
     *                            upgrade).
     *
     * Users may specify either explicit versions offered by Kubernetes Engine or
     * version aliases, which have the following behavior:
     *
     * - "latest": picks the highest valid Kubernetes version
     * - "1.X": picks the highest valid patch+gke.N patch in the 1.X version
     * - "1.X.Y": picks the highest valid gke.N patch in the 1.X.Y version
     * - "1.X.Y-gke.N": picks an explicit Kubernetes version
     * - "-": picks the Kubernetes master version
     * @param string $imageType    The desired image type for the node pool.
     * @param string $name         The name (project, location, cluster, node pool) of the node pool to
     *                             update. Specified in the format
     *                             'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateNodePool($nodeVersion, $imageType, $name, array $optionalArgs = [])
    {
        $request = new UpdateNodePoolRequest();
        $request->setNodeVersion($nodeVersion);
        $request->setImageType($imageType);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $autoscaling = new NodePoolAutoscaling();
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->setNodePoolAutoscaling($autoscaling, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param NodePoolAutoscaling $autoscaling  Autoscaling configuration for the node pool.
     * @param string              $name         The name (project, location, cluster, node pool) of the node pool to set
     *                                          autoscaler settings. Specified in the format
     *                                          'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array               $optionalArgs {
     *                                          Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolAutoscaling($autoscaling, $name, array $optionalArgs = [])
    {
        $request = new SetNodePoolAutoscalingRequest();
        $request->setAutoscaling($autoscaling);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

        return $this->startCall(
            'SetNodePoolAutoscaling',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the logging service for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $loggingService = '';
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setLoggingService($loggingService, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $loggingService The logging service the cluster should use to write metrics.
     *                               Currently available options:
     *
     * * "logging.googleapis.com" - the Google Cloud Logging service
     * * "none" - no metrics will be exported from the cluster
     * @param string $name         The name (project, location, cluster) of the cluster to set logging.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLoggingService($loggingService, $name, array $optionalArgs = [])
    {
        $request = new SetLoggingServiceRequest();
        $request->setLoggingService($loggingService);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'SetLoggingService',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the monitoring service for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $monitoringService = '';
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setMonitoringService($monitoringService, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $monitoringService The monitoring service the cluster should use to write metrics.
     *                                  Currently available options:
     *
     * * "monitoring.googleapis.com" - the Google Cloud Monitoring service
     * * "none" - no metrics will be exported from the cluster
     * @param string $name         The name (project, location, cluster) of the cluster to set monitoring.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMonitoringService($monitoringService, $name, array $optionalArgs = [])
    {
        $request = new SetMonitoringServiceRequest();
        $request->setMonitoringService($monitoringService);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'SetMonitoringService',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the addons for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $addonsConfig = new AddonsConfig();
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setAddonsConfig($addonsConfig, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param AddonsConfig $addonsConfig The desired configurations for the various addons available to run in the
     *                                   cluster.
     * @param string       $name         The name (project, location, cluster) of the cluster to set addons.
     *                                   Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setAddonsConfig($addonsConfig, $name, array $optionalArgs = [])
    {
        $request = new SetAddonsConfigRequest();
        $request->setAddonsConfig($addonsConfig);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'SetAddonsConfig',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the locations for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $locations = [];
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setLocations($locations, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string[] $locations The desired list of Google Compute Engine
     *                            [locations](https://cloud.google.com/compute/docs/zones#available) in which the cluster's nodes
     *                            should be located. Changing the locations a cluster is in will result
     *                            in nodes being either created or removed from the cluster, depending on
     *                            whether locations are being added or removed.
     *
     * This list must always include the cluster's primary zone.
     * @param string $name         The name (project, location, cluster) of the cluster to set locations.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLocations($locations, $name, array $optionalArgs = [])
    {
        $request = new SetLocationsRequest();
        $request->setLocations($locations);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'SetLocations',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the master for a specific cluster.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $masterVersion = '';
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->updateMaster($masterVersion, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $masterVersion The Kubernetes version to change the master to.
     *
     * Users may specify either explicit versions offered by
     * Kubernetes Engine or version aliases, which have the following behavior:
     *
     * - "latest": picks the highest valid Kubernetes version
     * - "1.X": picks the highest valid patch+gke.N patch in the 1.X version
     * - "1.X.Y": picks the highest valid gke.N patch in the 1.X.Y version
     * - "1.X.Y-gke.N": picks an explicit Kubernetes version
     * - "-": picks the default Kubernetes version
     * @param string $name         The name (project, location, cluster) of the cluster to update.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateMaster($masterVersion, $name, array $optionalArgs = [])
    {
        $request = new UpdateMasterRequest();
        $request->setMasterVersion($masterVersion);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'UpdateMaster',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Used to set master auth materials. Currently supports :-
     * Changing the admin password for a specific cluster.
     * This can be either via password generation or explicitly set.
     * Modify basic_auth.csv and reset the K8S API server.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $action = SetMasterAuthRequest_Action::UNKNOWN;
     *     $update = new MasterAuth();
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setMasterAuth($action, $update, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param int        $action       The exact form of action to be taken on the master auth.
     *                                 For allowed values, use constants defined on {@see \Google\Cloud\Container\V1beta1\SetMasterAuthRequest_Action}
     * @param MasterAuth $update       A description of the update.
     * @param string     $name         The name (project, location, cluster) of the cluster to set auth.
     *                                 Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to upgrade.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMasterAuth($action, $update, $name, array $optionalArgs = [])
    {
        $request = new SetMasterAuthRequest();
        $request->setAction($action);
        $request->setUpdate($update);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->deleteCluster($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster) of the cluster to delete.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to delete.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($name, array $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedParent = $clusterManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $clusterManagerClient->listOperations($formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent (project and location) where the operations will be listed.
     *                             Specified in the format 'projects/&#42;/locations/*'.
     *                             Location "-" matches all zones and all regions.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) to return operations for, or `-` for
     *          all zones. This field has been deprecated and replaced by the parent field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\ListOperationsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listOperations($parent, array $optionalArgs = [])
    {
        $request = new ListOperationsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }

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
     *     $formattedName = $clusterManagerClient->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');
     *     $response = $clusterManagerClient->getOperation($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, operation id) of the operation to get.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/operations/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $operationId
     *          Deprecated. The server-assigned `name` of the operation.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getOperation($name, array $optionalArgs = [])
    {
        $request = new GetOperationRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['operationId'])) {
            $request->setOperationId($optionalArgs['operationId']);
        }

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
     *     $formattedName = $clusterManagerClient->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');
     *     $clusterManagerClient->cancelOperation($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, operation id) of the operation to cancel.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/operations/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the operation resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $operationId
     *          Deprecated. The server-assigned `name` of the operation.
     *          This field has been deprecated and replaced by the name field.
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
    public function cancelOperation($name, array $optionalArgs = [])
    {
        $request = new CancelOperationRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['operationId'])) {
            $request->setOperationId($optionalArgs['operationId']);
        }

        return $this->startCall(
            'CancelOperation',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns configuration info about the Kubernetes Engine service.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $formattedName = $clusterManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $clusterManagerClient->getServerConfig($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project and location) of the server config to get
     *                             Specified in the format 'projects/&#42;/locations/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) to return operations for.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\ServerConfig
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getServerConfig($name, array $optionalArgs = [])
    {
        $request = new GetServerConfigRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }

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
     *     $formattedParent = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->listNodePools($formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent (project, location, cluster id) where the node pools will be
     *                             listed. Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the parent field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\ListNodePoolsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listNodePools($parent, array $optionalArgs = [])
    {
        $request = new ListNodePoolsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->getNodePool($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster, node pool id) of the node pool to
     *                             get. Specified in the format
     *                             'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\NodePool
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getNodePool($name, array $optionalArgs = [])
    {
        $request = new GetNodePoolRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $nodePool = new NodePool();
     *     $formattedParent = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->createNodePool($nodePool, $formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param NodePool $nodePool     The node pool to create.
     * @param string   $parent       The parent (project, location, cluster id) where the node pool will be
     *                               created. Specified in the format
     *                               'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the parent field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the parent field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createNodePool($nodePool, $parent, array $optionalArgs = [])
    {
        $request = new CreateNodePoolRequest();
        $request->setNodePool($nodePool);
        $request->setParent($parent);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->deleteNodePool($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster, node pool id) of the node pool to
     *                             delete. Specified in the format
     *                             'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to delete.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteNodePool($name, array $optionalArgs = [])
    {
        $request = new DeleteNodePoolRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->rollbackNodePoolUpgrade($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster, node pool id) of the node poll to
     *                             rollback upgrade.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to rollback.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to rollback.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function rollbackNodePoolUpgrade($name, array $optionalArgs = [])
    {
        $request = new RollbackNodePoolUpgradeRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $management = new NodeManagement();
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->setNodePoolManagement($management, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param NodeManagement $management   NodeManagement configuration for the node pool.
     * @param string         $name         The name (project, location, cluster, node pool id) of the node pool to set
     *                                     management properties. Specified in the format
     *                                     'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array          $optionalArgs {
     *                                     Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to update.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to update.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolManagement($management, $name, array $optionalArgs = [])
    {
        $request = new SetNodePoolManagementRequest();
        $request->setManagement($management);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $resourceLabels = [];
     *     $labelFingerprint = '';
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setLabels($resourceLabels, $labelFingerprint, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param array  $resourceLabels   The labels to set for that cluster.
     * @param string $labelFingerprint The fingerprint of the previous set of labels for this resource,
     *                                 used to detect conflicts. The fingerprint is initially generated by
     *                                 Kubernetes Engine and changes after every request to modify or update
     *                                 labels. You must always provide an up-to-date fingerprint hash when
     *                                 updating or changing labels. Make a <code>get()</code> request to the
     *                                 resource to get the latest fingerprint.
     * @param string $name             The name (project, location, cluster id) of the cluster to set labels.
     *                                 Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs     {
     *                                 Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLabels($resourceLabels, $labelFingerprint, $name, array $optionalArgs = [])
    {
        $request = new SetLabelsRequest();
        $request->setResourceLabels($resourceLabels);
        $request->setLabelFingerprint($labelFingerprint);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $enabled = false;
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setLegacyAbac($enabled, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param bool   $enabled      Whether ABAC authorization will be enabled in the cluster.
     * @param string $name         The name (project, location, cluster id) of the cluster to set legacy abac.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to update.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setLegacyAbac($enabled, $name, array $optionalArgs = [])
    {
        $request = new SetLegacyAbacRequest();
        $request->setEnabled($enabled);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $rotateCredentials = false;
     *     $response = $clusterManagerClient->startIPRotation($formattedName, $rotateCredentials);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name              The name (project, location, cluster id) of the cluster to start IP
     *                                  rotation. Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param bool   $rotateCredentials Whether to rotate credentials during IP rotation.
     * @param array  $optionalArgs      {
     *                                  Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function startIPRotation($name, $rotateCredentials, array $optionalArgs = [])
    {
        $request = new StartIPRotationRequest();
        $request->setName($name);
        $request->setRotateCredentials($rotateCredentials);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->completeIPRotation($formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name (project, location, cluster id) of the cluster to complete IP
     *                             rotation. Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function completeIPRotation($name, array $optionalArgs = [])
    {
        $request = new CompleteIPRotationRequest();
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'CompleteIPRotation',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the size for a specific node pool.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $nodeCount = 0;
     *     $formattedName = $clusterManagerClient->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');
     *     $response = $clusterManagerClient->setNodePoolSize($nodeCount, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param int    $nodeCount    The desired node count for the pool.
     * @param string $name         The name (project, location, cluster, node pool id) of the node pool to set
     *                             size.
     *                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*'.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster to update.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $nodePoolId
     *          Deprecated. The name of the node pool to update.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNodePoolSize($nodeCount, $name, array $optionalArgs = [])
    {
        $request = new SetNodePoolSizeRequest();
        $request->setNodeCount($nodeCount);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }
        if (isset($optionalArgs['nodePoolId'])) {
            $request->setNodePoolId($optionalArgs['nodePoolId']);
        }

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
     *     $networkPolicy = new NetworkPolicy();
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setNetworkPolicy($networkPolicy, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param NetworkPolicy $networkPolicy Configuration options for the NetworkPolicy feature.
     * @param string        $name          The name (project, location, cluster id) of the cluster to set networking
     *                                     policy. Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type string $projectId
     *          Deprecated. The Google Developers Console [project ID or project
     *          number](https://developers.google.com/console/help/new/#projectnumber).
     *          This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *          Deprecated. The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *          This field has been deprecated and replaced by the name field.
     *     @type string $clusterId
     *          Deprecated. The name of the cluster.
     *          This field has been deprecated and replaced by the name field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setNetworkPolicy($networkPolicy, $name, array $optionalArgs = [])
    {
        $request = new SetNetworkPolicyRequest();
        $request->setNetworkPolicy($networkPolicy);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

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
     *     $maintenancePolicy = new MaintenancePolicy();
     *     $formattedName = $clusterManagerClient->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
     *     $response = $clusterManagerClient->setMaintenancePolicy($maintenancePolicy, $formattedName);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param MaintenancePolicy $maintenancePolicy The maintenance policy to be set for the cluster. An empty field
     *                                             clears the existing maintenance policy.
     * @param string            $name              The name (project, location, cluster id) of the cluster to set maintenance
     *                                             policy.
     *                                             Specified in the format 'projects/&#42;/locations/&#42;/clusters/*'.
     * @param array             $optionalArgs      {
     *                                             Optional.
     *
     *     @type string $projectId
     *          The Google Developers Console [project ID or project
     *          number](https://support.google.com/cloud/answer/6158840).
     *     @type string $zone
     *          The name of the Google Compute Engine
     *          [zone](https://cloud.google.com/compute/docs/zones#available) in which the cluster
     *          resides.
     *     @type string $clusterId
     *          The name of the cluster to update.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Container\V1beta1\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setMaintenancePolicy($maintenancePolicy, $name, array $optionalArgs = [])
    {
        $request = new SetMaintenancePolicyRequest();
        $request->setMaintenancePolicy($maintenancePolicy);
        $request->setName($name);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }
        if (isset($optionalArgs['zone'])) {
            $request->setZone($optionalArgs['zone']);
        }
        if (isset($optionalArgs['clusterId'])) {
            $request->setClusterId($optionalArgs['clusterId']);
        }

        return $this->startCall(
            'SetMaintenancePolicy',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists subnetworks that are usable for creating clusters in a project.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $formattedParent = $clusterManagerClient->projectName('[PROJECT]');
     *     $filter = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $clusterManagerClient->listUsableSubnetworks($formattedParent, $filter);
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
     *     $pagedResponse = $clusterManagerClient->listUsableSubnetworks($formattedParent, $filter);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent project where subnetworks are usable.
     *                             Specified in the format 'projects/*'.
     * @param string $filter       Filtering currently only supports equality on the networkProjectId and must
     *                             be in the form: "networkProjectId=[PROJECTID]", where `networkProjectId`
     *                             is the project which owns the listed subnetworks. This defaults to the
     *                             parent project ID.
     * @param array  $optionalArgs {
     *                             Optional.
     *
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
    public function listUsableSubnetworks($parent, $filter, array $optionalArgs = [])
    {
        $request = new ListUsableSubnetworksRequest();
        $request->setParent($parent);
        $request->setFilter($filter);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListUsableSubnetworks',
            $optionalArgs,
            ListUsableSubnetworksResponse::class,
            $request
        );
    }

    /**
     * Used to fetch locations that offer GKE.
     *
     * Sample code:
     * ```
     * $clusterManagerClient = new ClusterManagerClient();
     * try {
     *     $formattedParent = $clusterManagerClient->projectName('[PROJECT]');
     *     $response = $clusterManagerClient->listLocations($formattedParent);
     * } finally {
     *     $clusterManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       Contains the name of the resource requested.
     *                             Specified in the format 'projects/*'.
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
     * @return \Google\Cloud\Container\V1beta1\ListLocationsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listLocations($parent, array $optionalArgs = [])
    {
        $request = new ListLocationsRequest();
        $request->setParent($parent);

        return $this->startCall(
            'ListLocations',
            ListLocationsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
