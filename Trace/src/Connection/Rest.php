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
 *
 * @internal
 */
class Rest implements ConnectionInterface
{
    use RestTrait;

    const BASE_URI = 'https://cloudtrace.googleapis.com/';

    /**
     * @param array $config [optional] Configuration options. Please see
     *        {@see Google\Cloud\Core\RequestWrapper::__construct()} for
     *        the available options.
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/trace-v2.json'
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->getApiEndpoint(self::BASE_URI, $config)
        ));
    }

    /**
     * Sends new spans to new or existing traces. You cannot update existing
     * spans.
     *
     * @param array $args {
     *      Batch write params.
     *
     *      @type string $projectsId The ID of the Google Cloud Project
     *      @type array $spans Array of associative array span data. See
     *          {@see Google\Cloud\Trace\Span::info()} for format.
     * }
     */
    public function traceBatchWrite(array $args)
    {
        return $this->send('projects.resources.traces', 'batchWrite', $args);
    }

    /**
     * @param array $args
     */
    public function traceSpanCreate(array $args)
    {
        return $this->send('projects.resources.traces.resources.spans', 'create', $args);
    }
}
