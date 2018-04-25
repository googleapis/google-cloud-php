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
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([
            'create_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'final_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
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
        $this->controllerClient = new Controller2Client($gaxConfig);
        $this->debuggerClient = new Debugger2Client($gaxConfig);
    }

    /**
     * List all registered debuggees.
     *
     * @param array $args {
     *     @type string $project
     * }
     */
    public function listDebuggees(array $args = [])
    {
        $resp = $this->send([$this->debuggerClient, 'listDebuggees'], [
            $this->pluck('project', $args),
            DebuggerClient::VERSION,
            $args
        ]);
        return $resp; // FIXME
    }

    /**
     * Register this process as a debuggee.
     *
     * @param array $args
     */
    public function registerDebuggee(array $args = [])
    {
        $resp = $this->send([$this->controllerClient, 'registerDebuggee'], [
            $this->buildDebuggee($this->pluck('debuggee', $args)),
            $args
        ]);
        return $resp; // FIXME
    }

    /**
     * List the breakpoints set for the specified debuggee.
     *
     * @param array $args
     */
    public function listBreakpoints(array $args = [])
    {
        $resp = $this->send([$this->controllerClient, 'listActiveBreakpoints'], [
            $this->pluck('debuggeeId', $args),
            $args
        ]);
        return $resp; // FIXME
    }

    /**
     * Update the provided breakpoint.
     *
     * @param array $args
     */
    public function updateBreakpoint(array $args)
    {
        $resp = $this->send([$this->controllerClient, 'updateActiveBreakpoint'], [
            $this->pluck('debuggeeId', $args),
            $this->buildBreakpoint($this->pluck('breakpoint', $args)),
            $args
        ]);
        return $resp; // FIXME
    }

    /**
     * Sets a breakpoint.
     *
     * @param array $args {
     *     @type string $debuggeeId
     *     @type array $location
     * }
     * @return array
     */
    public function setBreakpoint(array $args)
    {
        return $this->send([$this->debuggerClient, 'setBreakpoint'], [
            $this->pluck('debuggeeId', $args),
            $this->buildBreakpoint($args),
            DebuggerClient::VERSION,
            $args
        ]);
    }

    private function buildDebuggee($args)
    {
        return $this->serializer->decodeMessage(new Debuggee(), $args);
    }

    private function buildBreakpoint($args)
    {
        if (isset($args['createTime'])) {
            $args['createTime'] = $this->formatTimestampForApi($args['createTime']);
        }
        if (isset($args['finalTime'])) {
            $args['finalTime'] = $this->formatTimestampForApi($args['finalTime']);
        }
        return $this->serializer->decodeMessage(new Breakpoint(), $args);
    }
}
