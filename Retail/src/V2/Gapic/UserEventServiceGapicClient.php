<?php
/*
 * Copyright 2021 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/retail/v2/user_event_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Retail\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Api\HttpBody;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Retail\V2\CollectUserEventRequest;
use Google\Cloud\Retail\V2\ImportErrorsConfig;
use Google\Cloud\Retail\V2\ImportMetadata;
use Google\Cloud\Retail\V2\ImportUserEventsRequest;
use Google\Cloud\Retail\V2\PurgeUserEventsRequest;
use Google\Cloud\Retail\V2\RejoinUserEventsRequest;
use Google\Cloud\Retail\V2\RejoinUserEventsRequest\UserEventRejoinScope;
use Google\Cloud\Retail\V2\UserEvent;
use Google\Cloud\Retail\V2\UserEventInputConfig;
use Google\Cloud\Retail\V2\WriteUserEventRequest;
use Google\LongRunning\Operation;

/**
 * Service Description: Service for ingesting end user actions on the customer website.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $userEventServiceClient = new UserEventServiceClient();
 * try {
 *     $parent = '';
 *     $userEvent = new UserEvent();
 *     $response = $userEventServiceClient->writeUserEvent($parent, $userEvent);
 * } finally {
 *     $userEventServiceClient->close();
 * }
 * ```
 *
 * @experimental
 */
class UserEventServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.retail.v2.UserEventService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'retail.googleapis.com';

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
    ];

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/user_event_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/user_event_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/user_event_service_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/user_event_service_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
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
     * @return OperationResponse
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
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'retail.googleapis.com:443'.
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Writes a single user event.
     *
     * Sample code:
     * ```
     * $userEventServiceClient = new UserEventServiceClient();
     * try {
     *     $parent = '';
     *     $userEvent = new UserEvent();
     *     $response = $userEventServiceClient->writeUserEvent($parent, $userEvent);
     * } finally {
     *     $userEventServiceClient->close();
     * }
     * ```
     *
     * @param string    $parent       Required. The parent catalog resource name, such as
     *                                `projects/1234/locations/global/catalogs/default_catalog`.
     * @param UserEvent $userEvent    Required. User event to write.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Retail\V2\UserEvent
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function writeUserEvent($parent, $userEvent, array $optionalArgs = [])
    {
        $request = new WriteUserEventRequest();
        $request->setParent($parent);
        $request->setUserEvent($userEvent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'WriteUserEvent',
            UserEvent::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Writes a single user event from the browser. This uses a GET request to
     * due to browser restriction of POST-ing to a 3rd party domain.
     *
     * This method is used only by the Retail API JavaScript pixel and Google Tag
     * Manager. Users should not call this method directly.
     *
     * Sample code:
     * ```
     * $userEventServiceClient = new UserEventServiceClient();
     * try {
     *     $parent = '';
     *     $userEvent = '';
     *     $response = $userEventServiceClient->collectUserEvent($parent, $userEvent);
     * } finally {
     *     $userEventServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The parent catalog name, such as
     *                             `projects/1234/locations/global/catalogs/default_catalog`.
     * @param string $userEvent    Required. URL encoded UserEvent proto with a length limit of 2,000,000
     *                             characters.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $uri
     *          The URL including cgi-parameters but excluding the hash fragment with a
     *          length limit of 5,000 characters. This is often more useful than the
     *          referer URL, because many browsers only send the domain for 3rd party
     *          requests.
     *     @type int $ets
     *          The event timestamp in milliseconds. This prevents browser caching of
     *          otherwise identical get requests. The name is abbreviated to reduce the
     *          payload bytes.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\HttpBody
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function collectUserEvent($parent, $userEvent, array $optionalArgs = [])
    {
        $request = new CollectUserEventRequest();
        $request->setParent($parent);
        $request->setUserEvent($userEvent);
        if (isset($optionalArgs['uri'])) {
            $request->setUri($optionalArgs['uri']);
        }
        if (isset($optionalArgs['ets'])) {
            $request->setEts($optionalArgs['ets']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CollectUserEvent',
            HttpBody::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes permanently all user events specified by the filter provided.
     * Depending on the number of events specified by the filter, this operation
     * could take hours or days to complete. To test a filter, use the list
     * command first.
     *
     * Sample code:
     * ```
     * $userEventServiceClient = new UserEventServiceClient();
     * try {
     *     $parent = '';
     *     $filter = '';
     *     $operationResponse = $userEventServiceClient->purgeUserEvents($parent, $filter);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $userEventServiceClient->purgeUserEvents($parent, $filter);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $userEventServiceClient->resumeOperation($operationName, 'purgeUserEvents');
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
     *     $userEventServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The resource name of the catalog under which the events are
     *                       created. The format is
     *                       "projects/${projectId}/locations/global/catalogs/${catalogId}"
     * @param string $filter Required. The filter string to specify the events to be deleted with a
     *                       length limit of 5,000 characters. Empty string filter is not allowed. The
     *                       eligible fields for filtering are:
     *
     * * `eventType`: Double quoted
     * [UserEvent.event_type][google.cloud.retail.v2.UserEvent.event_type] string.
     * * `eventTime`: in ISO 8601 "zulu" format.
     * * `visitorId`: Double quoted string. Specifying this will delete all
     *   events associated with a visitor.
     * * `userId`: Double quoted string. Specifying this will delete all events
     *   associated with a user.
     *
     * Examples:
     *
     * * Deleting all events in a time range:
     *   `eventTime > "2012-04-23T18:25:43.511Z"
     *   eventTime < "2012-04-23T18:30:43.511Z"`
     * * Deleting specific eventType in time range:
     *   `eventTime > "2012-04-23T18:25:43.511Z" eventType = "detail-page-view"`
     * * Deleting all events for a specific visitor:
     *   `visitorId = "visitor1024"`
     *
     * The filtering fields are assumed to have an implicit AND.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type bool $force
     *          Actually perform the purge.
     *          If `force` is set to false, the method will return the expected purge count
     *          without deleting any user events.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function purgeUserEvents($parent, $filter, array $optionalArgs = [])
    {
        $request = new PurgeUserEventsRequest();
        $request->setParent($parent);
        $request->setFilter($filter);
        if (isset($optionalArgs['force'])) {
            $request->setForce($optionalArgs['force']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'PurgeUserEvents',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Bulk import of User events. Request processing might be
     * synchronous. Events that already exist are skipped.
     * Use this method for backfilling historical user events.
     *
     * Operation.response is of type ImportResponse. Note that it is
     * possible for a subset of the items to be successfully inserted.
     * Operation.metadata is of type ImportMetadata.
     *
     * Sample code:
     * ```
     * $userEventServiceClient = new UserEventServiceClient();
     * try {
     *     $parent = '';
     *     $inputConfig = new UserEventInputConfig();
     *     $operationResponse = $userEventServiceClient->importUserEvents($parent, $inputConfig);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $userEventServiceClient->importUserEvents($parent, $inputConfig);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $userEventServiceClient->resumeOperation($operationName, 'importUserEvents');
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
     *     $userEventServiceClient->close();
     * }
     * ```
     *
     * @param string               $parent       Required. `projects/1234/locations/global/catalogs/default_catalog`
     * @param UserEventInputConfig $inputConfig  Required. The desired input location of the data.
     * @param array                $optionalArgs {
     *                                           Optional.
     *
     *     @type ImportErrorsConfig $errorsConfig
     *          The desired location of errors incurred during the Import. Cannot be set
     *          for inline user event imports.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function importUserEvents($parent, $inputConfig, array $optionalArgs = [])
    {
        $request = new ImportUserEventsRequest();
        $request->setParent($parent);
        $request->setInputConfig($inputConfig);
        if (isset($optionalArgs['errorsConfig'])) {
            $request->setErrorsConfig($optionalArgs['errorsConfig']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ImportUserEvents',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Triggers a user event rejoin operation with latest product catalog. Events
     * will not be annotated with detailed product information if product is
     * missing from the catalog at the time the user event is ingested, and these
     * events are stored as unjoined events with a limited usage on training and
     * serving. This API can be used to trigger a 'join' operation on specified
     * events with latest version of product catalog. It can also be used to
     * correct events joined with wrong product catalog.
     *
     * Sample code:
     * ```
     * $userEventServiceClient = new UserEventServiceClient();
     * try {
     *     $parent = '';
     *     $operationResponse = $userEventServiceClient->rejoinUserEvents($parent);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $userEventServiceClient->rejoinUserEvents($parent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $userEventServiceClient->resumeOperation($operationName, 'rejoinUserEvents');
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
     *     $userEventServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The parent catalog resource name, such as
     *                             `projects/1234/locations/global/catalogs/default_catalog`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $userEventRejoinScope
     *          The type of the user event rejoin to define the scope and range of the user
     *          events to be rejoined with the latest product catalog. Defaults to
     *          USER_EVENT_REJOIN_SCOPE_UNSPECIFIED if this field is not set, or set to an
     *          invalid integer value.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Retail\V2\RejoinUserEventsRequest\UserEventRejoinScope}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function rejoinUserEvents($parent, array $optionalArgs = [])
    {
        $request = new RejoinUserEventsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['userEventRejoinScope'])) {
            $request->setUserEventRejoinScope($optionalArgs['userEventRejoinScope']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'RejoinUserEvents',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}
