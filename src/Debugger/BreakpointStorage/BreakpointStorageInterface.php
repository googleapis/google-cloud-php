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

namespace Google\Cloud\Debugger\BreakpointStorage;

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;

/**
 * This interface represents the abstraction for storing and retrieving
 * breakpoint configuration from a shared location on the machine. All processes
 * on the machine can share the storage space.
 */
interface BreakpointStorageInterface
{
    /**
     * Save the given debugger breakpoints.
     *
     * @param Debuggee $debuggee
     * @param Breakpoint[] $breakpoints
     * @return bool
     */
    public function save(Debuggee $debuggee, array $breakpoints);

    /**
     * Load debugger breakpoints from the storage.
     *
     * @return array 2-tuple of debuggee id and an array of all breakpoints.
     */
    public function load();
}
