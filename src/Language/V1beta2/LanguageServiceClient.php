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
 * https://github.com/google/googleapis/blob/master/google/cloud/language/v1beta2/language_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Language\V1beta2;

use Google\Cloud\Language\V1beta2\AnnotateTextRequest_Features as Features;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;

/**
 * Service Description: Provides text analysis operations such as sentiment analysis and entity
 * recognition.
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
class LanguageServiceClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'language.googleapis.com';

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
    private $languageServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
     *                                  Default 'language.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Natural Language API.
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
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
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
            'analyzeSentiment' => $defaultDescriptors,
            'analyzeEntities' => $defaultDescriptors,
            'analyzeEntitySentiment' => $defaultDescriptors,
            'analyzeSyntax' => $defaultDescriptors,
            'annotateText' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/language_service_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.language.v1beta2.LanguageService',
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

        $createLanguageServiceStubFunction = function ($hostname, $opts) {
            return new LanguageServiceGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createLanguageServiceStubFunction', $options)) {
            $createLanguageServiceStubFunction = $options['createLanguageServiceStubFunction'];
        }
        $this->languageServiceStub = $this->grpcCredentialsHelper->createStub(
            $createLanguageServiceStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeSentimentResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeSentiment($document, $optionalArgs = [])
    {
        $request = new AnalyzeSentimentRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        $mergedSettings = $this->defaultCallSettings['analyzeSentiment']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->languageServiceStub,
            'AnalyzeSentiment',
            $mergedSettings,
            $this->descriptors['analyzeSentiment']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     $encodingType = EncodingType::NONE;
     *     $response = $languageServiceClient->analyzeEntities($document, $encodingType);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param int      $encodingType The encoding type used by the API to calculate offsets.
     *                               For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntities($document, $encodingType, $optionalArgs = [])
    {
        $request = new AnalyzeEntitiesRequest();
        $request->setDocument($document);
        $request->setEncodingType($encodingType);

        $mergedSettings = $this->defaultCallSettings['analyzeEntities']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->languageServiceStub,
            'AnalyzeEntities',
            $mergedSettings,
            $this->descriptors['analyzeEntities']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     $encodingType = EncodingType::NONE;
     *     $response = $languageServiceClient->analyzeEntitySentiment($document, $encodingType);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param int      $encodingType The encoding type used by the API to calculate offsets.
     *                               For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntitySentiment($document, $encodingType, $optionalArgs = [])
    {
        $request = new AnalyzeEntitySentimentRequest();
        $request->setDocument($document);
        $request->setEncodingType($encodingType);

        $mergedSettings = $this->defaultCallSettings['analyzeEntitySentiment']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->languageServiceStub,
            'AnalyzeEntitySentiment',
            $mergedSettings,
            $this->descriptors['analyzeEntitySentiment']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     $encodingType = EncodingType::NONE;
     *     $response = $languageServiceClient->analyzeSyntax($document, $encodingType);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param int      $encodingType The encoding type used by the API to calculate offsets.
     *                               For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeSyntaxResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeSyntax($document, $encodingType, $optionalArgs = [])
    {
        $request = new AnalyzeSyntaxRequest();
        $request->setDocument($document);
        $request->setEncodingType($encodingType);

        $mergedSettings = $this->defaultCallSettings['analyzeSyntax']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->languageServiceStub,
            'AnalyzeSyntax',
            $mergedSettings,
            $this->descriptors['analyzeSyntax']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * A convenience method that provides all syntax, sentiment, and entity
     * features in one call.
     *
     * Sample code:
     * ```
     * try {
     *     $languageServiceClient = new LanguageServiceClient();
     *     $document = new Document();
     *     $features = new Features();
     *     $encodingType = EncodingType::NONE;
     *     $response = $languageServiceClient->annotateText($document, $features, $encodingType);
     * } finally {
     *     $languageServiceClient->close();
     * }
     * ```
     *
     * @param Document $document     Input document.
     * @param Features $features     The enabled features.
     * @param int      $encodingType The encoding type used by the API to calculate offsets.
     *                               For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnnotateTextResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function annotateText($document, $features, $encodingType, $optionalArgs = [])
    {
        $request = new AnnotateTextRequest();
        $request->setDocument($document);
        $request->setFeatures($features);
        $request->setEncodingType($encodingType);

        $mergedSettings = $this->defaultCallSettings['annotateText']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->languageServiceStub,
            'AnnotateText',
            $mergedSettings,
            $this->descriptors['annotateText']
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
        $this->languageServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
