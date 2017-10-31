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

namespace Google\Cloud\Language\V1beta2\Gapic;

use Google\Cloud\Core\GapicClientTrait;
use Google\Cloud\Core\Grpc\GrpcTransport;
use Google\Cloud\Language\V1beta2\AnalyzeEntitiesRequest;
use Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentRequest;
use Google\Cloud\Language\V1beta2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V1beta2\AnalyzeSyntaxRequest;
use Google\Cloud\Language\V1beta2\AnnotateTextRequest;
use Google\Cloud\Language\V1beta2\AnnotateTextRequest_Features as Features;
use Google\Cloud\Language\V1beta2\ClassifyTextRequest;
use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\EncodingType;
use Google\Cloud\Language\V1beta2\LanguageServiceGrpcClient;
use Google\Cloud\Version;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\CallSettings;

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
class LanguageServiceGapicClient
{
    use GapicClientTrait;

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

    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $languageServiceTransport;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'language.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\Channel $channel
     *           Optional. A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           Optional. A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type bool $forceNewChannel
     *           Optional. If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type mixed $transport Optional, the string "grpc". Determines the backend transport used
     *            to make the API call.
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
     *           method can be a {@see Google\GAX\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\GAX\RetrySettings}
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
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/language_service_client_config.json',
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
            'classifyText' => $defaultDescriptors,
            'annotateText' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.language.v1beta2.LanguageService',
                                   $clientConfig,
                                   $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        if (empty($options['createTransportFunction'])) {
            $options['createTransportFunction'] = function ($options, $transport = null) {
                switch ($transport) {
                    case 'grpc':
                        if (empty($options['createGrpcStubFunction'])) {
                            $options['createGrpcStubFunction'] = function ($fullAddress, $stubOpts, $channel) {
                                return new LanguageServiceGrpcClient($fullAddress, $stubOpts, $channel);
                            };
                        }

                        return new GrpcTransport($options);
                }
                throw new InvalidArgumentException('Invalid transport provided: '.$transport);
            };
        }

        $this->languageServiceTransport = call_user_func_array(
            $options['createTransportFunction'],
            [$options, $this->getTransport($options)]
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
     * @param Document $document     input document
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate sentence offsets for the
     *          sentence sentiment.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
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

        $defaultCallSettings = $this->defaultCallSettings['analyzeSentiment'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'AnalyzeSentiment',
            $mergedSettings,
            $this->descriptors['analyzeSentiment']
        );

        return $callable(
            $request,
            []
        );
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
     * @param Document $document     input document
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntities($document, $optionalArgs = [])
    {
        $request = new AnalyzeEntitiesRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        $defaultCallSettings = $this->defaultCallSettings['analyzeEntities'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'AnalyzeEntities',
            $mergedSettings,
            $this->descriptors['analyzeEntities']
        );

        return $callable(
            $request,
            []
        );
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
     * @param Document $document     input document
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeEntitySentiment($document, $optionalArgs = [])
    {
        $request = new AnalyzeEntitySentimentRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        $defaultCallSettings = $this->defaultCallSettings['analyzeEntitySentiment'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'AnalyzeEntitySentiment',
            $mergedSettings,
            $this->descriptors['analyzeEntitySentiment']
        );

        return $callable(
            $request,
            []
        );
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
     * @param Document $document     input document
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnalyzeSyntaxResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeSyntax($document, $optionalArgs = [])
    {
        $request = new AnalyzeSyntaxRequest();
        $request->setDocument($document);
        if (isset($optionalArgs['encodingType'])) {
            $request->setEncodingType($optionalArgs['encodingType']);
        }

        $defaultCallSettings = $this->defaultCallSettings['analyzeSyntax'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'AnalyzeSyntax',
            $mergedSettings,
            $this->descriptors['analyzeSyntax']
        );

        return $callable(
            $request,
            []
        );
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
     * @param Document $document     input document
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\ClassifyTextResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function classifyText($document, $optionalArgs = [])
    {
        $request = new ClassifyTextRequest();
        $request->setDocument($document);

        $defaultCallSettings = $this->defaultCallSettings['classifyText'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'ClassifyText',
            $mergedSettings,
            $this->descriptors['classifyText']
        );

        return $callable(
            $request,
            []
        );
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
     * @param Document $document     input document
     * @param Features $features     the enabled features
     * @param array    $optionalArgs {
     *                               Optional
     *
     *     @type int $encodingType
     *          The encoding type used by the API to calculate offsets.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Language\V1beta2\EncodingType}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Language\V1beta2\AnnotateTextResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['annotateText'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));

        $callable = $this->languageServiceTransport->createApiCall(
            'AnnotateText',
            $mergedSettings,
            $this->descriptors['annotateText']
        );

        return $callable(
            $request,
            []
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
        $this->languageServiceTransport->close();
    }
}
