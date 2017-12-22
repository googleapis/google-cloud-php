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
 * https://github.com/google/googleapis/blob/master/google/cloud/speech/v1/cloud_speech.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Speech\V1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Speech\V1\LongRunningRecognizeRequest;
use Google\Cloud\Speech\V1\LongRunningRecognizeResponse;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognizeRequest;
use Google\Cloud\Speech\V1\SpeechGrpcClient;
use Google\Cloud\Speech\V1\StreamingRecognizeRequest;
use Google\Cloud\Version;

/**
 * Service Description: Service that implements Google Cloud Speech API.
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
 *     $speechClient = new SpeechClient();
 *     $encoding = AudioEncoding::FLAC;
 *     $sampleRateHertz = 44100;
 *     $languageCode = 'en-US';
 *     $config = new RecognitionConfig();
 *     $config->setEncoding($encoding);
 *     $config->setSampleRateHertz($sampleRateHertz);
 *     $config->setLanguageCode($languageCode);
 *     $uri = 'gs://bucket_name/file_name.flac';
 *     $audio = new RecognitionAudio();
 *     $audio->setUri($uri);
 *     $response = $speechClient->recognize($config, $audio);
 * } finally {
 *     $speechClient->close();
 * }
 * ```
 *
 * @experimental
 */
class SpeechGapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'speech.googleapis.com';

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

    protected $grpcCredentialsHelper;
    protected $speechStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getLongRunningDescriptors()
    {
        return [
            'longRunningRecognize' => [
                'operationReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeResponse',
                'metadataReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeMetadata',
            ],
        ];
    }

    private static function getGrpcStreamingDescriptors()
    {
        return [
            'streamingRecognize' => [
                'grpcStreamingType' => 'BidiStreaming',
            ],
        ];
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
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\ApiCore\LongRunning\OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return \Google\ApiCore\OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $lroDescriptors = self::getLongRunningDescriptors();
        if (!is_null($methodName) && array_key_exists($methodName, $lroDescriptors)) {
            $options = $lroDescriptors[$methodName];
        } else {
            $options = [];
        }
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'speech.googleapis.com'.
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
     *                          Defaults to the scopes for the Google Cloud Speech API.
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
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/speech_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['retryingOverride']);
            unset($operationsClientOptions['clientConfigPath']);
            $this->operationsClient = new OperationsClient($operationsClientOptions);
        }

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'recognize' => $defaultDescriptors,
            'longRunningRecognize' => $defaultDescriptors,
            'streamingRecognize' => $defaultDescriptors,
        ];
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }
        $grpcStreamingDescriptors = self::getGrpcStreamingDescriptors();
        foreach ($grpcStreamingDescriptors as $method => $grpcStreamingDescriptor) {
            $this->descriptors[$method]['grpcStreamingDescriptor'] = $grpcStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.speech.v1.Speech',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createSpeechStubFunction = function ($hostname, $opts, $channel) {
            return new SpeechGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createSpeechStubFunction', $options)) {
            $createSpeechStubFunction = $options['createSpeechStubFunction'];
        }
        $this->speechStub = $this->grpcCredentialsHelper->createStub($createSpeechStubFunction);
    }

    /**
     * Performs synchronous speech recognition: receive results after all audio
     * has been sent and processed.
     *
     * Sample code:
     * ```
     * try {
     *     $speechClient = new SpeechClient();
     *     $encoding = AudioEncoding::FLAC;
     *     $sampleRateHertz = 44100;
     *     $languageCode = 'en-US';
     *     $config = new RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRateHertz($sampleRateHertz);
     *     $config->setLanguageCode($languageCode);
     *     $uri = 'gs://bucket_name/file_name.flac';
     *     $audio = new RecognitionAudio();
     *     $audio->setUri($uri);
     *     $response = $speechClient->recognize($config, $audio);
     * } finally {
     *     $speechClient->close();
     * }
     * ```
     *
     * @param RecognitionConfig $config       *Required* Provides information to the recognizer that specifies how to
     *                                        process the request.
     * @param RecognitionAudio  $audio        *Required* The audio data to be recognized.
     * @param array             $optionalArgs {
     *                                        Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Speech\V1\RecognizeResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function recognize($config, $audio, $optionalArgs = [])
    {
        $request = new RecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        $defaultCallSettings = $this->defaultCallSettings['recognize'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->speechStub,
            'Recognize',
            $mergedSettings,
            $this->descriptors['recognize']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Performs asynchronous speech recognition: receive results via the
     * google.longrunning.Operations interface. Returns either an
     * `Operation.error` or an `Operation.response` which contains
     * a `LongRunningRecognizeResponse` message.
     *
     * Sample code:
     * ```
     * try {
     *     $speechClient = new SpeechClient();
     *     $encoding = AudioEncoding::FLAC;
     *     $sampleRateHertz = 44100;
     *     $languageCode = 'en-US';
     *     $config = new RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRateHertz($sampleRateHertz);
     *     $config->setLanguageCode($languageCode);
     *     $uri = 'gs://bucket_name/file_name.flac';
     *     $audio = new RecognitionAudio();
     *     $audio->setUri($uri);
     *     $operationResponse = $speechClient->longRunningRecognize($config, $audio);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $speechClient->longRunningRecognize($config, $audio);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $speechClient->resumeOperation($operationName, 'longRunningRecognize');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $speechClient->close();
     * }
     * ```
     *
     * @param RecognitionConfig $config       *Required* Provides information to the recognizer that specifies how to
     *                                        process the request.
     * @param RecognitionAudio  $audio        *Required* The audio data to be recognized.
     * @param array             $optionalArgs {
     *                                        Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function longRunningRecognize($config, $audio, $optionalArgs = [])
    {
        $request = new LongRunningRecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        $defaultCallSettings = $this->defaultCallSettings['longRunningRecognize'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->speechStub,
            'LongRunningRecognize',
            $mergedSettings,
            $this->descriptors['longRunningRecognize']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Performs bidirectional streaming speech recognition: receive results while
     * sending audio. This method is only available via the gRPC API (not REST).
     *
     * Sample code:
     * ```
     * try {
     *     $speechClient = new SpeechClient();
     *     $request = new StreamingRecognizeRequest();
     *     $requests = [$request];
     *
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $stream = $speechClient->streamingRecognize();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $stream = $speechClient->streamingRecognize();
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
     *     $speechClient->close();
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
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function streamingRecognize($optionalArgs = [])
    {
        if (array_key_exists('timeoutMillis', $optionalArgs)) {
            $optionalArgs['retrySettings'] = [
                'retriesEnabled' => false,
                'noRetriesRpcTimeoutMillis' => $optionalArgs['timeoutMillis'],
            ];
        }

        $defaultCallSettings = $this->defaultCallSettings['streamingRecognize'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->speechStub,
            'StreamingRecognize',
            $mergedSettings,
            $this->descriptors['streamingRecognize']
        );

        return $callable(
            null,
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
        $this->speechStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
