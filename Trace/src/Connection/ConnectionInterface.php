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

/**
 * Represents a connection to
 * [Trace](https://cloud.google.com/trace).
 */
interface ConnectionInterface
{
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
    public function traceBatchWrite(array $args);

    /**
     * @param array $args
     */
    public function traceSpanCreate(array $args);
}
