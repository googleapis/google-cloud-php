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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/uptime_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Monitoring\V3\Gapic;

use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\Transport\ApiTransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Monitoring\V3\CreateUptimeCheckConfigRequest;
use Google\Cloud\Monitoring\V3\DeleteUptimeCheckConfigRequest;
use Google\Cloud\Monitoring\V3\GetUptimeCheckConfigRequest;
use Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsRequest;
use Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsResponse;
use Google\Cloud\Monitoring\V3\ListUptimeCheckIpsRequest;
use Google\Cloud\Monitoring\V3\ListUptimeCheckIpsResponse;
use Google\Cloud\Monitoring\V3\UpdateUptimeCheckConfigRequest;
use Google\Cloud\Monitoring\V3\UptimeCheckConfig;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The UptimeCheckService API is used to manage (list, create, delete, edit)
 * uptime check configurations in the Stackdriver Monitoring product. An uptime
 * check is a piece of configuration that determines which resources and
 * services to monitor for availability. These configurations can also be
 * configured interactively by navigating to the [Cloud Console]
 * (http://console.cloud.google.com), selecting the appropriate project,
 * clicking on "Monitoring" on the left-hand side to navigate to Stackdriver,
 * and then clicking on "Uptime".
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
 *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
 *     $formattedParent = $uptimeCheckServiceClient->projectName('[PROJECT]');
 *     // Iterate through all elements
 *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckConfigs($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckConfigs($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $uptimeCheckServiceClient->close();
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
class UptimeCheckServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.monitoring.v3.UptimeCheckService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'monitoring.googleapis.com';

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
    private static $uptimeCheckConfigNameTemplate;
    private static $pathTemplateMap;
    private static $clientDefaults = [
        'serviceName' => self::SERVICE_NAME,
        'serviceAddress' => self::SERVICE_ADDRESS,
        'port' => self::DEFAULT_SERVICE_PORT,
        'scopes' => [
            'https://www.googleapis.com/auth/cloud-platform',
            'https://www.googleapis.com/auth/monitoring',
            'https://www.googleapis.com/auth/monitoring.read',
            'https://www.googleapis.com/auth/monitoring.write',
        ],
        'clientConfigPath' => __DIR__.'/../resources/uptime_check_service_client_config.json',
        'restClientConfigPath' => __DIR__.'/../resources/uptime_check_service_rest_client_config.php',
        'descriptorsConfigPath' => __DIR__.'/../resources/uptime_check_service_descriptor_config.php',
    ];

    private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getUptimeCheckConfigNameTemplate()
    {
        if (null == self::$uptimeCheckConfigNameTemplate) {
            self::$uptimeCheckConfigNameTemplate = new PathTemplate('projects/{project}/uptimeCheckConfigs/{uptime_check_config}');
        }

        return self::$uptimeCheckConfigNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'uptimeCheckConfig' => self::getUptimeCheckConfigNameTemplate(),
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
     * a uptime_check_config resource.
     *
     * @param string $project
     * @param string $uptimeCheckConfig
     *
     * @return string The formatted uptime_check_config resource.
     * @experimental
     */
    public static function uptimeCheckConfigName($project, $uptimeCheckConfig)
    {
        return self::getUptimeCheckConfigNameTemplate()->render([
            'project' => $project,
            'uptime_check_config' => $uptimeCheckConfig,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - uptimeCheckConfig: projects/{project}/uptimeCheckConfigs/{uptime_check_config}.
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
     *                                  Default 'monitoring.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type \Grpc\ChannelCredentials $sslCreds
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
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Stackdriver Monitoring API.
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
     *           `function (RequestInterface $request, array $options) : ResponseInterface`
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|ApiTransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $this->setClientOptions($options + self::$clientDefaults);
    }

    /**
     * Lists the existing valid uptime check configurations for the project,
     * leaving out any invalid configurations.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *     $formattedParent = $uptimeCheckServiceClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckConfigs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckConfigs($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param string $parent The project whose uptime check configurations are listed. The format is
     *
     *   `projects/[PROJECT_ID]`.
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listUptimeCheckConfigs($parent, $optionalArgs = [])
    {
        $request = new ListUptimeCheckConfigsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            new Call(
                self::SERVICE_NAME.'/ListUptimeCheckConfigs',
                ListUptimeCheckConfigsResponse::class,
                $request
            ),
            $this->configureCallSettings('listUptimeCheckConfigs', $optionalArgs),
            $this->descriptors['listUptimeCheckConfigs']['pageStreaming']
        );
    }

    /**
     * Gets a single uptime check configuration.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *     $formattedName = $uptimeCheckServiceClient->uptimeCheckConfigName('[PROJECT]', '[UPTIME_CHECK_CONFIG]');
     *     $response = $uptimeCheckServiceClient->getUptimeCheckConfig($formattedName);
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param string $name The uptime check configuration to retrieve. The format is
     *
     *   `projects/[PROJECT_ID]/uptimeCheckConfigs/[UPTIME_CHECK_ID]`.
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
     * @return \Google\Cloud\Monitoring\V3\UptimeCheckConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getUptimeCheckConfig($name, $optionalArgs = [])
    {
        $request = new GetUptimeCheckConfigRequest();
        $request->setName($name);

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/GetUptimeCheckConfig',
                UptimeCheckConfig::class,
                $request
            ),
            $this->configureCallSettings('getUptimeCheckConfig', $optionalArgs)
        )->wait();
    }

    /**
     * Creates a new uptime check configuration.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *     $formattedParent = $uptimeCheckServiceClient->projectName('[PROJECT]');
     *     $uptimeCheckConfig = new UptimeCheckConfig();
     *     $response = $uptimeCheckServiceClient->createUptimeCheckConfig($formattedParent, $uptimeCheckConfig);
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param string $parent The project in which to create the uptime check. The format is:
     *
     *   `projects/[PROJECT_ID]`.
     * @param UptimeCheckConfig $uptimeCheckConfig The new uptime check configuration.
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
     * @return \Google\Cloud\Monitoring\V3\UptimeCheckConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createUptimeCheckConfig($parent, $uptimeCheckConfig, $optionalArgs = [])
    {
        $request = new CreateUptimeCheckConfigRequest();
        $request->setParent($parent);
        $request->setUptimeCheckConfig($uptimeCheckConfig);

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/CreateUptimeCheckConfig',
                UptimeCheckConfig::class,
                $request
            ),
            $this->configureCallSettings('createUptimeCheckConfig', $optionalArgs)
        )->wait();
    }

    /**
     * Updates an uptime check configuration. You can either replace the entire
     * configuration with a new one or replace only certain fields in the current
     * configuration by specifying the fields to be updated via `"updateMask"`.
     * Returns the updated configuration.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *     $uptimeCheckConfig = new UptimeCheckConfig();
     *     $response = $uptimeCheckServiceClient->updateUptimeCheckConfig($uptimeCheckConfig);
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param UptimeCheckConfig $uptimeCheckConfig Required. If an `"updateMask"` has been specified, this field gives
     *                                             the values for the set of fields mentioned in the `"updateMask"`. If an
     *                                             `"updateMask"` has not been given, this uptime check configuration replaces
     *                                             the current configuration. If a field is mentioned in `"updateMask`" but
     *                                             the corresonding field is omitted in this partial uptime check
     *                                             configuration, it has the effect of deleting/clearing the field from the
     *                                             configuration on the server.
     * @param array             $optionalArgs      {
     *                                             Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional. If present, only the listed fields in the current uptime check
     *          configuration are updated with values from the new configuration. If this
     *          field is empty, then the current configuration is completely replaced with
     *          the new configuration.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\UptimeCheckConfig
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateUptimeCheckConfig($uptimeCheckConfig, $optionalArgs = [])
    {
        $request = new UpdateUptimeCheckConfigRequest();
        $request->setUptimeCheckConfig($uptimeCheckConfig);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/UpdateUptimeCheckConfig',
                UptimeCheckConfig::class,
                $request
            ),
            $this->configureCallSettings('updateUptimeCheckConfig', $optionalArgs)
        )->wait();
    }

    /**
     * Deletes an uptime check configuration. Note that this method will fail
     * if the uptime check configuration is referenced by an alert policy or
     * other dependent configs that would be rendered invalid by the deletion.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *     $formattedName = $uptimeCheckServiceClient->uptimeCheckConfigName('[PROJECT]', '[UPTIME_CHECK_CONFIG]');
     *     $uptimeCheckServiceClient->deleteUptimeCheckConfig($formattedName);
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param string $name The uptime check configuration to delete. The format is
     *
     *   `projects/[PROJECT_ID]/uptimeCheckConfigs/[UPTIME_CHECK_ID]`.
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
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteUptimeCheckConfig($name, $optionalArgs = [])
    {
        $request = new DeleteUptimeCheckConfigRequest();
        $request->setName($name);

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/DeleteUptimeCheckConfig',
                GPBEmpty::class,
                $request
            ),
            $this->configureCallSettings('deleteUptimeCheckConfig', $optionalArgs)
        )->wait();
    }

    /**
     * Returns the list of IPs that checkers run from.
     *
     * Sample code:
     * ```
     * try {
     *     $uptimeCheckServiceClient = new UptimeCheckServiceClient();
     *
     *     // Iterate through all elements
     *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckIps();
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $uptimeCheckServiceClient->listUptimeCheckIps();
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $uptimeCheckServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listUptimeCheckIps($optionalArgs = [])
    {
        $request = new ListUptimeCheckIpsRequest();
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            new Call(
                self::SERVICE_NAME.'/ListUptimeCheckIps',
                ListUptimeCheckIpsResponse::class,
                $request
            ),
            $this->configureCallSettings('listUptimeCheckIps', $optionalArgs),
            $this->descriptors['listUptimeCheckIps']['pageStreaming']
        );
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->transport->close();
    }
}
