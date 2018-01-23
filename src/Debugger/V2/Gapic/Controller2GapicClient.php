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
 * https://github.com/google/googleapis/blob/master/google/devtools/clouddebugger/v2/controller.proto
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
use Google\Cloud\Debugger\V2\Debuggee;
use Google\Cloud\Debugger\V2\ListActiveBreakpointsRequest;
use Google\Cloud\Debugger\V2\ListActiveBreakpointsResponse;
use Google\Cloud\Debugger\V2\RegisterDebuggeeRequest;
use Google\Cloud\Debugger\V2\RegisterDebuggeeResponse;
use Google\Cloud\Debugger\V2\UpdateActiveBreakpointRequest;
use Google\Cloud\Debugger\V2\UpdateActiveBreakpointResponse;
use Grpc\Channel;
use Grpc\ChannelCredentials;

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
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
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
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.devtools.clouddebugger.v2.Controller2';

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
            'clientConfigPath' => __DIR__.'/../resources/controller2_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/controller2_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/controller2_descriptor_config.php',
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\RegisterDebuggeeResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function registerDebuggee($debuggee, $optionalArgs = [])
    {
        $request = new RegisterDebuggeeRequest();
        $request->setDebuggee($debuggee);

        return $this->startCall(
            'RegisterDebuggee',
            RegisterDebuggeeResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\ListActiveBreakpointsResponse
     *
     * @throws ApiException if the remote call fails
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

        return $this->startCall(
            'ListActiveBreakpoints',
            ListActiveBreakpointsResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Debugger\V2\UpdateActiveBreakpointResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateActiveBreakpoint($debuggeeId, $breakpoint, $optionalArgs = [])
    {
        $request = new UpdateActiveBreakpointRequest();
        $request->setDebuggeeId($debuggeeId);
        $request->setBreakpoint($breakpoint);

        return $this->startCall(
            'UpdateActiveBreakpoint',
            UpdateActiveBreakpointResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
