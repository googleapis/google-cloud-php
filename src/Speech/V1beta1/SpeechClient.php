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
 * https://github.com/google/googleapis/blob/master/google/cloud/speech/v1beta1/cloud_speech.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Speech\V1beta1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\LongRunning\OperationsClient;
use Google\GAX\OperationResponse;

/**
 * Service Description: Service that implements Google Cloud Speech API.
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
 *     $speechClient = new SpeechClient();
 *     $encoding = AudioEncoding::FLAC;
 *     $sampleRate = 44100;
 *     $config = new RecognitionConfig();
 *     $config->setEncoding($encoding);
 *     $config->setSampleRate($sampleRate);
 *     $uri = "gs://bucket_name/file_name.flac";
 *     $audio = new RecognitionAudio();
 *     $audio->setUri($uri);
 *     $response = $speechClient->syncRecognize($config, $audio);
 * } finally {
 *     $speechClient->close();
 * }
 * ```
 *
 * @experimental
 */
class SpeechClient
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
    private $speechStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getLongRunningDescriptors()
    {
        return [
            'asyncRecognize' => [
                'operationReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeResponse',
                'metadataReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeMetadata',
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
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\GAX\LongRunning\OperationsClient
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
     * @return \Google\GAX\OperationResponse
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

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'speech.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Speech API.
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

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['timeoutMillis']);
            unset($operationsClientOptions['retryingOverride']);
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
            'syncRecognize' => $defaultDescriptors,
            'asyncRecognize' => $defaultDescriptors,
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

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/speech_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.speech.v1beta1.Speech',
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

        $createSpeechStubFunction = function ($hostname, $opts) {
            return new SpeechGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createSpeechStubFunction', $options)) {
            $createSpeechStubFunction = $options['createSpeechStubFunction'];
        }
        $this->speechStub = $this->grpcCredentialsHelper->createStub(
            $createSpeechStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
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
     *     $sampleRate = 44100;
     *     $config = new RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRate($sampleRate);
     *     $uri = "gs://bucket_name/file_name.flac";
     *     $audio = new RecognitionAudio();
     *     $audio->setUri($uri);
     *     $response = $speechClient->syncRecognize($config, $audio);
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Cloud\Speech\V1beta1\SyncRecognizeResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function syncRecognize($config, $audio, $optionalArgs = [])
    {
        $request = new SyncRecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        $mergedSettings = $this->defaultCallSettings['syncRecognize']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->speechStub,
            'SyncRecognize',
            $mergedSettings,
            $this->descriptors['syncRecognize']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Performs asynchronous speech recognition: receive results via the
     * [google.longrunning.Operations]
     * (/speech/reference/rest/v1beta1/operations#Operation)
     * interface. Returns either an
     * `Operation.error` or an `Operation.response` which contains
     * an `AsyncRecognizeResponse` message.
     *
     * Sample code:
     * ```
     * try {
     *     $speechClient = new SpeechClient();
     *     $encoding = AudioEncoding::FLAC;
     *     $sampleRate = 44100;
     *     $config = new RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRate($sampleRate);
     *     $uri = "gs://bucket_name/file_name.flac";
     *     $audio = new RecognitionAudio();
     *     $audio->setUri($uri);
     *     $operationResponse = $speechClient->asyncRecognize($config, $audio);
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
     *     $operationResponse = $speechClient->asyncRecognize($config, $audio);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $speechClient->resumeOperation($operationName, 'asyncRecognize');
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Longrunning\Operation
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function asyncRecognize($config, $audio, $optionalArgs = [])
    {
        $request = new AsyncRecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        $mergedSettings = $this->defaultCallSettings['asyncRecognize']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->speechStub,
            'AsyncRecognize',
            $mergedSettings,
            $this->descriptors['asyncRecognize']
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
     * @return \Google\GAX\BidiStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function streamingRecognize($optionalArgs = [])
    {
        $mergedSettings = $this->defaultCallSettings['streamingRecognize']->merge(
            new CallSettings($optionalArgs)
        );
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
