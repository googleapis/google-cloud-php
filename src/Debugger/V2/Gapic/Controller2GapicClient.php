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
 * https://github.com/google/googleapis/blob/master/google/devtools/clouddebugger/v2/controller.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Debugger\V2\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Controller2GrpcClient;
use Google\Cloud\Debugger\V2\Debuggee;
use Google\Cloud\Debugger\V2\ListActiveBreakpointsRequest;
use Google\Cloud\Debugger\V2\RegisterDebuggeeRequest;
use Google\Cloud\Debugger\V2\UpdateActiveBreakpointRequest;
use Google\Cloud\Version;

/**
 * Service Description: The Controller service provides the API for orchestrating a collection of
 * debugger agents to perform debugging tasks. These agents are each attached
 * to a process of an application which may include one or more replicas.
 *
 * The debugger agents register with the Controller to identify the application
 * being debugged, the Debuggee. All agents that register with the same data,
 * represent the same Debuggee, and are assigned the same `debuggee_id`.
 *
 * The debugger agents call the Controller to retrieve  the list of active
 * Breakpoints. Agents with the same `debuggee_id` get the same breakpoints
 * list. An agent that can fulfill the breakpoint request updates the
 * Controller with the breakpoint result. The controller selects the first
 * result received and discards the rest of the results.
 * Agents that poll again for active breakpoints will no longer have
 * the completed breakpoint in the list and should remove that breakpoint from
 * their attached process.
 *
 * The Controller service does not provide a way to retrieve the results of
 * a completed breakpoint. This functionality is available using the Debugger
 * service.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $controller2Client = new Controller2Client();
 * try {
 *     $debuggee = new Debuggee();
 *     $response = $controller2Client->registerDebuggee($debuggee);
 * } finally {
 *     $controller2Client->close();
 * }
 * ```
 *
 * @experimental
 */
class Controller2GapicClient
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
    protected $controller2Stub;
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
            'clientConfigPath' => __DIR__.'/../resources/controller2_client_config.json',
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
            'registerDebuggee' => $defaultDescriptors,
            'listActiveBreakpoints' => $defaultDescriptors,
            'updateActiveBreakpoint' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.devtools.clouddebugger.v2.Controller2',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createController2StubFunction = function ($hostname, $opts, $channel) {
            return new Controller2GrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createController2StubFunction', $options)) {
            $createController2StubFunction = $options['createController2StubFunction'];
        }
        $this->controller2Stub = $this->grpcCredentialsHelper->createStub($createController2StubFunction);
    }

    /**
     * Registers the debuggee with the controller service.
     *
     * All agents attached to the same application must call this method with
     * exactly the same request content to get back the same stable `debuggee_id`.
     * Agents should call this method again whenever `google.rpc.Code.NOT_FOUND`
     * is returned from any controller method.
     *
     * This protocol allows the controller service to disable debuggees, recover
     * from data loss, or change the `debuggee_id` format. Agents must handle
     * `debuggee_id` value changing upon re-registration.
     *
     * Sample code:
     * ```
     * $controller2Client = new Controller2Client();
     * try {
     *     $debuggee = new Debuggee();
     *     $response = $controller2Client->registerDebuggee($debuggee);
     * } finally {
     *     $controller2Client->close();
     * }
     * ```
     *
     * @param Debuggee $debuggee     Debuggee information to register.
     *                               The fields `project`, `uniquifier`, `description` and `agent_version`
     *                               of the debuggee must be set.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\RegisterDebuggeeResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function registerDebuggee($debuggee, $optionalArgs = [])
    {
        $request = new RegisterDebuggeeRequest();
        $request->setDebuggee($debuggee);

        $defaultCallSettings = $this->defaultCallSettings['registerDebuggee'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->controller2Stub,
            'RegisterDebuggee',
            $mergedSettings,
            $this->descriptors['registerDebuggee']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns the list of all active breakpoints for the debuggee.
     *
     * The breakpoint specification (`location`, `condition`, and `expressions`
     * fields) is semantically immutable, although the field values may
     * change. For example, an agent may update the location line number
     * to reflect the actual line where the breakpoint was set, but this
     * doesn't change the breakpoint semantics.
     *
     * This means that an agent does not need to check if a breakpoint has changed
     * when it encounters the same breakpoint on a successive call.
     * Moreover, an agent should remember the breakpoints that are completed
     * until the controller removes them from the active list to avoid
     * setting those breakpoints again.
     *
     * Sample code:
     * ```
     * $controller2Client = new Controller2Client();
     * try {
     *     $debuggeeId = '';
     *     $response = $controller2Client->listActiveBreakpoints($debuggeeId);
     * } finally {
     *     $controller2Client->close();
     * }
     * ```
     *
     * @param string $debuggeeId   Identifies the debuggee.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $waitToken
     *          A token that, if specified, blocks the method call until the list
     *          of active breakpoints has changed, or a server-selected timeout has
     *          expired. The value should be set from the `next_wait_token` field in
     *          the last response. The initial value should be set to `"init"`.
     *     @type bool $successOnTimeout
     *          If set to `true` (recommended), returns `google.rpc.Code.OK` status and
     *          sets the `wait_expired` response field to `true` when the server-selected
     *          timeout has expired.
     *
     *          If set to `false` (deprecated), returns `google.rpc.Code.ABORTED` status
     *          when the server-selected timeout has expired.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListActiveBreakpointsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listActiveBreakpoints($debuggeeId, $optionalArgs = [])
    {
        $request = new ListActiveBreakpointsRequest();
        $request->setDebuggeeId($debuggeeId);
        if (isset($optionalArgs['waitToken'])) {
            $request->setWaitToken($optionalArgs['waitToken']);
        }
        if (isset($optionalArgs['successOnTimeout'])) {
            $request->setSuccessOnTimeout($optionalArgs['successOnTimeout']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listActiveBreakpoints'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->controller2Stub,
            'ListActiveBreakpoints',
            $mergedSettings,
            $this->descriptors['listActiveBreakpoints']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates the breakpoint state or mutable fields.
     * The entire Breakpoint message must be sent back to the controller service.
     *
     * Updates to active breakpoint fields are only allowed if the new value
     * does not change the breakpoint specification. Updates to the `location`,
     * `condition` and `expressions` fields should not alter the breakpoint
     * semantics. These may only make changes such as canonicalizing a value
     * or snapping the location to the correct line of code.
     *
     * Sample code:
     * ```
     * $controller2Client = new Controller2Client();
     * try {
     *     $debuggeeId = '';
     *     $breakpoint = new Breakpoint();
     *     $response = $controller2Client->updateActiveBreakpoint($debuggeeId, $breakpoint);
     * } finally {
     *     $controller2Client->close();
     * }
     * ```
     *
     * @param string     $debuggeeId   Identifies the debuggee being debugged.
     * @param Breakpoint $breakpoint   Updated breakpoint information.
     *                                 The field `id` must be set.
     *                                 The agent must echo all Breakpoint specification fields in the update.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\UpdateActiveBreakpointResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateActiveBreakpoint($debuggeeId, $breakpoint, $optionalArgs = [])
    {
        $request = new UpdateActiveBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpoint($breakpoint);

        $defaultCallSettings = $this->defaultCallSettings['updateActiveBreakpoint'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->controller2Stub,
            'UpdateActiveBreakpoint',
            $mergedSettings,
            $this->descriptors['updateActiveBreakpoint']
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
        $this->controller2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
