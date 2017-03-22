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

namespace Google\Cloud\Trace\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;

/**
 * Implementation of the
 * [Google Trace REST API](https://cloud.google.com/trace/docs/reference/rest/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;

    const BASE_URI = 'https://cloudtrace.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/trace-v1.json'
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            self::BASE_URI
        ));
    }

    /**
     * @param  array $args
     */
    public function patchTraces(array $args)
    {
        return $this->send('projects', 'patchTraces', $args);
    }

    /**
     * @param  array $args
     */
    public function getTrace(array $args)
    {
        return $this->send('projects.resources.traces', 'get', $args);
    }

    /**
     * @param  array $args
     */
    public function listTraces(array $args)
    {
        return $this->send('projects.resources.traces', 'list', $args);
    }
}
