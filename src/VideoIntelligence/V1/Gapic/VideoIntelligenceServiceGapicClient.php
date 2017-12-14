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
 * https://github.com/google/googleapis/blob/master/google/cloud/videointelligence/v1/video_intelligence.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\VideoIntelligence\V1\Gapic;

use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Transport\ApiTransportInterface;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoProgress;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoRequest;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoResponse;
use Google\Cloud\VideoIntelligence\V1\Feature;
use Google\Cloud\VideoIntelligence\V1\VideoContext;
use Google\LongRunning\Operation;

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
 *
 *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo();
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
 *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo();
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
class VideoIntelligenceServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.videointelligence.v1.VideoIntelligenceService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'videointelligence.googleapis.com';

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
        'clientConfigPath' => __DIR__.'/../resources/video_intelligence_service_client_config.json',
        'restClientConfigPath' => __DIR__.'/../resources/video_intelligence_service_rest_client_config.php',
        'descriptorsConfigPath' => __DIR__.'/../resources/video_intelligence_service_descriptor_config.php',
    ];

    private $operationsClient;

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
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
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
     *                                  Default 'videointelligence.googleapis.com'.
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
     *                          Defaults to the scopes for the Cloud Video Intelligence API.
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
        $options += self::$clientDefaults;
        $this->setClientOptions($options);
        $this->pluckArray([
            'serviceName',
            'clientConfigPath',
            'restClientConfigPath',
            'descriptorsConfigPath',
        ], $options);
        $this->operationsClient = new OperationsClient($options);
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
     *
     *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo();
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
     *     $operationResponse = $videoIntelligenceServiceClient->annotateVideo();
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
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $inputUri
     *          Input video location. Currently, only
     *          [Google Cloud Storage](https://cloud.google.com/storage/) URIs are
     *          supported, which must be specified in the following format:
     *          `gs://bucket-id/object-id` (other URI formats return
     *          [google.rpc.Code.INVALID_ARGUMENT][google.rpc.Code.INVALID_ARGUMENT]). For more information, see
     *          [Request URIs](https://cloud.google.com/storage/docs/reference-uris).
     *          A video URI may include wildcards in `object-id`, and thus identify
     *          multiple videos. Supported wildcards: '*' to match 0 or more characters;
     *          '?' to match 1 character. If unset, the input video should be embedded
     *          in the request as `input_content`. If set, `input_content` should be unset.
     *     @type string $inputContent
     *          The video data bytes.
     *          If unset, the input video(s) should be specified via `input_uri`.
     *          If set, `input_uri` should be unset.
     *     @type int[] $features
     *          Requested video annotation features.
     *          For allowed values, use constants defined on {@see \Google\Cloud\VideoIntelligence\V1\Feature}
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
    public function annotateVideo($optionalArgs = [])
    {
        $request = new AnnotateVideoRequest();
        if (isset($optionalArgs['inputUri'])) {
            $request->setInputUri($optionalArgs['inputUri']);
        }
        if (isset($optionalArgs['inputContent'])) {
            $request->setInputContent($optionalArgs['inputContent']);
        }
        if (isset($optionalArgs['features'])) {
            $request->setFeatures($optionalArgs['features']);
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

        return $this->startOperationsCall(
            new Call(
                self::SERVICE_NAME.'/AnnotateVideo',
                Operation::class,
                $request
            ),
            $this->configureCallSettings('annotateVideo', $optionalArgs),
            $this->descriptors['annotateVideo']['longRunning'] + [
                'operationsClient' => $this->getOperationsClient(),
            ]
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
