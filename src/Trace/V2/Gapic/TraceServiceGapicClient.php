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
 * https://github.com/google/googleapis/blob/master/google/devtools/cloudtrace/v2/tracing.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Trace\V2\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Trace\V2\BatchWriteSpansRequest;
use Google\Cloud\Trace\V2\Span;
use Google\Cloud\Trace\V2\Span_Attributes as Attributes;
use Google\Cloud\Trace\V2\Span_Links as Links;
use Google\Cloud\Trace\V2\Span_TimeEvents as TimeEvents;
use Google\Cloud\Trace\V2\StackTrace;
use Google\Cloud\Trace\V2\TraceServiceGrpcClient;
use Google\Cloud\Trace\V2\TruncatableString;
use Google\Cloud\Version;
use Google\Protobuf\BoolValue;
use Google\Protobuf\Int32Value;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Service Description: This file describes an API for collecting and viewing traces and spans
 * within a trace.  A Trace is a collection of spans corresponding to a single
 * operation or set of operations for an application. A span is an individual
 * timed event which forms a node of the trace tree. A single trace may
 * contain span(s) from multiple services.
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
 *     $traceServiceClient = new TraceServiceClient();
 *     $formattedName = $traceServiceClient->projectName('[PROJECT]');
 *     $spans = [];
 *     $traceServiceClient->batchWriteSpans($formattedName, $spans);
 * } finally {
 *     $traceServiceClient->close();
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
class TraceServiceGapicClient
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
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $spanNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $traceServiceStub;
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

    private static function getSpanNameTemplate()
    {
        if (self::$spanNameTemplate == null) {
            self::$spanNameTemplate = new PathTemplate('projects/{project}/traces/{trace}/spans/{span}');
        }

        return self::$spanNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'span' => self::getSpanNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a span resource.
     *
     * @param string $project
     * @param string $trace
     * @param string $span
     *
     * @return string The formatted span resource.
     * @experimental
     */
    public static function spanName($project, $trace, $span)
    {
        return self::getSpanNameTemplate()->render([
            'project' => $project,
            'trace' => $trace,
            'span' => $span,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - span: projects/{project}/traces/{trace}/spans/{span}.
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
     *                                  Default 'cloudtrace.googleapis.com'.
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
     *                          Defaults to the scopes for the Stackdriver Trace API.
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
                'https://www.googleapis.com/auth/trace.append',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/trace_service_client_config.json',
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
            'batchWriteSpans' => $defaultDescriptors,
            'createSpan' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.devtools.cloudtrace.v2.TraceService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createTraceServiceStubFunction = function ($hostname, $opts, $channel) {
            return new TraceServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createTraceServiceStubFunction', $options)) {
            $createTraceServiceStubFunction = $options['createTraceServiceStubFunction'];
        }
        $this->traceServiceStub = $this->grpcCredentialsHelper->createStub($createTraceServiceStubFunction);
    }

    /**
     * Sends new spans to new or existing traces. You cannot update
     * existing spans.
     *
     * Sample code:
     * ```
     * try {
     *     $traceServiceClient = new TraceServiceClient();
     *     $formattedName = $traceServiceClient->projectName('[PROJECT]');
     *     $spans = [];
     *     $traceServiceClient->batchWriteSpans($formattedName, $spans);
     * } finally {
     *     $traceServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the project where the spans belong. The format is
     *                             `projects/[PROJECT_ID]`.
     * @param Span[] $spans        A list of new spans. The span names must not match existing
     *                             spans, or the results are undefined.
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
    public function batchWriteSpans($name, $spans, $optionalArgs = [])
    {
        $request = new BatchWriteSpansRequest();
        $request->setName($name);
        $request->setSpans($spans);

        $defaultCallSettings = $this->defaultCallSettings['batchWriteSpans'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->traceServiceStub,
            'BatchWriteSpans',
            $mergedSettings,
            $this->descriptors['batchWriteSpans']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new span.
     *
     * Sample code:
     * ```
     * try {
     *     $traceServiceClient = new TraceServiceClient();
     *     $formattedName = $traceServiceClient->spanName('[PROJECT]', '[TRACE]', '[SPAN]');
     *     $spanId = '';
     *     $displayName = new TruncatableString();
     *     $startTime = new Timestamp();
     *     $endTime = new Timestamp();
     *     $response = $traceServiceClient->createSpan($formattedName, $spanId, $displayName, $startTime, $endTime);
     * } finally {
     *     $traceServiceClient->close();
     * }
     * ```
     *
     * @param string $name The resource name of the span in the following format:
     *
     *     projects/[PROJECT_ID]/traces/[TRACE_ID]/spans/[SPAN_ID]
     *
     * [TRACE_ID] is a unique identifier for a trace within a project;
     * it is a 32-character hexadecimal encoding of a 16-byte array.
     *
     * [SPAN_ID] is a unique identifier for a span within a trace; it
     * is a 16-character hexadecimal encoding of an 8-byte array.
     * @param string            $spanId       The [SPAN_ID] portion of the span's resource name.
     * @param TruncatableString $displayName  A description of the span's operation (up to 128 bytes).
     *                                        Stackdriver Trace displays the description in the
     *                                        Google Cloud Platform Console.
     *                                        For example, the display name can be a qualified method name or a file name
     *                                        and a line number where the operation is called. A best practice is to use
     *                                        the same display name within an application and at the same call point.
     *                                        This makes it easier to correlate spans in different traces.
     * @param Timestamp         $startTime    The start time of the span. On the client side, this is the time kept by
     *                                        the local machine where the span execution starts. On the server side, this
     *                                        is the time when the server's application handler starts running.
     * @param Timestamp         $endTime      The end time of the span. On the client side, this is the time kept by
     *                                        the local machine where the span execution ends. On the server side, this
     *                                        is the time when the server application handler stops running.
     * @param array             $optionalArgs {
     *                                        Optional.
     *
     *     @type string $parentSpanId
     *          The [SPAN_ID] of this span's parent span. If this is a root span,
     *          then this field must be empty.
     *     @type Attributes $attributes
     *          A set of attributes on the span. You can have up to 32 attributes per
     *          span.
     *     @type StackTrace $stackTrace
     *          Stack trace captured at the start of the span.
     *     @type TimeEvents $timeEvents
     *          A set of time events. You can have up to 32 annotations and 128 message
     *          events per span.
     *     @type Links $links
     *          Links associated with the span. You can have up to 128 links per Span.
     *     @type Status $status
     *          An optional final status for this span.
     *     @type BoolValue $sameProcessAsParentSpan
     *          (Optional) Set this parameter to indicate whether this span is in
     *          the same process as its parent. If you do not set this parameter,
     *          Stackdriver Trace is unable to take advantage of this helpful
     *          information.
     *     @type Int32Value $childSpanCount
     *          An optional number of child spans that were generated while this span
     *          was active. If set, allows implementation to detect missing child spans.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Trace\V2\Span
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createSpan($name, $spanId, $displayName, $startTime, $endTime, $optionalArgs = [])
    {
        $request = new Span();
        $request->setName($name);
        $request->setSpanId($spanId);
        $request->setDisplayName($displayName);
        $request->setStartTime($startTime);
        $request->setEndTime($endTime);
        if (isset($optionalArgs['parentSpanId'])) {
            $request->setParentSpanId($optionalArgs['parentSpanId']);
        }
        if (isset($optionalArgs['attributes'])) {
            $request->setAttributes($optionalArgs['attributes']);
        }
        if (isset($optionalArgs['stackTrace'])) {
            $request->setStackTrace($optionalArgs['stackTrace']);
        }
        if (isset($optionalArgs['timeEvents'])) {
            $request->setTimeEvents($optionalArgs['timeEvents']);
        }
        if (isset($optionalArgs['links'])) {
            $request->setLinks($optionalArgs['links']);
        }
        if (isset($optionalArgs['status'])) {
            $request->setStatus($optionalArgs['status']);
        }
        if (isset($optionalArgs['sameProcessAsParentSpan'])) {
            $request->setSameProcessAsParentSpan($optionalArgs['sameProcessAsParentSpan']);
        }
        if (isset($optionalArgs['childSpanCount'])) {
            $request->setChildSpanCount($optionalArgs['childSpanCount']);
        }

        $defaultCallSettings = $this->defaultCallSettings['createSpan'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->traceServiceStub,
            'CreateSpan',
            $mergedSettings,
            $this->descriptors['createSpan']
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
        $this->traceServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
