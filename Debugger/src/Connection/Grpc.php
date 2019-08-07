<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Debugger\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Debuggee;
use Google\Cloud\Debugger\V2\Controller2Client;
use Google\Cloud\Debugger\V2\Debugger2Client;

/**
 * Implementation of the
 * [Google Debugger gRPC API](https://cloud.google.com/debugger/docs/).
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Controller2Client
     */
    private $controllerClient;

    /**
     * @var Debugger2Client
     */
    private $debuggerClient;

    /**
     * @param array $config [optional] Configuration options. Please see
     *        {@see Google\Cloud\Core\GrpcRequestWrapper::__construct()} for
     *        the available options.
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([], [
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'google.protobuf.Int32Value' => function ($v) {
                return $this->flattenValue($v);
            }
        ], [], [
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampForApi($v);
            },
            'google.protobuf.Int32Value' => function ($v) {
                return [
                    'value' => $v
                ];
            }
        ]);
        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $gaxConfig = $this->getGaxConfig(
            DebuggerClient::VERSION,
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null
        );

        if (isset($config['apiEndpoint'])) {
            $gaxConfig['apiEndpoint'] = $config['apiEndpoint'];
        }

        $this->controllerClient = $this->constructGapic(Controller2Client::class, $gaxConfig);
        $this->debuggerClient = $this->constructGapic(Debugger2Client::class, $gaxConfig);
    }

    /**
     * List all registered debuggees.
     *
     * @param array $args {
     *     @type string $project The project ID
     * }
     */
    public function listDebuggees(array $args = [])
    {
        return $this->send([$this->debuggerClient, 'listDebuggees'], [
            $this->pluck('project', $args),
            DebuggerClient::getDefaultAgentVersion(),
            $args
        ]);
    }

    /**
     * Register this process as a debuggee.
     *
     * @param array $args
     */
    public function registerDebuggee(array $args = [])
    {
        return $this->send([$this->controllerClient, 'registerDebuggee'], [
            $this->serializer->decodeMessage(
                new Debuggee(),
                $this->pluck('debuggee', $args)
            ),
            $args
        ]);
    }

    /**
     * List the breakpoints set for the specified debuggee.
     *
     * @param array $args
     */
    public function listBreakpoints(array $args = [])
    {
        return $this->send([$this->controllerClient, 'listActiveBreakpoints'], [
            $this->pluck('debuggeeId', $args),
            $args
        ]);
    }

    /**
     * Update the provided breakpoint.
     *
     * @param array $args
     */
    public function updateBreakpoint(array $args)
    {
        return $this->send([$this->controllerClient, 'updateActiveBreakpoint'], [
            $this->pluck('debuggeeId', $args),
            $this->serializer->decodeMessage(
                new Breakpoint(),
                $this->pluck('breakpoint', $args)
            ),
            $args
        ]);
    }

    /**
     * Sets a breakpoint.
     *
     * @param array $args {
     *     @type string $debuggeeId The Debuggee ID
     *     @type array $location The source location
     * }
     * @return array
     */
    public function setBreakpoint(array $args)
    {
        $breakpointArgs = $this->pluckArray([
            'action',
            'condition',
            'expressions',
            'logMessageFormat',
            'logLevel',
            'location'
        ], $args);
        return $this->send([$this->debuggerClient, 'setBreakpoint'], [
            $this->pluck('debuggeeId', $args),
            $this->serializer->decodeMessage(new Breakpoint(), $breakpointArgs),
            DebuggerClient::getDefaultAgentVersion(),
            $args
        ]);
    }
}
