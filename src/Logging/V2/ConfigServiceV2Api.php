<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging_config.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Logging\V2;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\logging\v2\ConfigServiceV2Client;
use google\logging\v2\CreateSinkRequest;
use google\logging\v2\DeleteSinkRequest;
use google\logging\v2\GetSinkRequest;
use google\logging\v2\ListSinksRequest;
use google\logging\v2\LogSink;
use google\logging\v2\UpdateSinkRequest;

/**
 * Service Description: Service for configuring sinks used to export log entries outside Stackdriver
 * Logging.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $configServiceV2Api = new ConfigServiceV2Api();
 *     $formattedParent = ConfigServiceV2Api::formatParentName("[PROJECT]");
 *     foreach ($configServiceV2Api->listSinks($formattedParent) as $element) {
 *         // doThingsWith(element);
 *     }
 * } finally {
 *     if (isset($configServiceV2Api)) {
 *         $configServiceV2Api->close();
 *     }
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class ConfigServiceV2Api
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

    const _GAX_VERSION = '0.1.0';
    const _CODEGEN_NAME = 'GAPIC';
    const _CODEGEN_VERSION = '0.0.0';

    private static $parentNameTemplate;
    private static $sinkNameTemplate;

    private $grpcCredentialsHelper;
    private $configServiceV2Stub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a parent resource.
     */
    public static function formatParentName($project)
    {
        return self::getParentNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a sink resource.
     */
    public static function formatSinkName($project, $sink)
    {
        return self::getSinkNameTemplate()->render([
            'project' => $project,
            'sink' => $sink,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a parent resource.
     */
    public static function parseProjectFromParentName($parentName)
    {
        return self::getParentNameTemplate()->match($parentName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a sink resource.
     */
    public static function parseProjectFromSinkName($sinkName)
    {
        return self::getSinkNameTemplate()->match($sinkName)['project'];
    }

    /**
     * Parses the sink from the given fully-qualified path which
     * represents a sink resource.
     */
    public static function parseSinkFromSinkName($sinkName)
    {
        return self::getSinkNameTemplate()->match($sinkName)['sink'];
    }

    private static function getParentNameTemplate()
    {
        if (self::$parentNameTemplate == null) {
            self::$parentNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$parentNameTemplate;
    }

    private static function getSinkNameTemplate()
    {
        if (self::$sinkNameTemplate == null) {
            self::$sinkNameTemplate = new PathTemplate('projects/{project}/sinks/{sink}');
        }

        return self::$sinkNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listSinksPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenField' => 'page_token',
                    'requestPageSizeField' => 'page_size',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'sinks',
                ]);

        $pageStreamingDescriptors = [
            'listSinks' => $listSinksPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'logging.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Stackdriver Logging API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type string $appName The codename of the calling service. Default 'gax'.
     *     @type string $appVersion The version of the calling service.
     *                              Default: the current version of GAX.
     *     @type Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     */
    public function __construct($options = [])
    {
        $defaultScopes = [
            'https://www.googleapis.com/auth/cloud-platform',
            'https://www.googleapis.com/auth/cloud-platform.read-only',
            'https://www.googleapis.com/auth/logging.admin',
            'https://www.googleapis.com/auth/logging.read',
            'https://www.googleapis.com/auth/logging.write',
        ];
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => $defaultScopes,
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'appName' => 'gax',
            'appVersion' => self::_GAX_VERSION,
            'credentialsLoader' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        $headerDescriptor = new AgentHeaderDescriptor([
            'clientName' => $options['appName'],
            'clientVersion' => $options['appVersion'],
            'codeGenName' => self::_CODEGEN_NAME,
            'codeGenVersion' => self::_CODEGEN_VERSION,
            'gaxVersion' => self::_GAX_VERSION,
            'phpVersion' => phpversion(),
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

        // TODO load the client config in a more package-friendly way
        // https://github.com/googleapis/toolkit/issues/332
        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/config_service_v2_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.logging.v2.ConfigServiceV2',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createConfigServiceV2StubFunction = function ($hostname, $opts) {
            return new ConfigServiceV2Client($hostname, $opts);
        };
        $this->configServiceV2Stub = $this->grpcCredentialsHelper->createStub(
            $createConfigServiceV2StubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Lists sinks.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Api = new ConfigServiceV2Api();
     *     $formattedParent = ConfigServiceV2Api::formatParentName("[PROJECT]");
     *     foreach ($configServiceV2Api->listSinks($formattedParent) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($configServiceV2Api)) {
     *         $configServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $parent       Required. The resource name containing the sinks.
     *                             Example: `"projects/my-logging-project"`.
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PagedListResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     *     $configServiceV2Api = new ConfigServiceV2Api();
     *     $formattedSinkName = ConfigServiceV2Api::formatSinkName("[PROJECT]", "[SINK]");
     *     $response = $configServiceV2Api->getSink($formattedSinkName);
     * } finally {
     *     if (isset($configServiceV2Api)) {
     *         $configServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $sinkName     The resource name of the sink to return.
     *                             Example: `"projects/my-project-id/sinks/my-sink-id"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogSink
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     * Creates a sink.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Api = new ConfigServiceV2Api();
     *     $formattedParent = ConfigServiceV2Api::formatParentName("[PROJECT]");
     *     $sink = new LogSink();
     *     $response = $configServiceV2Api->createSink($formattedParent, $sink);
     * } finally {
     *     if (isset($configServiceV2Api)) {
     *         $configServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $parent The resource in which to create the sink.
     *                       Example: `"projects/my-project-id"`.
     *
     * The new sink must be provided in the request.
     * @param LogSink $sink         The new sink, which must not have an identifier that already
     *                              exists.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogSink
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function createSink($parent, $sink, $optionalArgs = [])
    {
        $request = new CreateSinkRequest();
        $request->setParent($parent);
        $request->setSink($sink);

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
     * Creates or updates a sink.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Api = new ConfigServiceV2Api();
     *     $formattedSinkName = ConfigServiceV2Api::formatSinkName("[PROJECT]", "[SINK]");
     *     $sink = new LogSink();
     *     $response = $configServiceV2Api->updateSink($formattedSinkName, $sink);
     * } finally {
     *     if (isset($configServiceV2Api)) {
     *         $configServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $sinkName The resource name of the sink to update.
     *                         Example: `"projects/my-project-id/sinks/my-sink-id"`.
     *
     * The updated sink must be provided in the request and have the
     * same name that is specified in `sinkName`.  If the sink does not
     * exist, it is created.
     * @param LogSink $sink         The updated sink, whose name must be the same as the sink
     *                              identifier in `sinkName`.  If `sinkName` does not exist, then
     *                              this method creates a new sink.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogSink
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function updateSink($sinkName, $sink, $optionalArgs = [])
    {
        $request = new UpdateSinkRequest();
        $request->setSinkName($sinkName);
        $request->setSink($sink);

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
     * Deletes a sink.
     *
     * Sample code:
     * ```
     * try {
     *     $configServiceV2Api = new ConfigServiceV2Api();
     *     $formattedSinkName = ConfigServiceV2Api::formatSinkName("[PROJECT]", "[SINK]");
     *     $configServiceV2Api->deleteSink($formattedSinkName);
     * } finally {
     *     if (isset($configServiceV2Api)) {
     *         $configServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $sinkName     The resource name of the sink to delete.
     *                             Example: `"projects/my-project-id/sinks/my-sink-id"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
