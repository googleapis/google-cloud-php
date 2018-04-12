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
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dialogflow\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;
use Google\Cloud\Dialogflow\V2\DetectIntentResponse;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\QueryParameters;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentRequest;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentResponse;
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: A session represents an interaction with a user. You retrieve user input
 * and pass it to the [DetectIntent][google.cloud.dialogflow.v2.Sessions.DetectIntent] (or
 * [StreamingDetectIntent][google.cloud.dialogflow.v2.Sessions.StreamingDetectIntent]) method to determine
 * user intent and respond.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $sessionsClient = new SessionsClient();
 * try {
 *     $formattedSession = $sessionsClient->sessionName('[PROJECT]', '[SESSION]');
 *     $queryInput = new QueryInput();
 *     $response = $sessionsClient->detectIntent($formattedSession, $queryInput);
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $sessionNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/sessions_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/sessions_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/sessions_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    private static function getSessionNameTemplate()
    {
        if (self::$sessionNameTemplate == null) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'session' => self::getSessionNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dialogflow.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
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
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Dialogflow API.
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
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $this->setClientOptions($options + self::getClientDefaults());
    }

    /**
     * Processes a natural language query and returns structured, actionable data
     * as a result. This method is not idempotent, because it may cause contexts
     * and session entity types to be updated, which in turn might affect
     * results of future queries.
     *
     * Sample code:
     * ```
     * $sessionsClient = new SessionsClient();
     * try {
     *     $formattedSession = $sessionsClient->sessionName('[PROJECT]', '[SESSION]');
     *     $queryInput = new QueryInput();
     *     $response = $sessionsClient->detectIntent($formattedSession, $queryInput);
     * } finally {
     *     $sessionsClient->close();
     * }
     * ```
     *
     * @param string     $session    Required. The name of the session this query is sent to. Format:
     *                               `projects/<Project ID>/agent/sessions/<Session ID>`. It's up to the API
     *                               caller to choose an appropriate session ID. It can be a random number or
     *                               some type of user identifier (preferably hashed). The length of the session
     *                               ID must not exceed 36 bytes.
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
     *          Optional. The parameters of this query.
     *     @type string $inputAudio
     *          Optional. The natural language speech audio to be processed. This field
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
    public function detectIntent($session, $queryInput, $optionalArgs = [])
    {
        $request = new DetectIntentRequest();
        $request->setSession($session);
        $request->setQueryInput($queryInput);
        if (isset($optionalArgs['queryParams'])) {
            $request->setQueryParams($optionalArgs['queryParams']);
        }
        if (isset($optionalArgs['inputAudio'])) {
            $request->setInputAudio($optionalArgs['inputAudio']);
        }

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
     * Sample code:
     * ```
     * $sessionsClient = new SessionsClient();
     * try {
     *     $session = '';
     *     $queryInput = new QueryInput();
     *     $request = new StreamingDetectIntentRequest();
     *     $request->setSession($session);
     *     $request->setQueryInput($queryInput);
     *     $requests = [$request];
     *
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $stream = $sessionsClient->streamingDetectIntent();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
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
    public function streamingDetectIntent($optionalArgs = [])
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
