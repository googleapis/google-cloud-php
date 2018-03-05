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

namespace Google\Cloud\Logging;

use Google\Cloud\Logging\Connection\ConnectionInterface;

/**
 * An individual entry in a log.
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $logger = $logging->logger('my-log');
 *
 * $entry = $logger->entry('my message');
 * ```
 */
class Entry
{
    /**
     * @var array The entry's metadata.
     */
    private $info;

    /**
     * @param array $info [optional] The entry's metadata.
     */
    public function __construct(array $info = [])
    {
        $this->info = $info;
    }

    /**
     * Retrieves the entry's details.
     *
     * Example:
     * ```
     * $info = $entry->info();
     * echo $info['textPayload'];
     * ```
     *
     * @see https://cloud.google.com/logging/docs/reference/v2/rest/v2/LogEntry LogEntry resource documentation.
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }
}
