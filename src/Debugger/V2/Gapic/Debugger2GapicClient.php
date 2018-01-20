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
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Debugger\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\DeleteBreakpointRequest;
use Google\Cloud\Debugger\V2\GetBreakpointRequest;
use Google\Cloud\Debugger\V2\GetBreakpointResponse;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest_BreakpointActionValue;
use Google\Cloud\Debugger\V2\ListBreakpointsResponse;
use Google\Cloud\Debugger\V2\ListDebuggeesRequest;
use Google\Cloud\Debugger\V2\ListDebuggeesResponse;
use Google\Cloud\Debugger\V2\SetBreakpointRequest;
use Google\Cloud\Debugger\V2\SetBreakpointResponse;
use Google\Protobuf\GPBEmpty;
use Grpc\Channel;
use Grpc\ChannelCredentials;

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
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/cloud_debugger',
            ],
            'clientConfigPath' => __DIR__.'/../resources/debugger2_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/debugger2_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/debugger2_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'clouddebugger.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
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
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Stackdriver Debugger API.
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
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $this->setClientOptions($options + self::getClientDefaults());
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
    public function setBreakpoint($debuggeeId, $breakpoint, $clientVersion, $optionalArgs = [])
    {
        $request = new SetBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpoint($breakpoint);
        $request->setClientVersion($clientVersion);

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
    public function getBreakpoint($debuggeeId, $breakpointId, $clientVersion, $optionalArgs = [])
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
    public function deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion, $optionalArgs = [])
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
     *     @type ListBreakpointsRequest_BreakpointActionValue $action
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
    public function listBreakpoints($debuggeeId, $clientVersion, $optionalArgs = [])
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
    public function listDebuggees($project, $clientVersion, $optionalArgs = [])
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
