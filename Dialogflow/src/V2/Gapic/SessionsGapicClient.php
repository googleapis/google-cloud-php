<?php
/*
 * Copyright 2018 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/session.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Dialogflow\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;
use Google\Cloud\Dialogflow\V2\DetectIntentResponse;
use Google\Cloud\Dialogflow\V2\OutputAudioConfig;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\QueryParameters;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentRequest;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentResponse;
use Google\Protobuf\FieldMask;

/**
 * Service Description: A service used for session interactions.
 *
 * For more information, see the [API interactions
 * guide](https://cloud.google.com/dialogflow/docs/api-overview).
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $sessionsClient = new SessionsClient();
 * try {
 *     $session = '';
 *     $queryInput = new QueryInput();
 *     $response = $sessionsClient->detectIntent($session, $queryInput);
 * } finally {
 *     $sessionsClient->close();
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
class SessionsGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.Sessions';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'dialogflow.googleapis.com';

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
        'https://www.googleapis.com/auth/dialogflow',
    ];
    private static $projectEnvironmentUserSessionNameTemplate;
    private static $projectSessionNameTemplate;
    private static $sessionNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/sessions_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/sessions_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/sessions_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/sessions_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProjectEnvironmentUserSessionNameTemplate()
    {
        if (null == self::$projectEnvironmentUserSessionNameTemplate) {
            self::$projectEnvironmentUserSessionNameTemplate = new PathTemplate('projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}');
        }

        return self::$projectEnvironmentUserSessionNameTemplate;
    }

    private static function getProjectSessionNameTemplate()
    {
        if (null == self::$projectSessionNameTemplate) {
            self::$projectSessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$projectSessionNameTemplate;
    }

    private static function getSessionNameTemplate()
    {
        if (null == self::$sessionNameTemplate) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'projectEnvironmentUserSession' => self::getProjectEnvironmentUserSessionNameTemplate(),
                'projectSession' => self::getProjectSessionNameTemplate(),
                'session' => self::getSessionNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_environment_user_session resource.
     *
     * @param string $project
     * @param string $environment
     * @param string $user
     * @param string $session
     *
     * @return string The formatted project_environment_user_session resource.
     * @experimental
     */
    public static function projectEnvironmentUserSessionName($project, $environment, $user, $session)
    {
        return self::getProjectEnvironmentUserSessionNameTemplate()->render([
            'project' => $project,
            'environment' => $environment,
            'user' => $user,
            'session' => $session,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_session resource.
     *
     * @param string $project
     * @param string $session
     *
     * @return string The formatted project_session resource.
     * @experimental
     */
    public static function projectSessionName($project, $session)
    {
        return self::getProjectSessionNameTemplate()->render([
            'project' => $project,
            'session' => $session,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a session resource.
     *
     * @param string $project
     * @param string $session
     *
     * @return string The formatted session resource.
     * @experimental
     */
    public static function sessionName($project, $session)
    {
        return self::getSessionNameTemplate()->render([
            'project' => $project,
            'session' => $session,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - projectEnvironmentUserSession: projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}
     * - projectSession: projects/{project}/agent/sessions/{session}
     * - session: projects/{project}/agent/sessions/{session}.
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
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'dialogflow.googleapis.com:443'.
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
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
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
     * Processes a natural language query and returns structured, actionable data
     * as a result. This method is not idempotent, because it may cause contexts
     * and session entity types to be updated, which in turn might affect
     * results of future queries.
     *
     * Note: Always use agent versions for production traffic.
     * See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     *
     * Sample code:
     * ```
     * $sessionsClient = new SessionsClient();
     * try {
     *     $session = '';
     *     $queryInput = new QueryInput();
     *     $response = $sessionsClient->detectIntent($session, $queryInput);
     * } finally {
     *     $sessionsClient->close();
     * }
     * ```
     *
     * @param string $session Required. The name of the session this query is sent to. Format:
     *                        `projects/<Project ID>/agent/sessions/<Session ID>`, or
     *                        `projects/<Project ID>/agent/environments/<Environment ID>/users/<User
     *                        ID>/sessions/<Session ID>`. If `Environment ID` is not specified, we assume
     *                        default 'draft' environment (`Environment ID` might be referred to as
     *                        environment name at some places). If `User ID` is not specified, we are
     *                        using "-". It's up to the API caller to choose an appropriate `Session ID`
     *                        and `User Id`. They can be a random number or some type of user and session
     *                        identifiers (preferably hashed). The length of the `Session ID` and
     *                        `User ID` must not exceed 36 characters.
     *
     * For more information, see the [API interactions
     * guide](https://cloud.google.com/dialogflow/docs/api-overview).
     *
     * Note: Always use agent versions for production traffic.
     * See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     * @param QueryInput $queryInput Required. The input specification. It can be set to:
     *
     * 1.  an audio config
     *     which instructs the speech recognizer how to process the speech audio,
     *
     * 2.  a conversational query in the form of text, or
     *
     * 3.  an event that specifies which intent to trigger.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type QueryParameters $queryParams
     *          The parameters of this query.
     *     @type OutputAudioConfig $outputAudioConfig
     *          Instructs the speech synthesizer how to generate the output
     *          audio. If this field is not set and agent-level speech synthesizer is not
     *          configured, no output audio is generated.
     *     @type FieldMask $outputAudioConfigMask
     *          Mask for [output_audio_config][google.cloud.dialogflow.v2.DetectIntentRequest.output_audio_config] indicating which settings in this
     *          request-level config should override speech synthesizer settings defined at
     *          agent-level.
     *
     *          If unspecified or empty, [output_audio_config][google.cloud.dialogflow.v2.DetectIntentRequest.output_audio_config] replaces the agent-level
     *          config in its entirety.
     *     @type string $inputAudio
     *          The natural language speech audio to be processed. This field
     *          should be populated iff `query_input` is set to an input audio config.
     *          A single request can contain up to 1 minute of speech audio data.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\DetectIntentResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function detectIntent($session, $queryInput, array $optionalArgs = [])
    {
        $request = new DetectIntentRequest();
        $request->setSession($session);
        $request->setQueryInput($queryInput);
        if (isset($optionalArgs['queryParams'])) {
            $request->setQueryParams($optionalArgs['queryParams']);
        }
        if (isset($optionalArgs['outputAudioConfig'])) {
            $request->setOutputAudioConfig($optionalArgs['outputAudioConfig']);
        }
        if (isset($optionalArgs['outputAudioConfigMask'])) {
            $request->setOutputAudioConfigMask($optionalArgs['outputAudioConfigMask']);
        }
        if (isset($optionalArgs['inputAudio'])) {
            $request->setInputAudio($optionalArgs['inputAudio']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'session' => $request->getSession(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DetectIntent',
            DetectIntentResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Processes a natural language query in audio format in a streaming fashion
     * and returns structured, actionable data as a result. This method is only
     * available via the gRPC API (not REST).
     *
     * Note: Always use agent versions for production traffic.
     * See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     *
     * Sample code:
     * ```
     * $sessionsClient = new SessionsClient();
     * try {
     *     $session = '';
     *     $queryInput = new QueryInput();
     *     $request = new StreamingDetectIntentRequest();
     *     $request->setSession($session);
     *     $request->setQueryInput($queryInput);
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $requests = [$request];
     *     $stream = $sessionsClient->streamingDetectIntent();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $requests = [$request];
     *     $stream = $sessionsClient->streamingDetectIntent();
     *     foreach ($requests as $request) {
     *         $stream->write($request);
     *         // if required, read a single response from the stream
     *         $element = $stream->read();
     *         // doSomethingWith($element)
     *     }
     *     $stream->closeWrite();
     *     $element = $stream->read();
     *     while (!is_null($element)) {
     *         // doSomethingWith($element)
     *         $element = $stream->read();
     *     }
     * } finally {
     *     $sessionsClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\ApiCore\BidiStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function streamingDetectIntent(array $optionalArgs = [])
    {
        return $this->startCall(
            'StreamingDetectIntent',
            StreamingDetectIntentResponse::class,
            $optionalArgs,
            null,
            Call::BIDI_STREAMING_CALL
        );
    }
}
