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

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;

/**
 * Implementation of the
 * [Google Debugger REST API](https://cloud.google.com/debugger/docs/reference/rest/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;

    const BASE_URI = 'https://clouddebugger.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/debugger-v2.json'
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            self::BASE_URI
        ));
    }

    /**
     * List all registered debuggees.
     *
     * @param array $args
     */
    public function listDebuggees(array $args = [])
    {
        return $this->send('debugger.resources.debuggees', 'list', $args);
    }

    /**
     * Register this process as a debuggee.
     *
     * @param array $args
     */
    public function registerDebuggee(array $args = [])
    {
        return $this->send('controller.resources.debuggees', 'register', $args);
    }

    /**
     * List the breakpoints set for the specified debuggee.
     *
     * @param array $args
     */
    public function listBreakpoints(array $args = [])
    {
        return $this->send('controller.resources.debuggees.resources.breakpoints', 'list', $args);
    }

    /**
     * Update the provided breakpoint.
     *
     * @param array $args
     */
    public function updateBreakpoint(array $args)
    {
        return $this->send('controller.resources.debuggees.resources.breakpoints', 'update', $args);
    }
}
