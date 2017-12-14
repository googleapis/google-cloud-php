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
 * https://github.com/google/googleapis/blob/master/google/cloud/language/v1beta2/language_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Language\V1beta2\Gapic;

use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\Transport\ApiTransportInterface;
use Google\Cloud\Language\V1beta2\AnalyzeEntitiesRequest;
use Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse;
use Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentRequest;
use Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentResponse;
use Google\Cloud\Language\V1beta2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V1beta2\AnalyzeSentimentResponse;
use Google\Cloud\Language\V1beta2\AnalyzeSyntaxRequest;
use Google\Cloud\Language\V1beta2\AnalyzeSyntaxResponse;
use Google\Cloud\Language\V1beta2\AnnotateTextRequest;
use Google\Cloud\Language\V1beta2\AnnotateTextRequest_Features as Features;
use Google\Cloud\Language\V1beta2\AnnotateTextResponse;
use Google\Cloud\Language\V1beta2\ClassifyTextRequest;
use Google\Cloud\Language\V1beta2\ClassifyTextResponse;
use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\EncodingType;

/**
 * Service Description: Provides text analysis operations such as sentiment analysis and entity
 * recognition.
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
 *     $languageServiceClient = new LanguageServiceClient();
 *     $document = new Document();
 *     $response = $languageServiceClient->analyzeSentiment($document);
 * } finally {
 *     $languageServiceClient->close();
 * }
 * ```
 *
 * @experimental
 */
class LanguageServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.language.v1beta2.LanguageService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'language.googleapis.com';

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

    private static $clientDefaults = [
        'serviceName' => self::SERVICE_NAME,
        'serviceAddress' => self::SERVICE_ADDRESS,
        'port' => self::DEFAULT_SERVICE_PORT,
        'scopes' => [
            'https://www.googleapis.com/auth/cloud-platform',
        ],
        'clientConfigPath' => __DIR__.'/../resources/language_service_client_config.json',
        'restClientConfigPath' => __DIR__.'/../resources/language_service_rest_client_config.php',
        'descriptorsConfigPath' => __DIR__.'/../resources/language_service_descriptor_config.php',
    ];

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'language.googleapis.com'.
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
     *                          Defaults to the scopes for the Google Cloud Natural Language API.
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
     * Analyzes the sentiment of the provided text.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $response = $languageServiceClient->analyzeSentiment($document);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate sentence offsets for the
     *          sentence sentiment.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeSentimentResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeSentiment($document, $optionalArgs = [])
    {
        $request = new AnalyzeSentimentRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/AnalyzeSentiment',
                AnalyzeSentimentResponse::class,
                $request
            ),
            $this->configureCallSettings('analyzeSentiment', $optionalArgs)
        )->wait();
    }

    /**
     * Finds named entities (currently proper names and common nouns) in the text
     * along with entity types, salience, mentions for each entity, and
     * other properties.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $response = $languageServiceClient->analyzeEntities($document);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntities($document, $optionalArgs = [])
    {
        $request = new AnalyzeEntitiesRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/AnalyzeEntities',
                AnalyzeEntitiesResponse::class,
                $request
            ),
            $this->configureCallSettings('analyzeEntities', $optionalArgs)
        )->wait();
    }

    /**
     * Finds entities, similar to [AnalyzeEntities][google.cloud.language.v1beta2.LanguageService.AnalyzeEntities] in the text and analyzes
     * sentiment associated with each entity and its mentions.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $response = $languageServiceClient->analyzeEntitySentiment($document);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntitySentiment($document, $optionalArgs = [])
    {
        $request = new AnalyzeEntitySentimentRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/AnalyzeEntitySentiment',
                AnalyzeEntitySentimentResponse::class,
                $request
            ),
            $this->configureCallSettings('analyzeEntitySentiment', $optionalArgs)
        )->wait();
    }

    /**
     * Analyzes the syntax of the text and provides sentence boundaries and
     * tokenization along with part of speech tags, dependency trees, and other
     * properties.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $response = $languageServiceClient->analyzeSyntax($document);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeSyntaxResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeSyntax($document, $optionalArgs = [])
    {
        $request = new AnalyzeSyntaxRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/AnalyzeSyntax',
                AnalyzeSyntaxResponse::class,
                $request
            ),
            $this->configureCallSettings('analyzeSyntax', $optionalArgs)
        )->wait();
    }

    /**
     * Classifies a document into categories.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $response = $languageServiceClient->classifyText($document);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\ClassifyTextResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function classifyText($document, $optionalArgs = [])
    {
        $request = new ClassifyTextRequest();
        $request->setDocument($document);

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/ClassifyText',
                ClassifyTextResponse::class,
                $request
            ),
            $this->configureCallSettings('classifyText', $optionalArgs)
        )->wait();
    }

    /**
     * A convenience method that provides all syntax, sentiment, entity, and
     * classification features in one call.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $features = new Features();
     *     $response = $languageServiceClient->annotateText($document, $features);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param Features $features     The enabled features.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnnotateTextResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function annotateText($document, $features, $optionalArgs = [])
    {
        $request = new AnnotateTextRequest();
        $request->setDocument($document);
        $request->setFeatures($features);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        return $this->startCall(
            new Call(
                self::SERVICE_NAME.'/AnnotateText',
                AnnotateTextResponse::class,
                $request
            ),
            $this->configureCallSettings('annotateText', $optionalArgs)
        )->wait();
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
