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
 * https://github.com/google/googleapis/blob/master/google/devtools/cloudtrace/v1/trace.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 */

namespace Google\Cloud\Trace\V1;

use Google\Devtools\Cloudtrace\V1\GetTraceRequest;
use Google\Devtools\Cloudtrace\V1\ListTracesRequest;
use Google\Devtools\Cloudtrace\V1\ListTracesRequest_ViewType as ViewType;
use Google\Devtools\Cloudtrace\V1\PatchTracesRequest;
use Google\Devtools\Cloudtrace\V1\TraceServiceGrpcClient;
use Google\Devtools\Cloudtrace\V1\Traces;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\Protobuf\Timestamp;

/**
 * Service Description: This file describes an API for collecting and viewing traces and spans
 * within a trace.  A Trace is a collection of spans corresponding to a single
 * operation or set of operations for an application. A span is an individual
 * timed event which forms a node of the trace tree. Spans for a single trace
 * may span multiple services.
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
 *     $traceServiceClient = new TraceServiceClient();
 *     $projectId = "";
 *     $traces = new Traces();
 *     $traceServiceClient->patchTraces($projectId, $traces);
 * } finally {
 *     $traceServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class TraceServiceClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'cloudtrace.googleapis.com';

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

    private $grpcCredentialsHelper;
    private $traceServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    private static function getPageStreamingDescriptors()
    {
        $listTracesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTraces',
                ]);

        $pageStreamingDescriptors = [
            'listTraces' => $listTracesPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGapicVersion()
    {
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'cloudtrace.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Stackdriver Trace API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/trace.append',
                'https://www.googleapis.com/auth/trace.readonly',
            ],
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
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
            'patchTraces' => $defaultDescriptors,
            'getTrace' => $defaultDescriptors,
            'listTraces' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/trace_service_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.devtools.cloudtrace.v1.TraceService',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createTraceServiceStubFunction = function ($hostname, $opts) {
            return new TraceServiceGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createTraceServiceStubFunction', $options)) {
            $createTraceServiceStubFunction = $options['createTraceServiceStubFunction'];
        }
        $this->traceServiceStub = $this->grpcCredentialsHelper->createStub(
            $createTraceServiceStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Sends new traces to Stackdriver Trace or updates existing traces. If the ID
     * of a trace that you send matches that of an existing trace, any fields
     * in the existing trace and its spans are overwritten by the provided values,
     * and any new fields provided are merged with the existing trace data. If the
     * ID does not match, a new trace is created.
     *
     * Sample code:
     * ```
     * try {
     *     $traceServiceClient = new TraceServiceClient();
     *     $projectId = "";
     *     $traces = new Traces();
     *     $traceServiceClient->patchTraces($projectId, $traces);
     * } finally {
     *     $traceServiceClient->close();
     * }
     * ```
     *
     * @param string $projectId    ID of the Cloud project where the trace data is stored.
     * @param Traces $traces       The body of the message.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function patchTraces($projectId, $traces, $optionalArgs = [])
    {
        $request = new PatchTracesRequest();
        $request->setProjectId($projectId);
        $request->setTraces($traces);

        $mergedSettings = $this->defaultCallSettings['patchTraces']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->traceServiceStub,
            'PatchTraces',
            $mergedSettings,
            $this->descriptors['patchTraces']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a single trace by its ID.
     *
     * Sample code:
     * ```
     * try {
     *     $traceServiceClient = new TraceServiceClient();
     *     $projectId = "";
     *     $traceId = "";
     *     $response = $traceServiceClient->getTrace($projectId, $traceId);
     * } finally {
     *     $traceServiceClient->close();
     * }
     * ```
     *
     * @param string $projectId    ID of the Cloud project where the trace data is stored.
     * @param string $traceId      ID of the trace to return.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Devtools\Cloudtrace\V1\Trace
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function getTrace($projectId, $traceId, $optionalArgs = [])
    {
        $request = new GetTraceRequest();
        $request->setProjectId($projectId);
        $request->setTraceId($traceId);

        $mergedSettings = $this->defaultCallSettings['getTrace']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->traceServiceStub,
            'GetTrace',
            $mergedSettings,
            $this->descriptors['getTrace']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns of a list of traces that match the specified filter conditions.
     *
     * Sample code:
     * ```
     * try {
     *     $traceServiceClient = new TraceServiceClient();
     *     $projectId = "";
     *     // Iterate through all elements
     *     $pagedResponse = $traceServiceClient->listTraces($projectId);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $traceServiceClient->listTraces($projectId, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $traceServiceClient->close();
     * }
     * ```
     *
     * @param string $projectId    ID of the Cloud project where the trace data is stored.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type ViewType $view
     *          Type of data returned for traces in the list. Optional. Default is
     *          `MINIMAL`.
     *     @type int $pageSize
     *          Maximum number of traces to return. If not specified or <= 0, the
     *          implementation selects a reasonable value.  The implementation may
     *          return fewer traces than the requested page size. Optional.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type Timestamp $startTime
     *          End of the time interval (inclusive) during which the trace data was
     *          collected from the application.
     *     @type Timestamp $endTime
     *          Start of the time interval (inclusive) during which the trace data was
     *          collected from the application.
     *     @type string $filter
     *          An optional filter for the request.
     *     @type string $orderBy
     *          Field used to sort the returned traces. Optional.
     *          Can be one of the following:
     *
     *          &#42;   `trace_id`
     *          &#42;   `name` (`name` field of root span in the trace)
     *          &#42;   `duration` (difference between `end_time` and `start_time` fields of
     *               the root span)
     *          &#42;   `start` (`start_time` field of the root span)
     *
     *          Descending order can be specified by appending `desc` to the sort field
     *          (for example, `name desc`).
     *
     *          Only one sort field is permitted.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function listTraces($projectId, $optionalArgs = [])
    {
        $request = new ListTracesRequest();
        $request->setProjectId($projectId);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['startTime'])) {
            $request->setStartTime($optionalArgs['startTime']);
        }
        if (isset($optionalArgs['endTime'])) {
            $request->setEndTime($optionalArgs['endTime']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }

        $mergedSettings = $this->defaultCallSettings['listTraces']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->traceServiceStub,
            'ListTraces',
            $mergedSettings,
            $this->descriptors['listTraces']
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
        $this->traceServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
