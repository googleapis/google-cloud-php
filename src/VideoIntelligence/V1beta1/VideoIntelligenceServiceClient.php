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
 * https://github.com/google/googleapis/blob/master/google/cloud/videointelligence/v1beta1/video_intelligence.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\VideoIntelligence\V1beta1;

use Google\Cloud\Videointelligence\V1beta1\AnnotateVideoProgress;
use Google\Cloud\Videointelligence\V1beta1\AnnotateVideoRequest;
use Google\Cloud\Videointelligence\V1beta1\AnnotateVideoResponse;
use Google\Cloud\Videointelligence\V1beta1\Feature;
use Google\Cloud\Videointelligence\V1beta1\VideoContext;
use Google\Cloud\Videointelligence\V1beta1\VideoIntelligenceServiceGrpcClient;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\LongRunning\OperationsClient;
use Google\GAX\OperationResponse;

/**
 * Service Description: Service that implements Google Cloud Video Intelligence API.
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
 *     $videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();
 *     $inputUri = "";
 *     $features = [];
 *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
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
 *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
 *     $operationName = $operationResponse->getName();
 *     // ... do other work
 *     $newOperationResponse = $videoIntelligenceServiceClient->resumeOperation($operationName, 'annotateVideo');
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
 *     $videoIntelligenceServiceClient->close();
 * }
 * ```
 *
 * @experimental
 */
class VideoIntelligenceServiceClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'videointelligence.googleapis.com';

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
    private $videoIntelligenceServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getLongRunningDescriptors()
    {
        return [
            'annotateVideo' => [
                'operationReturnType' => '\Google\Cloud\Videointelligence\V1beta1\AnnotateVideoResponse',
                'metadataReturnType' => '\Google\Cloud\Videointelligence\V1beta1\AnnotateVideoProgress',
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
     *                                  Default 'videointelligence.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Video Intelligence API.
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
            'annotateVideo' => $defaultDescriptors,
        ];
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/video_intelligence_service_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.videointelligence.v1beta1.VideoIntelligenceService',
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

        $createVideoIntelligenceServiceStubFunction = function ($hostname, $opts) {
            return new VideoIntelligenceServiceGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createVideoIntelligenceServiceStubFunction', $options)) {
            $createVideoIntelligenceServiceStubFunction = $options['createVideoIntelligenceServiceStubFunction'];
        }
        $this->videoIntelligenceServiceStub = $this->grpcCredentialsHelper->createStub(
            $createVideoIntelligenceServiceStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Performs asynchronous video annotation. Progress and results can be
     * retrieved through the `google.longrunning.Operations` interface.
     * `Operation.metadata` contains `AnnotateVideoProgress` (progress).
     * `Operation.response` contains `AnnotateVideoResponse` (results).
     *
     * Sample code:
     * ```
     * try {
     *     $videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();
     *     $inputUri = "";
     *     $features = [];
     *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
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
     *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $videoIntelligenceServiceClient->resumeOperation($operationName, 'annotateVideo');
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
     *     $videoIntelligenceServiceClient->close();
     * }
     * ```
     *
     * @param string $inputUri     Input video location. Currently, only
     *                             [Google Cloud Storage](https://cloud.google.com/storage/) URIs are
     *                             supported, which must be specified in the following format:
     *                             `gs://bucket-id/object-id` (other URI formats return
     *                             [google.rpc.Code.INVALID_ARGUMENT][google.rpc.Code.INVALID_ARGUMENT]). For more information, see
     *                             [Request URIs](https://cloud.google.com/storage/docs/reference-uris).
     *                             A video URI may include wildcards in `object-id`, and thus identify
     *                             multiple videos. Supported wildcards: '*' to match 0 or more characters;
     *                             '?' to match 1 character. If unset, the input video should be embedded
     *                             in the request as `input_content`. If set, `input_content` should be unset.
     * @param int[]  $features     Requested video annotation features.
     *                             For allowed values, use constants defined on {@see \Google\Cloud\Videointelligence\V1beta1\Feature}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $inputContent
     *          The video data bytes. Encoding: base64. If unset, the input video(s)
     *          should be specified via `input_uri`. If set, `input_uri` should be unset.
     *     @type VideoContext $videoContext
     *          Additional video context and/or feature-specific parameters.
     *     @type string $outputUri
     *          Optional location where the output (in JSON format) should be stored.
     *          Currently, only [Google Cloud Storage](https://cloud.google.com/storage/)
     *          URIs are supported, which must be specified in the following format:
     *          `gs://bucket-id/object-id` (other URI formats return
     *          [google.rpc.Code.INVALID_ARGUMENT][google.rpc.Code.INVALID_ARGUMENT]). For more information, see
     *          [Request URIs](https://cloud.google.com/storage/docs/reference-uris).
     *     @type string $locationId
     *          Optional cloud region where annotation should take place. Supported cloud
     *          regions: `us-east1`, `us-west1`, `europe-west1`, `asia-east1`. If no region
     *          is specified, a region will be determined based on video file location.
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
    public function annotateVideo($inputUri, $features, $optionalArgs = [])
    {
        $request = new AnnotateVideoRequest();
        $request->setInputUri($inputUri);
        $request->setFeatures($features);
        if (isset($optionalArgs['inputContent'])) {
            $request->setInputContent($optionalArgs['inputContent']);
        }
        if (isset($optionalArgs['videoContext'])) {
            $request->setVideoContext($optionalArgs['videoContext']);
        }
        if (isset($optionalArgs['outputUri'])) {
            $request->setOutputUri($optionalArgs['outputUri']);
        }
        if (isset($optionalArgs['locationId'])) {
            $request->setLocationId($optionalArgs['locationId']);
        }

        $mergedSettings = $this->defaultCallSettings['annotateVideo']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->videoIntelligenceServiceStub,
            'AnnotateVideo',
            $mergedSettings,
            $this->descriptors['annotateVideo']
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
        $this->videoIntelligenceServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
