<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Controller2Client;
use Google\Cloud\Debugger\V2\Debuggee;
use Google\Cloud\Debugger\V2\Debugger2Client;
use Google\Cloud\Debugger\V2\StatusMessage;
use Google\ApiCore\Serializer;

/**
 * Implementation of the
 * [Google Stackdriver Logging gRPC API](https://cloud.google.com/logging/docs/).
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;

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
        $gaxConfig = $this->getGaxConfig(DebuggerClient::VERSION);

        $this->controllerClient = new Controller2Client($gaxConfig);
        $this->debuggerClient = new Debugger2Client($gaxConfig);
    }

    /**
     * List all registered debuggees.
     *
     * @param array $args
     */
    public function listDebuggees(array $args = [])
    {
        return $this->send([$this->debuggerClient, 'listDebuggees'], [
            $this->pluck('project', $args),
            $this->pluck('agentVersion', $args),
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
        $pbDebuggee = $this->serializer->decodeMessage(new Debuggee(), $this->pluck('debuggee', $args));
        return $this->send([$this->controllerClient, 'registerDebuggee'], [
            $pbDebuggee,
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
            $this->buildBreakpoint($this->pluck('breakpoint', $args)),
            $args
        ]);
    }

    /**
     * Sets a breakpoint.
     *
     * @param array $args
     */
    public function setBreakpoint(array $args)
    {
        return $this->send([$this->debuggerClient, 'setBreakpoint'], [
            $this->pluck('debuggeeId', $args),
            $this->buildBreakpoint($this->pluck('breakpoint', $args)),
            $this->pluck('agentVersion', $args),
            $args
        ]);
    }

    private function buildBreakpoint($info)
    {
        if (isset($info['createTime'])) {
            $info['createTime'] = $this->formatTimestampForApi($info['createTime']);
        }
        if (isset($info['finalTime'])) {
            $info['finalTime'] = $this->formatTimestampForApi($info['finalTime']);
        }
        return $this->serializer->decodeMessage(new Breakpoint(), $info);
    }
}
