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
 * https://github.com/google/googleapis/blob/master/google/devtools/clouddebugger/v2/debugger.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Debugger\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\DeleteBreakpointRequest;
use Google\Cloud\Debugger\V2\GetBreakpointRequest;
use Google\Cloud\Debugger\V2\GetBreakpointResponse;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest\BreakpointActionValue;
use Google\Cloud\Debugger\V2\ListBreakpointsResponse;
use Google\Cloud\Debugger\V2\ListDebuggeesRequest;
use Google\Cloud\Debugger\V2\ListDebuggeesResponse;
use Google\Cloud\Debugger\V2\SetBreakpointRequest;
use Google\Cloud\Debugger\V2\SetBreakpointResponse;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The Debugger service provides the API that allows users to collect run-time
 * information from a running application, without stopping or slowing it down
 * and without modifying its state.  An application may include one or
 * more replicated processes performing the same work.
 *
 * A debugged application is represented using the Debuggee concept. The
 * Debugger service provides a way to query for available debuggees, but does
 * not provide a way to create one.  A debuggee is created using the Controller
 * service, usually by running a debugger agent with the application.
 *
 * The Debugger service enables the client to set one or more Breakpoints on a
 * Debuggee and collect the results of the set Breakpoints.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $debugger2Client = new Debugger2Client();
 * try {
 *     $debuggeeId = '';
 *     $breakpoint = new Breakpoint();
 *     $clientVersion = '';
 *     $response = $debugger2Client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
 * } finally {
 *     $debugger2Client->close();
 * }
 * ```
 *
 * @experimental
 */
class Debugger2GapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.devtools.clouddebugger.v2.Debugger2';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'clouddebugger.googleapis.com';

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
        'https://www.googleapis.com/auth/cloud_debugger',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/debugger2_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/debugger2_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/debugger2_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/debugger2_rest_client_config.php',
                ],
            ],
        ];
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
     *           as "<uri>:<port>". Default 'clouddebugger.googleapis.com:443'.
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
    }

    /**
     * Sets the breakpoint to the debuggee.
     *
     * Sample code:
     * ```
     * $debugger2Client = new Debugger2Client();
     * try {
     *     $debuggeeId = '';
     *     $breakpoint = new Breakpoint();
     *     $clientVersion = '';
     *     $response = $debugger2Client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
     * } finally {
     *     $debugger2Client->close();
     * }
     * ```
     *
     * @param string     $debuggeeId    ID of the debuggee where the breakpoint is to be set.
     * @param Breakpoint $breakpoint    Breakpoint specification to set.
     *                                  The field `location` of the breakpoint must be set.
     * @param string     $clientVersion The client version making the call.
     *                                  Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * @param array      $optionalArgs  {
     *                                  Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\SetBreakpointResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setBreakpoint($debuggeeId, $breakpoint, $clientVersion, array $optionalArgs = [])
    {
        $request = new SetBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpoint($breakpoint);
        $request->setClientVersion($clientVersion);

        $requestParams = new RequestParamsHeaderDescriptor([
          'debuggee_id' => $request->getDebuggeeId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetBreakpoint',
            SetBreakpointResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets breakpoint information.
     *
     * Sample code:
     * ```
     * $debugger2Client = new Debugger2Client();
     * try {
     *     $debuggeeId = '';
     *     $breakpointId = '';
     *     $clientVersion = '';
     *     $response = $debugger2Client->getBreakpoint($debuggeeId, $breakpointId, $clientVersion);
     * } finally {
     *     $debugger2Client->close();
     * }
     * ```
     *
     * @param string $debuggeeId    ID of the debuggee whose breakpoint to get.
     * @param string $breakpointId  ID of the breakpoint to get.
     * @param string $clientVersion The client version making the call.
     *                              Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\GetBreakpointResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getBreakpoint($debuggeeId, $breakpointId, $clientVersion, array $optionalArgs = [])
    {
        $request = new GetBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpointId($breakpointId);
        $request->setClientVersion($clientVersion);

        return $this->startCall(
            'GetBreakpoint',
            GetBreakpointResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the breakpoint from the debuggee.
     *
     * Sample code:
     * ```
     * $debugger2Client = new Debugger2Client();
     * try {
     *     $debuggeeId = '';
     *     $breakpointId = '';
     *     $clientVersion = '';
     *     $debugger2Client->deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion);
     * } finally {
     *     $debugger2Client->close();
     * }
     * ```
     *
     * @param string $debuggeeId    ID of the debuggee whose breakpoint to delete.
     * @param string $breakpointId  ID of the breakpoint to delete.
     * @param string $clientVersion The client version making the call.
     *                              Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion, array $optionalArgs = [])
    {
        $request = new DeleteBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpointId($breakpointId);
        $request->setClientVersion($clientVersion);

        return $this->startCall(
            'DeleteBreakpoint',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all breakpoints for the debuggee.
     *
     * Sample code:
     * ```
     * $debugger2Client = new Debugger2Client();
     * try {
     *     $debuggeeId = '';
     *     $clientVersion = '';
     *     $response = $debugger2Client->listBreakpoints($debuggeeId, $clientVersion);
     * } finally {
     *     $debugger2Client->close();
     * }
     * ```
     *
     * @param string $debuggeeId    ID of the debuggee whose breakpoints to list.
     * @param string $clientVersion The client version making the call.
     *                              Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type bool $includeAllUsers
     *          When set to `true`, the response includes the list of breakpoints set by
     *          any user. Otherwise, it includes only breakpoints set by the caller.
     *     @type bool $includeInactive
     *          When set to `true`, the response includes active and inactive
     *          breakpoints. Otherwise, it includes only active breakpoints.
     *     @type BreakpointActionValue $action
     *          When set, the response includes only breakpoints with the specified action.
     *     @type bool $stripResults
     *          This field is deprecated. The following fields are always stripped out of
     *          the result: `stack_frames`, `evaluated_expressions` and `variable_table`.
     *     @type string $waitToken
     *          A wait token that, if specified, blocks the call until the breakpoints
     *          list has changed, or a server selected timeout has expired.  The value
     *          should be set from the last response. The error code
     *          `google.rpc.Code.ABORTED` (RPC) is returned on wait timeout, which
     *          should be called again with the same `wait_token`.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListBreakpointsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listBreakpoints($debuggeeId, $clientVersion, array $optionalArgs = [])
    {
        $request = new ListBreakpointsRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setClientVersion($clientVersion);
        if (isset($optionalArgs['includeAllUsers'])) {
            $request->setIncludeAllUsers($optionalArgs['includeAllUsers']);
        }
        if (isset($optionalArgs['includeInactive'])) {
            $request->setIncludeInactive($optionalArgs['includeInactive']);
        }
        if (isset($optionalArgs['action'])) {
            $request->setAction($optionalArgs['action']);
        }
        if (isset($optionalArgs['stripResults'])) {
            $request->setStripResults($optionalArgs['stripResults']);
        }
        if (isset($optionalArgs['waitToken'])) {
            $request->setWaitToken($optionalArgs['waitToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'debuggee_id' => $request->getDebuggeeId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListBreakpoints',
            ListBreakpointsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all the debuggees that the user has access to.
     *
     * Sample code:
     * ```
     * $debugger2Client = new Debugger2Client();
     * try {
     *     $project = '';
     *     $clientVersion = '';
     *     $response = $debugger2Client->listDebuggees($project, $clientVersion);
     * } finally {
     *     $debugger2Client->close();
     * }
     * ```
     *
     * @param string $project       Project number of a Google Cloud project whose debuggees to list.
     * @param string $clientVersion The client version making the call.
     *                              Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type bool $includeInactive
     *          When set to `true`, the result includes all debuggees. Otherwise, the
     *          result includes only debuggees that are active.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListDebuggeesResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listDebuggees($project, $clientVersion, array $optionalArgs = [])
    {
        $request = new ListDebuggeesRequest();
        $request->setProject($project);
        $request->setClientVersion($clientVersion);
        if (isset($optionalArgs['includeInactive'])) {
            $request->setIncludeInactive($optionalArgs['includeInactive']);
        }

        return $this->startCall(
            'ListDebuggees',
            ListDebuggeesResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
