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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging_metrics.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Logging\V2\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Logging\V2\CreateLogMetricRequest;
use Google\Cloud\Logging\V2\DeleteLogMetricRequest;
use Google\Cloud\Logging\V2\GetLogMetricRequest;
use Google\Cloud\Logging\V2\ListLogMetricsRequest;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\MetricsServiceV2GrpcClient;
use Google\Cloud\Logging\V2\UpdateLogMetricRequest;
use Google\Cloud\Version;

/**
 * Service Description: Service for configuring logs-based metrics.
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
 *     $metricsServiceV2Client = new MetricsServiceV2Client();
 *     $formattedParent = $metricsServiceV2Client->projectName('[PROJECT]');
 *     // Iterate through all elements
 *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $metricsServiceV2Client->close();
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
class MetricsServiceV2GapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'logging.googleapis.com';

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
    private static $metricNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $metricsServiceV2Stub;
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

    private static function getMetricNameTemplate()
    {
        if (self::$metricNameTemplate == null) {
            self::$metricNameTemplate = new PathTemplate('projects/{project}/metrics/{metric}');
        }

        return self::$metricNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'metric' => self::getMetricNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getPageStreamingDescriptors()
    {
        $listLogMetricsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetrics',
                ]);

        $pageStreamingDescriptors = [
            'listLogMetrics' => $listLogMetricsPageStreamingDescriptor,
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
     * a metric resource.
     *
     * @param string $project
     * @param string $metric
     *
     * @return string The formatted metric resource.
     * @experimental
     */
    public static function metricName($project, $metric)
    {
        return self::getMetricNameTemplate()->render([
            'project' => $project,
            'metric' => $metric,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - metric: projects/{project}/metrics/{metric}.
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
     *                                  Default 'logging.googleapis.com'.
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
     *                          Defaults to the scopes for the Stackdriver Logging API.
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
                'https://www.googleapis.com/auth/cloud-platform.read-only',
                'https://www.googleapis.com/auth/logging.admin',
                'https://www.googleapis.com/auth/logging.read',
                'https://www.googleapis.com/auth/logging.write',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/metrics_service_v2_client_config.json',
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
            'listLogMetrics' => $defaultDescriptors,
            'getLogMetric' => $defaultDescriptors,
            'createLogMetric' => $defaultDescriptors,
            'updateLogMetric' => $defaultDescriptors,
            'deleteLogMetric' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.logging.v2.MetricsServiceV2',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createMetricsServiceV2StubFunction = function ($hostname, $opts, $channel) {
            return new MetricsServiceV2GrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createMetricsServiceV2StubFunction', $options)) {
            $createMetricsServiceV2StubFunction = $options['createMetricsServiceV2StubFunction'];
        }
        $this->metricsServiceV2Stub = $this->grpcCredentialsHelper->createStub($createMetricsServiceV2StubFunction);
    }

    /**
     * Lists logs-based metrics.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedParent = $metricsServiceV2Client->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project containing the metrics:
     *
     *     "projects/[PROJECT_ID]"
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listLogMetrics($parent, $optionalArgs = [])
    {
        $request = new ListLogMetricsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listLogMetrics'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'ListLogMetrics',
            $mergedSettings,
            $this->descriptors['listLogMetrics']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = $metricsServiceV2Client->metricName('[PROJECT]', '[METRIC]');
     *     $response = $metricsServiceV2Client->getLogMetric($formattedMetricName);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the desired metric:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
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
     * @return \Google\Cloud\Logging\V2\LogMetric
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getLogMetric($metricName, $optionalArgs = [])
    {
        $request = new GetLogMetricRequest();
        $request->setMetricName($metricName);

        $defaultCallSettings = $this->defaultCallSettings['getLogMetric'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'GetLogMetric',
            $mergedSettings,
            $this->descriptors['getLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedParent = $metricsServiceV2Client->projectName('[PROJECT]');
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Client->createLogMetric($formattedParent, $metric);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent The resource name of the project in which to create the metric:
     *
     *     "projects/[PROJECT_ID]"
     *
     * The new metric must be provided in the request.
     * @param LogMetric $metric       The new logs-based metric, which must not have an identifier that
     *                                already exists.
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
     * @return \Google\Cloud\Logging\V2\LogMetric
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createLogMetric($parent, $metric, $optionalArgs = [])
    {
        $request = new CreateLogMetricRequest();
        $request->setParent($parent);
        $request->setMetric($metric);

        $defaultCallSettings = $this->defaultCallSettings['createLogMetric'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'CreateLogMetric',
            $mergedSettings,
            $this->descriptors['createLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates or updates a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = $metricsServiceV2Client->metricName('[PROJECT]', '[METRIC]');
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Client->updateLogMetric($formattedMetricName, $metric);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the metric to update:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
     *
     * The updated metric must be provided in the request and it's
     * `name` field must be the same as `[METRIC_ID]` If the metric
     * does not exist in `[PROJECT_ID]`, then a new metric is created.
     * @param LogMetric $metric       The updated metric.
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
     * @return \Google\Cloud\Logging\V2\LogMetric
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateLogMetric($metricName, $metric, $optionalArgs = [])
    {
        $request = new UpdateLogMetricRequest();
        $request->setMetricName($metricName);
        $request->setMetric($metric);

        $defaultCallSettings = $this->defaultCallSettings['updateLogMetric'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'UpdateLogMetric',
            $mergedSettings,
            $this->descriptors['updateLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = $metricsServiceV2Client->metricName('[PROJECT]', '[METRIC]');
     *     $metricsServiceV2Client->deleteLogMetric($formattedMetricName);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the metric to delete:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
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
    public function deleteLogMetric($metricName, $optionalArgs = [])
    {
        $request = new DeleteLogMetricRequest();
        $request->setMetricName($metricName);

        $defaultCallSettings = $this->defaultCallSettings['deleteLogMetric'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'DeleteLogMetric',
            $mergedSettings,
            $this->descriptors['deleteLogMetric']
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
        $this->metricsServiceV2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
