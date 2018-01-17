<?php
/*
 * Copyright 2017 Google LLC
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
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Debugger\V2\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Debugger2GrpcClient;
use Google\Cloud\Debugger\V2\DeleteBreakpointRequest;
use Google\Cloud\Debugger\V2\GetBreakpointRequest;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest;
use Google\Cloud\Debugger\V2\ListBreakpointsRequest_BreakpointActionValue as BreakpointActionValue;
use Google\Cloud\Debugger\V2\ListDebuggeesRequest;
use Google\Cloud\Debugger\V2\SetBreakpointRequest;
use Google\Cloud\Version;

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
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
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

    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $debugger2Stub;
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
     *                                  Default 'clouddebugger.googleapis.com'.
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
                'https://www.googleapis.com/auth/cloud_debugger',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/debugger2_client_config.json',
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
            'setBreakpoint' => $defaultDescriptors,
            'getBreakpoint' => $defaultDescriptors,
            'deleteBreakpoint' => $defaultDescriptors,
            'listBreakpoints' => $defaultDescriptors,
            'listDebuggees' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.devtools.clouddebugger.v2.Debugger2',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createDebugger2StubFunction = function ($hostname, $opts, $channel) {
            return new Debugger2GrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createDebugger2StubFunction', $options)) {
            $createDebugger2StubFunction = $options['createDebugger2StubFunction'];
        }
        $this->debugger2Stub = $this->grpcCredentialsHelper->createStub($createDebugger2StubFunction);
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\SetBreakpointResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function setBreakpoint($debuggeeId, $breakpoint, $clientVersion, $optionalArgs = [])
    {
        $request = new SetBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpoint($breakpoint);
        $request->setClientVersion($clientVersion);

        $defaultCallSettings = $this->defaultCallSettings['setBreakpoint'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->debugger2Stub,
            'SetBreakpoint',
            $mergedSettings,
            $this->descriptors['setBreakpoint']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\GetBreakpointResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getBreakpoint($debuggeeId, $breakpointId, $clientVersion, $optionalArgs = [])
    {
        $request = new GetBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpointId($breakpointId);
        $request->setClientVersion($clientVersion);

        $defaultCallSettings = $this->defaultCallSettings['getBreakpoint'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->debugger2Stub,
            'GetBreakpoint',
            $mergedSettings,
            $this->descriptors['getBreakpoint']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
    public function deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion, $optionalArgs = [])
    {
        $request = new DeleteBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpointId($breakpointId);
        $request->setClientVersion($clientVersion);

        $defaultCallSettings = $this->defaultCallSettings['deleteBreakpoint'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->debugger2Stub,
            'DeleteBreakpoint',
            $mergedSettings,
            $this->descriptors['deleteBreakpoint']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListBreakpointsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['listBreakpoints'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->debugger2Stub,
            'ListBreakpoints',
            $mergedSettings,
            $this->descriptors['listBreakpoints']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListDebuggeesResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['listDebuggees'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->debugger2Stub,
            'ListDebuggees',
            $mergedSettings,
            $this->descriptors['listDebuggees']
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
        $this->debugger2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
