<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
//
namespace Google\Cloud\Debugger\V2;

/**
 * The Debugger service provides the API that allows users to collect run-time
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
 */
class Debugger2GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sets the breakpoint to the debuggee.
     * @param \Google\Cloud\Debugger\V2\SetBreakpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetBreakpoint(\Google\Cloud\Debugger\V2\SetBreakpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouddebugger.v2.Debugger2/SetBreakpoint',
        $argument,
        ['\Google\Cloud\Debugger\V2\SetBreakpointResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets breakpoint information.
     * @param \Google\Cloud\Debugger\V2\GetBreakpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBreakpoint(\Google\Cloud\Debugger\V2\GetBreakpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouddebugger.v2.Debugger2/GetBreakpoint',
        $argument,
        ['\Google\Cloud\Debugger\V2\GetBreakpointResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the breakpoint from the debuggee.
     * @param \Google\Cloud\Debugger\V2\DeleteBreakpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBreakpoint(\Google\Cloud\Debugger\V2\DeleteBreakpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouddebugger.v2.Debugger2/DeleteBreakpoint',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all breakpoints for the debuggee.
     * @param \Google\Cloud\Debugger\V2\ListBreakpointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBreakpoints(\Google\Cloud\Debugger\V2\ListBreakpointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouddebugger.v2.Debugger2/ListBreakpoints',
        $argument,
        ['\Google\Cloud\Debugger\V2\ListBreakpointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all the debuggees that the user has access to.
     * @param \Google\Cloud\Debugger\V2\ListDebuggeesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDebuggees(\Google\Cloud\Debugger\V2\ListDebuggeesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouddebugger.v2.Debugger2/ListDebuggees',
        $argument,
        ['\Google\Cloud\Debugger\V2\ListDebuggeesResponse', 'decode'],
        $metadata, $options);
    }

}
