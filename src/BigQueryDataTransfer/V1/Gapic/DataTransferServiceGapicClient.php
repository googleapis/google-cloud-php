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
 * https://github.com/google/googleapis/blob/master/google/cloud/bigquery/datatransfer/v1/datatransfer.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\BigQuery\DataTransfer\V1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\CreateTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceGrpcClient;
use Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferRunRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetDataSourceRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetTransferRunRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest_RunAttempt as RunAttempt;
use Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig;
use Google\Cloud\BigQuery\DataTransfer\V1\UpdateTransferConfigRequest;
use Google\Cloud\Version;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;

/**
 * Service Description: The Google BigQuery Data Transfer Service API enables BigQuery users to
 * configure the transfer of their data from other Google Products into BigQuery.
 * This service contains methods that are end user exposed. It backs up the
 * frontend.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $dataTransferServiceClient = new DataTransferServiceClient();
 *     $formattedName = $dataTransferServiceClient->locationDataSourceName('[PROJECT]', '[LOCATION]', '[DATA_SOURCE]');
 *     $response = $dataTransferServiceClient->getDataSource($formattedName);
 * } finally {
 *     $dataTransferServiceClient->close();
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
class DataTransferServiceGapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'bigquerydatatransfer.googleapis.com';

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

    private static $projectNameTemplate;
    private static $locationNameTemplate;
    private static $locationDataSourceNameTemplate;
    private static $locationTransferConfigNameTemplate;
    private static $locationRunNameTemplate;
    private static $dataSourceNameTemplate;
    private static $transferConfigNameTemplate;
    private static $runNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $dataTransferServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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

    private static function getLocationDataSourceNameTemplate()
    {
        if (self::$locationDataSourceNameTemplate == null) {
            self::$locationDataSourceNameTemplate = new PathTemplate('projects/{project}/locations/{location}/dataSources/{data_source}');
        }

        return self::$locationDataSourceNameTemplate;
    }

    private static function getLocationTransferConfigNameTemplate()
    {
        if (self::$locationTransferConfigNameTemplate == null) {
            self::$locationTransferConfigNameTemplate = new PathTemplate('projects/{project}/locations/{location}/transferConfigs/{transfer_config}');
        }

        return self::$locationTransferConfigNameTemplate;
    }

    private static function getLocationRunNameTemplate()
    {
        if (self::$locationRunNameTemplate == null) {
            self::$locationRunNameTemplate = new PathTemplate('projects/{project}/locations/{location}/transferConfigs/{transfer_config}/runs/{run}');
        }

        return self::$locationRunNameTemplate;
    }

    private static function getDataSourceNameTemplate()
    {
        if (self::$dataSourceNameTemplate == null) {
            self::$dataSourceNameTemplate = new PathTemplate('projects/{project}/dataSources/{data_source}');
        }

        return self::$dataSourceNameTemplate;
    }

    private static function getTransferConfigNameTemplate()
    {
        if (self::$transferConfigNameTemplate == null) {
            self::$transferConfigNameTemplate = new PathTemplate('projects/{project}/transferConfigs/{transfer_config}');
        }

        return self::$transferConfigNameTemplate;
    }

    private static function getRunNameTemplate()
    {
        if (self::$runNameTemplate == null) {
            self::$runNameTemplate = new PathTemplate('projects/{project}/transferConfigs/{transfer_config}/runs/{run}');
        }

        return self::$runNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'locationDataSource' => self::getLocationDataSourceNameTemplate(),
                'locationTransferConfig' => self::getLocationTransferConfigNameTemplate(),
                'locationRun' => self::getLocationRunNameTemplate(),
                'dataSource' => self::getDataSourceNameTemplate(),
                'transferConfig' => self::getTransferConfigNameTemplate(),
                'run' => self::getRunNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getPageStreamingDescriptors()
    {
        $listDataSourcesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDataSources',
                ]);
        $listTransferConfigsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTransferConfigs',
                ]);
        $listTransferRunsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTransferRuns',
                ]);
        $listTransferLogsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTransferMessages',
                ]);

        $pageStreamingDescriptors = [
            'listDataSources' => $listDataSourcesPageStreamingDescriptor,
            'listTransferConfigs' => $listTransferConfigsPageStreamingDescriptor,
            'listTransferRuns' => $listTransferRunsPageStreamingDescriptor,
            'listTransferLogs' => $listTransferLogsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
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
     * a location_data_source resource.
     *
     * @param string $project
     * @param string $location
     * @param string $dataSource
     *
     * @return string The formatted location_data_source resource.
     * @experimental
     */
    public static function locationDataSourceName($project, $location, $dataSource)
    {
        return self::getLocationDataSourceNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'data_source' => $dataSource,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_transfer_config resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     *
     * @return string The formatted location_transfer_config resource.
     * @experimental
     */
    public static function locationTransferConfigName($project, $location, $transferConfig)
    {
        return self::getLocationTransferConfigNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'transfer_config' => $transferConfig,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_run resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted location_run resource.
     * @experimental
     */
    public static function locationRunName($project, $location, $transferConfig, $run)
    {
        return self::getLocationRunNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'transfer_config' => $transferConfig,
            'run' => $run,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a data_source resource.
     *
     * @param string $project
     * @param string $dataSource
     *
     * @return string The formatted data_source resource.
     * @experimental
     */
    public static function dataSourceName($project, $dataSource)
    {
        return self::getDataSourceNameTemplate()->render([
            'project' => $project,
            'data_source' => $dataSource,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a transfer_config resource.
     *
     * @param string $project
     * @param string $transferConfig
     *
     * @return string The formatted transfer_config resource.
     * @experimental
     */
    public static function transferConfigName($project, $transferConfig)
    {
        return self::getTransferConfigNameTemplate()->render([
            'project' => $project,
            'transfer_config' => $transferConfig,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a run resource.
     *
     * @param string $project
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted run resource.
     * @experimental
     */
    public static function runName($project, $transferConfig, $run)
    {
        return self::getRunNameTemplate()->render([
            'project' => $project,
            'transfer_config' => $transferConfig,
            'run' => $run,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - location: projects/{project}/locations/{location}
     * - locationDataSource: projects/{project}/locations/{location}/dataSources/{data_source}
     * - locationTransferConfig: projects/{project}/locations/{location}/transferConfigs/{transfer_config}
     * - locationRun: projects/{project}/locations/{location}/transferConfigs/{transfer_config}/runs/{run}
     * - dataSource: projects/{project}/dataSources/{data_source}
     * - transferConfig: projects/{project}/transferConfigs/{transfer_config}
     * - run: projects/{project}/transferConfigs/{transfer_config}/runs/{run}.
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'bigquerydatatransfer.googleapis.com'.
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
     *                          Defaults to the scopes for the BigQuery Data Transfer API.
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
                'https://www.googleapis.com/auth/bigquery',
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/cloud-platform.read-only',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/data_transfer_service_client_config.json',
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
            'getDataSource' => $defaultDescriptors,
            'listDataSources' => $defaultDescriptors,
            'createTransferConfig' => $defaultDescriptors,
            'updateTransferConfig' => $defaultDescriptors,
            'deleteTransferConfig' => $defaultDescriptors,
            'getTransferConfig' => $defaultDescriptors,
            'listTransferConfigs' => $defaultDescriptors,
            'scheduleTransferRuns' => $defaultDescriptors,
            'getTransferRun' => $defaultDescriptors,
            'deleteTransferRun' => $defaultDescriptors,
            'listTransferRuns' => $defaultDescriptors,
            'listTransferLogs' => $defaultDescriptors,
            'checkValidCreds' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.bigquery.datatransfer.v1.DataTransferService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createDataTransferServiceStubFunction = function ($hostname, $opts, $channel) {
            return new DataTransferServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createDataTransferServiceStubFunction', $options)) {
            $createDataTransferServiceStubFunction = $options['createDataTransferServiceStubFunction'];
        }
        $this->dataTransferServiceStub = $this->grpcCredentialsHelper->createStub($createDataTransferServiceStubFunction);
    }

    /**
     * Retrieves a supported data source and returns its settings,
     * which can be used for UI rendering.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationDataSourceName('[PROJECT]', '[LOCATION]', '[DATA_SOURCE]');
     *     $response = $dataTransferServiceClient->getDataSource($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The field will contain name of the resource requested, for example:
     *                             `projects/{project_id}/dataSources/{data_source_id}`
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
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\DataSource
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getDataSource($name, $optionalArgs = [])
    {
        $request = new GetDataSourceRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getDataSource'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'GetDataSource',
            $mergedSettings,
            $this->descriptors['getDataSource']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists supported data sources and returns their settings,
     * which can be used for UI rendering.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate through all elements
     *     $pagedResponse = $dataTransferServiceClient->listDataSources($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $dataTransferServiceClient->listDataSources($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       The BigQuery project id for which data sources should be returned.
     *                             Must be in the form: `projects/{project_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listDataSources($parent, $optionalArgs = [])
    {
        $request = new ListDataSourcesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listDataSources'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'ListDataSources',
            $mergedSettings,
            $this->descriptors['listDataSources']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new data transfer configuration.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $transferConfig = new TransferConfig();
     *     $response = $dataTransferServiceClient->createTransferConfig($formattedParent, $transferConfig);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string         $parent         The BigQuery project id where the transfer configuration should be created.
     *                                       Must be in the format /projects/{project_id}/locations/{location_id}
     *                                       or
     *                                       /projects/{project_id}/locations/-
     *                                       In case when '-' is specified as location_id, location is infered from
     *                                       the destination dataset region.
     * @param TransferConfig $transferConfig Data transfer configuration to create.
     * @param array          $optionalArgs   {
     *                                       Optional.
     *
     *     @type string $authorizationCode
     *          Optional OAuth2 authorization code to use with this transfer configuration.
     *          This is required if new credentials are needed, as indicated by
     *          `CheckValidCreds`.
     *          In order to obtain authorization_code, please make a
     *          request to
     *          https://www.gstatic.com/bigquerydatatransfer/oauthz/auth?client_id=<datatransferapiclientid>&scope=<data_source_scopes>&redirect_uri=<redirect_uri>
     *
     *          * client_id should be OAuth client_id of BigQuery DTS API for the given
     *            data source returned by ListDataSources method.
     *          * data_source_scopes are the scopes returned by ListDataSources method.
     *          * redirect_uri is an optional parameter. If not specified, then
     *            authorization code is posted to the opener of authorization flow window.
     *            Otherwise it will be sent to the redirect uri. A special value of
     *            urn:ietf:wg:oauth:2.0:oob means that authorization code should be
     *            returned in the title bar of the browser, with the page text prompting
     *            the user to copy the code and paste it in the application.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createTransferConfig($parent, $transferConfig, $optionalArgs = [])
    {
        $request = new CreateTransferConfigRequest();
        $request->setParent($parent);
        $request->setTransferConfig($transferConfig);
        if (isset($optionalArgs['authorizationCode'])) {
            $request->setAuthorizationCode($optionalArgs['authorizationCode']);
        }

        $defaultCallSettings = $this->defaultCallSettings['createTransferConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'CreateTransferConfig',
            $mergedSettings,
            $this->descriptors['createTransferConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates a data transfer configuration.
     * All fields must be set, even if they are not updated.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $transferConfig = new TransferConfig();
     *     $updateMask = new FieldMask();
     *     $response = $dataTransferServiceClient->updateTransferConfig($transferConfig, $updateMask);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param TransferConfig $transferConfig Data transfer configuration to create.
     * @param FieldMask      $updateMask     Required list of fields to be updated in this request.
     * @param array          $optionalArgs   {
     *                                       Optional.
     *
     *     @type string $authorizationCode
     *          Optional OAuth2 authorization code to use with this transfer configuration.
     *          If it is provided, the transfer configuration will be associated with the
     *          authorizing user.
     *          In order to obtain authorization_code, please make a
     *          request to
     *          https://www.gstatic.com/bigquerydatatransfer/oauthz/auth?client_id=<datatransferapiclientid>&scope=<data_source_scopes>&redirect_uri=<redirect_uri>
     *
     *          * client_id should be OAuth client_id of BigQuery DTS API for the given
     *            data source returned by ListDataSources method.
     *          * data_source_scopes are the scopes returned by ListDataSources method.
     *          * redirect_uri is an optional parameter. If not specified, then
     *            authorization code is posted to the opener of authorization flow window.
     *            Otherwise it will be sent to the redirect uri. A special value of
     *            urn:ietf:wg:oauth:2.0:oob means that authorization code should be
     *            returned in the title bar of the browser, with the page text prompting
     *            the user to copy the code and paste it in the application.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateTransferConfig($transferConfig, $updateMask, $optionalArgs = [])
    {
        $request = new UpdateTransferConfigRequest();
        $request->setTransferConfig($transferConfig);
        $request->setUpdateMask($updateMask);
        if (isset($optionalArgs['authorizationCode'])) {
            $request->setAuthorizationCode($optionalArgs['authorizationCode']);
        }

        $defaultCallSettings = $this->defaultCallSettings['updateTransferConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'UpdateTransferConfig',
            $mergedSettings,
            $this->descriptors['updateTransferConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a data transfer configuration,
     * including any associated transfer runs and logs.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationTransferConfigName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]');
     *     $dataTransferServiceClient->deleteTransferConfig($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The field will contain name of the resource requested, for example:
     *                             `projects/{project_id}/transferConfigs/{config_id}`
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
    public function deleteTransferConfig($name, $optionalArgs = [])
    {
        $request = new DeleteTransferConfigRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteTransferConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'DeleteTransferConfig',
            $mergedSettings,
            $this->descriptors['deleteTransferConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns information about a data transfer config.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationTransferConfigName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]');
     *     $response = $dataTransferServiceClient->getTransferConfig($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The field will contain name of the resource requested, for example:
     *                             `projects/{project_id}/transferConfigs/{config_id}`
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
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getTransferConfig($name, $optionalArgs = [])
    {
        $request = new GetTransferConfigRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getTransferConfig'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'GetTransferConfig',
            $mergedSettings,
            $this->descriptors['getTransferConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns information about all data transfers in the project.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate through all elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferConfigs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferConfigs($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       The BigQuery project id for which data sources
     *                             should be returned: `projects/{project_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string[] $dataSourceIds
     *          When specified, only configurations of requested data sources are returned.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listTransferConfigs($parent, $optionalArgs = [])
    {
        $request = new ListTransferConfigsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['dataSourceIds'])) {
            $request->setDataSourceIds($optionalArgs['dataSourceIds']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listTransferConfigs'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'ListTransferConfigs',
            $mergedSettings,
            $this->descriptors['listTransferConfigs']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates transfer runs for a time range [range_start_time, range_end_time].
     * For each date - or whatever granularity the data source supports - in the
     * range, one transfer run is created.
     * Note that runs are created per UTC time in the time range.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationTransferConfigName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]');
     *     $startTime = new Timestamp();
     *     $endTime = new Timestamp();
     *     $response = $dataTransferServiceClient->scheduleTransferRuns($formattedParent, $startTime, $endTime);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string    $parent       Transfer configuration name in the form:
     *                                `projects/{project_id}/transferConfigs/{config_id}`.
     * @param Timestamp $startTime    Start time of the range of transfer runs. For example,
     *                                `"2017-05-25T00:00:00+00:00"`.
     * @param Timestamp $endTime      End time of the range of transfer runs. For example,
     *                                `"2017-05-30T00:00:00+00:00"`.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function scheduleTransferRuns($parent, $startTime, $endTime, $optionalArgs = [])
    {
        $request = new ScheduleTransferRunsRequest();
        $request->setParent($parent);
        $request->setStartTime($startTime);
        $request->setEndTime($endTime);

        $defaultCallSettings = $this->defaultCallSettings['scheduleTransferRuns'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'ScheduleTransferRuns',
            $mergedSettings,
            $this->descriptors['scheduleTransferRuns']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns information about the particular transfer run.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationRunName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]', '[RUN]');
     *     $response = $dataTransferServiceClient->getTransferRun($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The field will contain name of the resource requested, for example:
     *                             `projects/{project_id}/transferConfigs/{config_id}/runs/{run_id}`
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
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\TransferRun
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getTransferRun($name, $optionalArgs = [])
    {
        $request = new GetTransferRunRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getTransferRun'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'GetTransferRun',
            $mergedSettings,
            $this->descriptors['getTransferRun']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes the specified transfer run.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationRunName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]', '[RUN]');
     *     $dataTransferServiceClient->deleteTransferRun($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The field will contain name of the resource requested, for example:
     *                             `projects/{project_id}/transferConfigs/{config_id}/runs/{run_id}`
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
    public function deleteTransferRun($name, $optionalArgs = [])
    {
        $request = new DeleteTransferRunRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteTransferRun'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'DeleteTransferRun',
            $mergedSettings,
            $this->descriptors['deleteTransferRun']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns information about running and completed jobs.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationTransferConfigName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]');
     *     // Iterate through all elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferRuns($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferRuns($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Name of transfer configuration for which transfer runs should be retrieved.
     *                             Format of transfer configuration resource name is:
     *                             `projects/{project_id}/transferConfigs/{config_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int[] $states
     *          When specified, only transfer runs with requested states are returned.
     *          For allowed values, use constants defined on {@see \Google\Cloud\BigQuery\DataTransfer\V1\TransferState}
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $runAttempt
     *          Indicates how run attempts are to be pulled.
     *          For allowed values, use constants defined on {@see \Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest_RunAttempt}
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
    public function listTransferRuns($parent, $optionalArgs = [])
    {
        $request = new ListTransferRunsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['states'])) {
            $request->setStates($optionalArgs['states']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['runAttempt'])) {
            $request->setRunAttempt($optionalArgs['runAttempt']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listTransferRuns'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'ListTransferRuns',
            $mergedSettings,
            $this->descriptors['listTransferRuns']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns user facing log messages for the data transfer run.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedParent = $dataTransferServiceClient->locationRunName('[PROJECT]', '[LOCATION]', '[TRANSFER_CONFIG]', '[RUN]');
     *     // Iterate through all elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferLogs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $dataTransferServiceClient->listTransferLogs($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Transfer run name in the form:
     *                             `projects/{project_id}/transferConfigs/{config_Id}/runs/{run_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int[] $messageTypes
     *          Message types to return. If not populated - INFO, WARNING and ERROR
     *          messages are returned.
     *          For allowed values, use constants defined on {@see \Google\Cloud\BigQuery\DataTransfer\V1\TransferMessage_MessageSeverity}
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
    public function listTransferLogs($parent, $optionalArgs = [])
    {
        $request = new ListTransferLogsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['messageTypes'])) {
            $request->setMessageTypes($optionalArgs['messageTypes']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listTransferLogs'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'ListTransferLogs',
            $mergedSettings,
            $this->descriptors['listTransferLogs']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns true if valid credentials exist for the given data source and
     * requesting user.
     * Some data sources doesn't support service account, so we need to talk to
     * them on behalf of the end user. This API just checks whether we have OAuth
     * token for the particular user, which is a pre-requisite before user can
     * create a transfer config.
     *
     * Sample code:
     * ```
     * try {
     *     $dataTransferServiceClient = new DataTransferServiceClient();
     *     $formattedName = $dataTransferServiceClient->locationDataSourceName('[PROJECT]', '[LOCATION]', '[DATA_SOURCE]');
     *     $response = $dataTransferServiceClient->checkValidCreds($formattedName);
     * } finally {
     *     $dataTransferServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The data source in the form:
     *                             `projects/{project_id}/dataSources/{data_source_id}`
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
     * @return \Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function checkValidCreds($name, $optionalArgs = [])
    {
        $request = new CheckValidCredsRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['checkValidCreds'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dataTransferServiceStub,
            'CheckValidCreds',
            $mergedSettings,
            $this->descriptors['checkValidCreds']
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
        $this->dataTransferServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
