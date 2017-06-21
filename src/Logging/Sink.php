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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Logging\Connection\ConnectionInterface;

/**
 * A sink is used to export log entries outside Stackdriver Logging.
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $sink = $logging->sink('my-sink');
 * ```
 */
class Sink
{
    /**
     * @var ConnectionInterface Represents a connection to Stackdriver Logging.
     */
    protected $connection;

    /**
     * @var string The sink's formatted name used in API requests.
     */
    private $formattedName;

    /**
     * @var string The sink's name.
     */
    private $name;

    /**
     * @param ConnectionInterface $connection Represents a connection to Cloud
     *        Logging.
     * @param string $name The sink's name.
     * @param string $projectId The project's ID.
     * @param array $info [optional] The sink's metadata.
     */
    public function __construct(ConnectionInterface $connection, $name, $projectId, array $info = [])
    {
        $this->connection = $connection;
        $this->info = $info;
        $this->formattedName = "projects/$projectId/sinks/$name";
        $this->name = $name;
    }

    /**
     * Check whether or not the sink exists.
     *
     * Example:
     * ```
     * if ($sink->exists()) {
     *     echo 'Sink exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->info($options);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Delete the sink.
     *
     * Example:
     * ```
     * $sink->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/delete projects.sinks delete API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteSink($options + [
            'sinkName' => $this->formattedName
        ]);
    }

    /**
     * Update the sink. Please note this will trigger a network request if
     * cached data is not available to perform the update with.
     *
     * Example:
     * ```
     * $sink->update([
     *     'destination' => 'storage.googleapis.com/my-bucket'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/update projects.sinks update API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $metadata {
     *     The data to update.
     *
     *     @type string $destination The export destination. Please see
     *           [Exporting Logs With Sinks](https://cloud.google.com/logging/docs/api/tasks/exporting-logs#about_sinks)
     *           for more information and examples.
     *     @type string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     *     @type string $outputVersionFormat The log entry version to use for
     *           this sink's exported log entries. This version does not have
     *           to correspond to the version of the log entry when it was
     *           written to Stackdriver Logging. May be either `V1` or `V2`.
     * }
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    public function update(array $metadata, array $options = [])
    {
        $options += $metadata;
        $options += $this->info($options);

        return $this->info = $this->connection->updateSink($options + [
            'sinkName' => $this->formattedName
        ]);
    }

    /**
     * Retrieves the sink's details. If no sink data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $sink->info();
     * echo $info['destination'];
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks#resource-logsink LogSink resource API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Triggers a network request to reload the sink's details.
     *
     * Example:
     * ```
     * $sink->reload();
     * $info = $sink->info();
     * echo $info['destination'];
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/get projects.sinks get API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getSink($options + [
            'sinkName' => $this->formattedName
        ]);
    }

    /**
     * Returns the sink's name.
     *
     * Example:
     * ```
     * echo $sink->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
