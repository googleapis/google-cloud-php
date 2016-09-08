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
 * A logger used to write entries to Google Stackdriver Logging.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $logging = $cloud->logging();
 *
 * $logger = $logging->logger('my-log');
 * ```
 */
class Logger
{
    const EMERGENCY = 'EMERGENCY';
    const ALERT = 'ALERT';
    const CRITICAL = 'CRITICAL';
    const ERROR = 'ERROR';
    const WARNING = 'WARNING';
    const NOTICE = 'NOTICE';
    const INFO = 'INFO';
    const DEBUG = 'DEBUG';

    /**
     * @var ConnectionInterface Represents a connection to Stackdriver Logging.
     */
    private $connection;

    /**
     * @var string The logger's formatted name to be used in API requests.
     */
    private $formattedName;

    /**
     * @var string The project ID associated with this logger.
     */
    private $projectId;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        Stackdriver Logging.
     * @param string $name The name of the log to write entries to.
     * @param string $projectId The project's ID.
     */
    public function __construct(ConnectionInterface $connection, $name, $projectId)
    {
        $this->connection = $connection;
        $this->formattedName = "projects/$projectId/logs/$name";
        $this->projectId = $projectId;
    }

    /**
     * Deletes this log and all its log entries. The log will reappear if it
     * receives new entries.
     *
     * Example:
     * ```
     * $logger->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/projects.logs/delete projects.logs delete API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteLog($options + ['logName' => $this->formattedName]);
    }

    /**
     * Creates an entry which which can be written to a log. In order to write
     * the entry to the log please use {@see Google\Cloud\Logging\Logger::write()}
     * or {@see Google\Cloud\Logging\Logger::writeBatch()}.
     *
     * Example:
     * ```
     * // Create an entry with a key/value set of data
     * $entry = $logger->entry(
     *     ['user' => 'calvin'],
     *     [
     *         'type' => 'gcs_bucket',
     *         'labels' => [
     *             'bucket_name' => 'my-bucket'
     *         ]
     *     ]
     * );
     * ```
     *
     * ```
     * // Create an entry with a string
     * $entry = $logger->entry('my message', [
     *     'type' => 'gcs_bucket',
     *     'labels' => [
     *         'bucket_name' => 'my-bucket'
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Create an entry with a severity of `EMERGENCY`
     * $entry = $logger->entry(
     *     'my message',
     *     [
     *         'type' => 'gcs_bucket',
     *         'labels' => [
     *             'bucket_name' => 'my-bucket'
     *         ]
     *     ],
     *     ['severity' => Logger::EMERGENCY]
     * );
     * ```
     *
     * @see https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/LogEntry LogEntry resource documentation.
     *
     * @codingStandardsIgnoreStart
     * @param array|string $data The data to log. When providing a string the
     *        data will be stored as a `textPayload` type. When providing an
     *        array the data will be stored as a `jsonPayload` type.
     * @param array $resource The
     *        [monitored resource](https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/MonitoredResource)
     *        to associate this log entry with.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $httpRequest Information about the HTTP request
     *           associated with this log entry, if applicable. Please see
     *           [the API docs](https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/LogEntry#httprequest)
     *           for more information.
     *     @type array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     *     @type array $operation Additional information about a potentially
     *           long-running operation with which a log entry is associated.
     *           Please see [the API docs](https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/LogEntry#logentryoperation)
     *           for more information.
     *     @type string $severity The severity of the log entry. The default
     *           value is `DEFAULT`.
     * }
     * @return Entry
     * @codingStandardsIgnoreEnd
     */
    public function entry($data, array $resource, array $options = [])
    {
        if (!is_array($data) && !is_string($data)) {
            throw new \InvalidArgumentException('$data must be either a string or an array.');
        }

        if (is_array($data)) {
            $options['jsonPayload'] = $data;
        } else {
            $options['textPayload'] = $data;
        }

        return new Entry($options + [
            'logName' => $this->formattedName,
            'resource' => $resource
        ]);
    }

    /**
     * Write a single entry to the log.
     *
     * Example:
     * ```
     * $logger->write($entry);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/entries/write Entries write API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param Entry $entry The entry to write to the log.
     * @param array $options Configuration options.
     */
    public function write(Entry $entry, array $options = [])
    {
        $this->writeBatch([$entry], $options);
    }

    /**
     * Write a set of entries to the log.
     *
     * Example:
     * ```
     * $resource = [
     *     'type' => 'gcs_bucket',
     *         'labels' => [
     *             'bucket_name' => 'my-bucket'
     *         ]
     *     ]
     * ];
     *
     * $entries = [];
     * $entries[] = $logger->entry('my message', $resource);
     * $entries[] = $logger->entry('my second message', $resource);
     *
     * $logger->writeBatch($entries);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/entries/write Entries write API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param Entry[] $entries Entries to write to the log.
     * @param array $options Configuration options.
     */
    public function writeBatch(array $entries, array $options = [])
    {
        foreach ($entries as &$entry) {
            $entry = $entry->info();
        }

        $this->connection->writeEntries($options + ['entries' => $entries]);
    }
}
