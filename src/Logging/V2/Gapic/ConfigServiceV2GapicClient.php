<?php
/*
 * Copyright 2017, Google Inc. All rights reserved.
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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging_config.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Logging\V2\Gapic;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\GAX\ValidationException;
use Google\Logging\V2\ConfigServiceV2GrpcClient;
use Google\Logging\V2\CreateSinkRequest;
use Google\Logging\V2\DeleteSinkRequest;
use Google\Logging\V2\GetSinkRequest;
use Google\Logging\V2\ListSinksRequest;
use Google\Logging\V2\LogSink;
use Google\Logging\V2\UpdateSinkRequest;

/**
 * Service Description: Service for configuring sinks used to export log entries outside of
 * Stackdriver Logging.
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
 *     $configServiceV2Client = new ConfigServiceV2Client();
 *     $formattedParent = $configServiceV2Client->projectName("[PROJECT]");
 *     // Iterate through all elements
 *     $pagedResponse = $configServiceV2Client->listSinks($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements, with the maximum page size set to 5
 *     $pagedResponse = $configServiceV2Client->listSinks($formattedParent, ['pageSize' => 5]);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $configServiceV2Client->close();
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
class ConfigServiceV2GapicClient
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
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $sinkNameTemplate;
    private static $pathTemplateList = null;
    private static $gapicVersion = null;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $configServiceV2Stub;
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

    private static function getSinkNameTemplate()
    {
        if (self::$sinkNameTemplate == null) {
            self::$sinkNameTemplate = new PathTemplate('projects/{project}/sinks/{sink}');
        }

        return self::$sinkNameTemplate;
    }
    private static function getPathTemplateList()
    {
        if (self::$pathTemplateList == null) {
            self::$pathTemplateList = [
                self::getProjectNameTemplate(),
                self::getSinkNameTemplate(),
            ];
        }

        return self::$pathTemplateList;
    }
    private static function getPageStreamingDescriptors()
    {
        $listSinksPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSinks',
                ]);

        $pageStreamingDescriptors = [
            'listSinks' => $listSinksPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGapicVersion()
    {
        if (!self::$gapicVersionLoaded) {
            if (file_exists(__DIR__.'/../VERSION')) {
                self::$gapicVersion = trim(file_get_contents(__DIR__.'/../VERSION'));
            } elseif (class_exists('\Google\Cloud\Version')) {
                self::$gapicVersion = \Google\Cloud\Version::VERSION;
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
     * a sink resource.
     *
     * @param string $project
     * @param string $sink
     *
     * @return string The formatted sink resource.
     * @experimental
     */
    public static function sinkName($project, $sink)
    {
        return self::getSinkNameTemplate()->render([
            'project' => $project,
            'sink' => $sink,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * - projects/{project}
     * - projects/{project}/sinks/{sink}.
     *
     * @param string $formattedName The formatted name string
     *
     * @return array An associative array from name component IDs to component values.
     * @experimental
     */
    public static function parseName($formattedName)
    {
        foreach (self::getPathTemplateList() as $pathTemplate) {
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
     *           in the resources folder.
     *     @type array $retryingOverride
     *           An associative array in which the keys are method names (e.g. 'createFoo'), and
     *           the values are retry settings to use for that method. The retry settings for each
     *           method can be a {@see Google\GAX\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\GAX\RetrySettings}
     *           for example usage. Passing a value of null is equivalent to a value of
     *           ['retriesEnabled' => false].
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
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/config_service_v2_client_config.json',
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
            'listSinks' => $defaultDescriptors,
            'getSink' => $defaultDescriptors,
            'createSink' => $defaultDescriptors,
            'updateSink' => $defaultDescriptors,
            'deleteSink' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.logging.v2.ConfigServiceV2',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createConfigServiceV2StubFunction = function ($hostname, $opts, $channel) {
            return new ConfigServiceV2GrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createConfigServiceV2StubFunction', $options)) {
            $createConfigServiceV2StubFunction = $options['createConfigServiceV2StubFunction'];
        }
        $this->configServiceV2Stub = $this->grpcCredentialsHelper->createStub($createConfigServiceV2StubFunction);
    }

    /**
     * Lists sinks.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Client = new ConfigServiceV2Client();
     *     $formattedParent = $configServiceV2Client->projectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $configServiceV2Client->listSinks($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $configServiceV2Client->listSinks($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $configServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent Required. The parent resource whose sinks are to be listed:
     *
     *     "projects/[PROJECT_ID]"
     *     "organizations/[ORGANIZATION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]"
     *     "folders/[FOLDER_ID]"
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
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listSinks($parent, $optionalArgs = [])
    {
        $request = new ListSinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $mergedSettings = $this->defaultCallSettings['listSinks']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->configServiceV2Stub,
            'ListSinks',
            $mergedSettings,
            $this->descriptors['listSinks']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a sink.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Client = new ConfigServiceV2Client();
     *     $formattedSinkName = $configServiceV2Client->sinkName("[PROJECT]", "[SINK]");
     *     $response = $configServiceV2Client->getSink($formattedSinkName);
     * } finally {
     *     $configServiceV2Client->close();
     * }
     * ```
     *
     * @param string $sinkName Required. The resource name of the sink:
     *
     *     "projects/[PROJECT_ID]/sinks/[SINK_ID]"
     *     "organizations/[ORGANIZATION_ID]/sinks/[SINK_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/sinks/[SINK_ID]"
     *     "folders/[FOLDER_ID]/sinks/[SINK_ID]"
     *
     * Example: `"projects/my-project-id/sinks/my-sink-id"`.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Logging\V2\LogSink
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getSink($sinkName, $optionalArgs = [])
    {
        $request = new GetSinkRequest();
        $request->setSinkName($sinkName);

        $mergedSettings = $this->defaultCallSettings['getSink']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->configServiceV2Stub,
            'GetSink',
            $mergedSettings,
            $this->descriptors['getSink']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a sink that exports specified log entries to a destination.  The
     * export of newly-ingested log entries begins immediately, unless the current
     * time is outside the sink's start and end times or the sink's
     * `writer_identity` is not permitted to write to the destination.  A sink can
     * export log entries only from the resource owning the sink.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Client = new ConfigServiceV2Client();
     *     $formattedParent = $configServiceV2Client->projectName("[PROJECT]");
     *     $sink = new LogSink();
     *     $response = $configServiceV2Client->createSink($formattedParent, $sink);
     * } finally {
     *     $configServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent Required. The resource in which to create the sink:
     *
     *     "projects/[PROJECT_ID]"
     *     "organizations/[ORGANIZATION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]"
     *     "folders/[FOLDER_ID]"
     *
     * Examples: `"projects/my-logging-project"`, `"organizations/123456789"`.
     * @param LogSink $sink         Required. The new sink, whose `name` parameter is a sink identifier that
     *                              is not already in use.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type bool $uniqueWriterIdentity
     *          Optional. Determines the kind of IAM identity returned as `writer_identity`
     *          in the new sink.  If this value is omitted or set to false, and if the
     *          sink's parent is a project, then the value returned as `writer_identity` is
     *          the same group or service account used by Stackdriver Logging before the
     *          addition of writer identities to this API. The sink's destination must be
     *          in the same project as the sink itself.
     *
     *          If this field is set to true, or if the sink is owned by a non-project
     *          resource such as an organization, then the value of `writer_identity` will
     *          be a unique service account used only for exports from the new sink.  For
     *          more information, see `writer_identity` in [LogSink][google.logging.v2.LogSink].
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Logging\V2\LogSink
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createSink($parent, $sink, $optionalArgs = [])
    {
        $request = new CreateSinkRequest();
        $request->setParent($parent);
        $request->setSink($sink);
        if (isset($optionalArgs['uniqueWriterIdentity'])) {
            $request->setUniqueWriterIdentity($optionalArgs['uniqueWriterIdentity']);
        }

        $mergedSettings = $this->defaultCallSettings['createSink']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->configServiceV2Stub,
            'CreateSink',
            $mergedSettings,
            $this->descriptors['createSink']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates a sink.  This method replaces the following fields in the existing
     * sink with values from the new sink: `destination`, `filter`,
     * `output_version_format`, `start_time`, and `end_time`.
     * The updated sink might also have a new `writer_identity`; see the
     * `unique_writer_identity` field.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Client = new ConfigServiceV2Client();
     *     $formattedSinkName = $configServiceV2Client->sinkName("[PROJECT]", "[SINK]");
     *     $sink = new LogSink();
     *     $response = $configServiceV2Client->updateSink($formattedSinkName, $sink);
     * } finally {
     *     $configServiceV2Client->close();
     * }
     * ```
     *
     * @param string $sinkName Required. The full resource name of the sink to update, including the
     *                         parent resource and the sink identifier:
     *
     *     "projects/[PROJECT_ID]/sinks/[SINK_ID]"
     *     "organizations/[ORGANIZATION_ID]/sinks/[SINK_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/sinks/[SINK_ID]"
     *     "folders/[FOLDER_ID]/sinks/[SINK_ID]"
     *
     * Example: `"projects/my-project-id/sinks/my-sink-id"`.
     * @param LogSink $sink         Required. The updated sink, whose name is the same identifier that appears
     *                              as part of `sink_name`.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type bool $uniqueWriterIdentity
     *          Optional. See
     *          [sinks.create](https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/create)
     *          for a description of this field.  When updating a sink, the effect of this
     *          field on the value of `writer_identity` in the updated sink depends on both
     *          the old and new values of this field:
     *
     *          +   If the old and new values of this field are both false or both true,
     *              then there is no change to the sink's `writer_identity`.
     *          +   If the old value is false and the new value is true, then
     *              `writer_identity` is changed to a unique service account.
     *          +   It is an error if the old value is true and the new value is
     *              set to false or defaulted to false.
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Logging\V2\LogSink
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateSink($sinkName, $sink, $optionalArgs = [])
    {
        $request = new UpdateSinkRequest();
        $request->setSinkName($sinkName);
        $request->setSink($sink);
        if (isset($optionalArgs['uniqueWriterIdentity'])) {
            $request->setUniqueWriterIdentity($optionalArgs['uniqueWriterIdentity']);
        }

        $mergedSettings = $this->defaultCallSettings['updateSink']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->configServiceV2Stub,
            'UpdateSink',
            $mergedSettings,
            $this->descriptors['updateSink']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a sink. If the sink has a unique `writer_identity`, then that
     * service account is also deleted.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Client = new ConfigServiceV2Client();
     *     $formattedSinkName = $configServiceV2Client->sinkName("[PROJECT]", "[SINK]");
     *     $configServiceV2Client->deleteSink($formattedSinkName);
     * } finally {
     *     $configServiceV2Client->close();
     * }
     * ```
     *
     * @param string $sinkName Required. The full resource name of the sink to delete, including the
     *                         parent resource and the sink identifier:
     *
     *     "projects/[PROJECT_ID]/sinks/[SINK_ID]"
     *     "organizations/[ORGANIZATION_ID]/sinks/[SINK_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/sinks/[SINK_ID]"
     *     "folders/[FOLDER_ID]/sinks/[SINK_ID]"
     *
     * Example: `"projects/my-project-id/sinks/my-sink-id"`.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function deleteSink($sinkName, $optionalArgs = [])
    {
        $request = new DeleteSinkRequest();
        $request->setSinkName($sinkName);

        $mergedSettings = $this->defaultCallSettings['deleteSink']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->configServiceV2Stub,
            'DeleteSink',
            $mergedSettings,
            $this->descriptors['deleteSink']
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
        $this->configServiceV2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
