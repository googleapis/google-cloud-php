<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;

/**
 * Represents a connection to
 * [Debugger](https://cloud.google.com/debugger).
 */
interface ConnectionInterface
{
    /**
     * List all registered debuggees.
     *
     * @param array $args
     */
    public function listDebuggees(array $args = []);

    /**
     * Register this process as a debuggee.
     *
     * @param array $args
     */
    public function registerDebuggee(array $args = []);

    /**
     * List the breakpoints set for the specified debuggee.
     *
     * @param array $args
     */
    public function listBreakpoints(array $args = []);

    /**
     * Update the provided breakpoint.
     *
     * @param array $args
     */
    public function updateBreakpoint(array $args);

    /**
     * Sets a breakpoint.
     *
     * @param array $args
     */
    public function setBreakpoint(array $args);
}
