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
 * A metric counts the number of log entries that match a given filter. You can
 * use these metrics to create charts and alerting policies in
 * [Stackdriver Monitoring](https://cloud.google.com/monitoring/docs).
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $metric = $logging->metric('my-metric');
 * ```
 */
class Metric
{
    /**
     * @var ConnectionInterface Represents a connection to Stackdriver Logging.
     */
    protected $connection;

    /**
     * @var string The metric's formatted name used in API requests.
     */
    private $formattedName;

    /**
     * @var string The metric's name.
     */
    private $name;

    /**
     * @var array The metric's metadata.
     */
    private $info;

    /**
     * @param ConnectionInterface $connection Represents a connection to Cloud
     *        Logging.
     * @param string $name The metric's name.
     * @param string $projectId The project's ID.
     * @param array $info [optional] The metric's metadata.
     */
    public function __construct(ConnectionInterface $connection, $name, $projectId, array $info = [])
    {
        $this->connection = $connection;
        $this->info = $info;
        $this->formattedName = "projects/$projectId/metrics/$name";
        $this->name = $name;
    }

    /**
     * Check whether or not the metric exists.
     *
     * Example:
     * ```
     * if ($metric->exists()) {
     *     echo 'Metric exists!';
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
     * Delete the metric.
     *
     * Example:
     * ```
     * $metric->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics/delete projects.metrics delete API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteMetric($options + [
            'metricName' => $this->formattedName
        ]);
    }

    /**
     * Update the metric. Please note this will trigger a network request if
     * cached data is not available to perform the update with.
     *
     * Example:
     * ```
     * $metric->update([
     *     'description' => 'A description for my metric.'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics/update projects.metrics update API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $metadata {
     *     The data to update.
     *
     *     @type string $description A description of the metric.
     *     @type string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     * }
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    public function update(array $metadata, array $options = [])
    {
        $options += $metadata;
        $options += $this->info($options);

        return $this->info = $this->connection->updateMetric($options + [
            'metricName' => $this->formattedName
        ]);
    }

    /**
     * Retrieves the metric's details. If no metric data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $metric->info();
     * echo $info['description'];
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics#resource-logmetric LogMetric resource API documentation.
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
     * Triggers a network request to reload the metric's details.
     *
     * Example:
     * ```
     * $metric->reload();
     * $info = $metric->info();
     * echo $info['description'];
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics/get projects.metrics get API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getMetric($options + [
            'metricName' => $this->formattedName
        ]);
    }

    /**
     * Returns the metric's name.
     *
     * Example:
     * ```
     * echo $metric->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
