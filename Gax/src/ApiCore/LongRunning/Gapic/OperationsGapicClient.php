<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google LLC nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/longrunning/operations.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\ApiCore\LongRunning\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\ValidationException;
use Google\Cloud\Version;
use Google\LongRunning\CancelOperationRequest;
use Google\LongRunning\DeleteOperationRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\OperationsGrpcClient;

/**
 * Service Description: Manages long-running operations with an API service.
 *
 * When an API method normally takes long time to complete, it can be designed
 * to return [Operation][google.longrunning.Operation] to the client, and the client can use this
 * interface to receive the real response asynchronously by polling the
 * operation resource, or pass the operation resource to another API (such as
 * Google Cloud Pub/Sub API) to receive the response.  Any API service that
 * returns long-running operations should implement the `Operations` interface
 * so developers can have a consistent client experience.
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
 *     $options = [
 *         'serviceAddress' => 'my-service-address',
 *         'scopes' => ['my-service-scope'],
 *     ];
 *     $operationsClient = new OperationsClient($options);
 *     $name = '';
 *     $response = $operationsClient->getOperation($name);
 * } finally {
 *     if (isset($operationsClient)) {
 *         $operationsClient->close();
 *     }
 * }
 * ```
 *
 * @experimental
 */
class OperationsGapicClient
{
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
    protected $operationsStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    private static function getPageStreamingDescriptors()
    {
        $listOperationsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOperations',
                ]);

        $pageStreamingDescriptors = [
            'listOperations' => $listOperationsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
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
     * Constructor.
     *
     * @param array $options {
     *                       Required. Options for configuring the service API wrapper. Those options
     *                       that must be provided are marked as Required.
     *
     *     @type string $serviceAddress Required. The domain name of the API remote host.
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
     *     @type array $scopes Required. A string array of scopes to use when acquiring credentials.
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
     *
     * @throws ValidationException Throws a ValidationException if required arguments are missing
     *                             from the $options array.
     * @experimental
     */
    public function __construct($options = [])
    {
        if (!array_key_exists('serviceAddress', $options)) {
            throw new ValidationException("The 'serviceAddress' option must be provided.");
        }
        if (!array_key_exists('scopes', $options)) {
            throw new ValidationException("The 'scopes' option must be provided.");
        }
        $defaultOptions = [
            'port' => self::DEFAULT_SERVICE_PORT,
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/operations_client_config.json',
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
            'getOperation' => $defaultDescriptors,
            'listOperations' => $defaultDescriptors,
            'cancelOperation' => $defaultDescriptors,
            'deleteOperation' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.longrunning.Operations',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createOperationsStubFunction = function ($hostname, $opts, $channel) {
            return new OperationsGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createOperationsStubFunction', $options)) {
            $createOperationsStubFunction = $options['createOperationsStubFunction'];
        }
        $this->operationsStub = $this->grpcCredentialsHelper->createStub($createOperationsStubFunction);
    }

    /**
     * Gets the latest state of a long-running operation.  Clients can use this
     * method to poll the operation result at intervals as recommended by the API
     * service.
     *
     * Sample code:
     * ```
     * try {
     *     $options = [
     *         'serviceAddress' => 'my-service-address',
     *         'scopes' => ['my-service-scope'],
     *     ];
     *     $operationsClient = new OperationsClient($options);
     *     $name = '';
     *     $response = $operationsClient->getOperation($name);
     * } finally {
     *     if (isset($operationsClient)) {
     *         $operationsClient->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the operation resource.
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
     * @return \Google\LongRunning\Operation
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getOperation($name, $optionalArgs = [])
    {
        $request = new GetOperationRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->operationsStub,
            'GetOperation',
            $mergedSettings,
            $this->descriptors['getOperation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists operations that match the specified filter in the request. If the
     * server doesn't support this method, it returns `UNIMPLEMENTED`.
     *
     * NOTE: the `name` binding below allows API services to override the binding
     * to use different resource name schemes, such as `users/&#42;/operations`.
     *
     * Sample code:
     * ```
     * try {
     *     $options = [
     *         'serviceAddress' => 'my-service-address',
     *         'scopes' => ['my-service-scope'],
     *     ];
     *     $operationsClient = new OperationsClient($options);
     *     $name = '';
     *     $filter = '';
     *     // Iterate through all elements
     *     $pagedResponse = $operationsClient->listOperations($name, $filter);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $operationsClient->listOperations($name, $filter);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     if (isset($operationsClient)) {
     *         $operationsClient->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the operation collection.
     * @param string $filter       The standard list filter.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listOperations($name, $filter, $optionalArgs = [])
    {
        $request = new ListOperationsRequest();
        $request->setName($name);
        $request->setFilter($filter);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listOperations'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->operationsStub,
            'ListOperations',
            $mergedSettings,
            $this->descriptors['listOperations']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Starts asynchronous cancellation on a long-running operation.  The server
     * makes a best effort to cancel the operation, but success is not
     * guaranteed.  If the server doesn't support this method, it returns
     * `google.rpc.Code.UNIMPLEMENTED`.  Clients can use
     * [Operations.GetOperation][google.longrunning.Operations.GetOperation] or
     * other methods to check whether the cancellation succeeded or whether the
     * operation completed despite cancellation. On successful cancellation,
     * the operation is not deleted; instead, it becomes an operation with
     * an [Operation.error][google.longrunning.Operation.error] value with a [google.rpc.Status.code][google.rpc.Status.code] of 1,
     * corresponding to `Code.CANCELLED`.
     *
     * Sample code:
     * ```
     * try {
     *     $options = [
     *         'serviceAddress' => 'my-service-address',
     *         'scopes' => ['my-service-scope'],
     *     ];
     *     $operationsClient = new OperationsClient($options);
     *     $name = '';
     *     $operationsClient->cancelOperation($name);
     * } finally {
     *     if (isset($operationsClient)) {
     *         $operationsClient->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the operation resource to be cancelled.
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
    public function cancelOperation($name, $optionalArgs = [])
    {
        $request = new CancelOperationRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['cancelOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->operationsStub,
            'CancelOperation',
            $mergedSettings,
            $this->descriptors['cancelOperation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a long-running operation. This method indicates that the client is
     * no longer interested in the operation result. It does not cancel the
     * operation. If the server doesn't support this method, it returns
     * `google.rpc.Code.UNIMPLEMENTED`.
     *
     * Sample code:
     * ```
     * try {
     *     $options = [
     *         'serviceAddress' => 'my-service-address',
     *         'scopes' => ['my-service-scope'],
     *     ];
     *     $operationsClient = new OperationsClient($options);
     *     $name = '';
     *     $operationsClient->deleteOperation($name);
     * } finally {
     *     if (isset($operationsClient)) {
     *         $operationsClient->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the operation resource to be deleted.
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
    public function deleteOperation($name, $optionalArgs = [])
    {
        $request = new DeleteOperationRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->operationsStub,
            'DeleteOperation',
            $mergedSettings,
            $this->descriptors['deleteOperation']
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
        $this->operationsStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
