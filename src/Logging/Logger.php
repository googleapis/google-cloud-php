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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Logging\Connection\ConnectionInterface;

/**
 * A logger used to write entries to Google Stackdriver Logging.
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $logger = $logging->logger('my-log');
 * ```
 */
class Logger
{
    use ArrayTrait;
    use ValidateTrait;

    const EMERGENCY = 800;
    const ALERT = 700;
    const CRITICAL = 600;
    const ERROR = 500;
    const WARNING = 400;
    const NOTICE = 300;
    const INFO = 200;
    const DEBUG = 100;
    // DEFAULT is a reserved keyword.
    const DEFAULT_LEVEL = 0;

    private static $logLevelMap = [
        self::EMERGENCY => 'EMERGENCY',
        self::ALERT => 'ALERT',
        self::CRITICAL => 'CRITICAL',
        self::ERROR => 'ERROR',
        self::WARNING => 'WARNING',
        self::NOTICE => 'NOTICE',
        self::INFO => 'INFO',
        self::DEBUG => 'DEBUG',
        self::DEFAULT_LEVEL => 'DEFAULT'
    ];

    /**
     * @var ConnectionInterface Represents a connection to Stackdriver Logging.
     */
    protected $connection;

    /**
     * @var array Entry options.
     */
    private $entryOptions = [
        'resource',
        'httpRequest',
        'labels',
        'operation',
        'severity',
        'timestamp',
        'insertId'
    ];

    /**
     * @var string The logger's unformatted name.
     */
    private $name;

    /**
     * @var string The logger's formatted name to be used in API requests.
     */
    private $formattedName;

    /**
     * @var string The project ID associated with this logger.
     */
    private $projectId;

    /**
     * @var array A monitored resource.
     */
    private $resource;

    /**
     * @var array A set of user-defined (key, value) data that provides
     * additional information about the log entries.
     */
    private $labels;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        Stackdriver Logging.
     * @param string $name The name of the log to write entries to.
     * @param string $projectId The project's ID.
     * @param array $resource [optional] The
     *        [monitored resource](https://cloud.google.com/logging/docs/reference/v2/rest/v2/MonitoredResource)
     *        to associate log entries with. **Defaults to** type global.
     * @param array $labels [optional] A set of user-defined (key, value) data
     *        that provides additional information about the log entries.
     */
    public function __construct(
        ConnectionInterface $connection,
        $name,
        $projectId,
        array $resource = null,
        array $labels = null
    ) {
        $this->connection = $connection;
        $this->name = $name;
        $this->formattedName = "projects/$projectId/logs/$name";
        $this->projectId = $projectId;
        $this->resource = $resource ?: ['type' => 'global'];
        $this->labels = $labels;
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
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.logs/delete projects.logs delete API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteLog($options + ['logName' => $this->formattedName]);
    }

    /**
     * Fetches entries scoped to the selected log.
     *
     * Please note that a default filter specifying the logName will be applied
     * for you.
     *
     * Example:
     * ```
     * $entries = $logger->entries();
     *
     * foreach ($entries as $entry) {
     *     echo $entry->info()['textPayload'] . PHP_EOL;
     * }
     * ```
     *
     * ```
     * // Use an advanced logs filter to fetch only entries with a specific payload.
     * $entries = $logger->entries([
     *     'filter' => 'textPayload = "hello world"'
     * ]);
     *
     * foreach ($entries as $entry) {
     *     echo $entry->info()['textPayload'] . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/entries/list Entries list API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     *     @type string $orderBy How the results should be sorted. Presently,
     *           the only permitted values are `timestamp asc` and `timestamp desc`.
     *           **Defaults to** `"timestamp asc"`.
     *     @type int $pageSize The maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Google\Cloud\Logging\Entry>
     */
    public function entries(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        $logNameFilter = "logName = $this->formattedName";
        $options += [
            'resourceNames' => ["projects/$this->projectId"],
            'filter' => isset($options['filter'])
                ? $options['filter'] .= " AND $logNameFilter"
                : $logNameFilter
        ];

        return new ItemIterator(
            new PageIterator(
                function (array $entry) {
                    return new Entry($entry);
                },
                [$this->connection, 'listEntries'],
                $options,
                [
                    'itemsKey' => 'entries',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Creates an entry which which can be written to a log. In order to write
     * the entry to the log please use {@see Google\Cloud\Logging\Logger::write()}
     * or {@see Google\Cloud\Logging\Logger::writeBatch()}.
     *
     * Example:
     * ```
     * // Create an entry with a key/value set of data
     * $entry = $logger->entry(['user' => 'calvin']);
     * ```
     *
     * ```
     * // Create an entry with a string
     * $entry = $logger->entry('my message');
     * ```
     *
     * ```
     * // Create an entry with a severity of `EMERGENCY` and specifying a resource.
     * $entry = $logger->entry('my message', [
     *     'severity' => Logger::EMERGENCY,
     *     'resource' => [
     *         'type' => 'gcs_bucket',
     *         'labels' => [
     *             'bucket_name' => 'my-bucket'
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/logging/docs/reference/v2/rest/v2/LogEntry LogEntry resource documentation.
     *
     * @param array|string $data The data to log. When providing a string the
     *        data will be stored as a `textPayload` type. When providing an
     *        array the data will be stored as a `jsonPayload` type.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $resource The
     *           [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate this log entry with. **Defaults to** type global.
     *     @type array $httpRequest Information about the HTTP request
     *           associated with this log entry, if applicable. Please see
     *           [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#httprequest)
     *           for more information.
     *     @type array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     *     @type array $operation Additional information about a potentially
     *           long-running operation with which a log entry is associated.
     *           Please see
     *           [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#logentryoperation)
     *           for more information.
     *     @type string|int $severity The severity of the log entry. **Defaults to**
     *           `"DEFAULT"`.
     *     @type string $insertId A unique identifier for the log entry.
     *     @type \DateTimeInterface|Timestamp|string|null $timestamp The
     *           timestamp associated with this entry. If providing a string it
     *           must be in RFC3339 UTC "Zulu" format. Example:
     *           "2014-10-02T15:01:23.045123456Z". If explicitly set to `null`
     *           the timestamp will be generated by the server at the moment the
     *           entry is received (with nanosecond precision). **Defaults to**
     *           the current time, generated by the client with microsecond
     *           precision.
     * }
     * @return Entry
     * @throws \InvalidArgumentException
     */
    public function entry($data, array $options = [])
    {
        if (!is_array($data) && !is_string($data)) {
            throw new \InvalidArgumentException('$data must be either a string or an array.');
        }

        $options['timestamp'] = $this->handleTimestamp($options);

        if (is_array($data)) {
            $options['jsonPayload'] = $data;
        } else {
            $options['textPayload'] = $data;
        }

        if (!array_key_exists('labels', $options) && $this->labels) {
            $options['labels'] = $this->labels;
        }

        return new Entry($options + [
            'logName' => $this->formattedName,
            'resource' => $this->resource
        ]);
    }

    /**
     * Write a single entry to the log.
     *
     * Example:
     * ```
     * // Writing a simple log entry.
     * $logger->write('a log entry');
     * ```
     *
     * ```
     * // Writing a simple entry with a key/value set of data and a severity of `EMERGENCY`.
     * $logger->write(['user' => 'calvin'], [
     *     'severity' => Logger::EMERGENCY
     * ]);
     * ```
     *
     * ```
     * // Using the entry factory method to write a log entry.
     * $entry = $logger->entry('a log entry');
     * $logger->write($entry);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/entries/write Entries write API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array|string|Entry $entry The entry to write to the log.
     * @param array $options [optional] Please see
     *        {@see Google\Cloud\Logging\Logger::entry()} to see the options
     *        that can be applied to a log entry. Please note that if the
     *        provided entry is of type `Entry` these options will overwrite
     *        those that may already be set on the instance.
     * @throws \InvalidArgumentException
     */
    public function write($entry, array $options = [])
    {
        $entryOptions = $this->pluckArray($this->entryOptions, $options);
        $this->writeBatch(
            [$this->handleEntry($entry, $entryOptions)],
            $options
        );
    }

    /**
     * Write a set of entries to the log.
     *
     * Example:
     * ```
     * $entries = [];
     * $entries[] = $logger->entry('my message');
     * $entries[] = $logger->entry('my second message');
     *
     * $logger->writeBatch($entries);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/entries/write Entries write API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param Entry[] $entries Entries to write to the log.
     * @param array $options [optional] Configuration Options.
     */
    public function writeBatch(array $entries, array $options = [])
    {
        $this->validateBatch($entries, Entry::class);

        foreach ($entries as &$entry) {
            $entry = $entry->info();
        }

        $this->connection->writeEntries($options + ['entries' => $entries]);
    }

    /**
     * Returns the logger's name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the log level map.
     *
     * @return array
     * @access private
     */
    public static function getLogLevelMap()
    {
        return self::$logLevelMap;
    }

    /**
     * Returns current unix timestamp with microseconds. This method exists for
     * testing purposes.
     *
     * @return float
     */
    protected function microtime()
    {
        return microtime(true);
    }

    /**
     * @param array|string|Entry $entry
     * @param array $entryOptions
     * @return Entry
     */
    private function handleEntry($entry, array $entryOptions)
    {
        if ($entry instanceof Entry) {
            if (!$entryOptions) {
                return $entry;
            }

            if (array_key_exists('timestamp', $entryOptions)) {
                $entryOptions['timestamp'] = $this->handleTimestamp($entryOptions);
            }

            return new Entry($entryOptions + $entry->info());
        }

        return $this->entry($entry, $entryOptions);
    }

    /**
     * @param array $options
     * @return string|null
     */
    private function handleTimestamp(array $options)
    {
        if (!array_key_exists('timestamp', $options)) {
            return $this->createTimestamp();
        }

        if ($options['timestamp'] instanceof \DateTimeInterface) {
            return $this->createTimestamp($options['timestamp']);
        } elseif ($options['timestamp'] instanceof Timestamp) {
            return (string) $options['timestamp'];
        }

        return $options['timestamp'];
    }

    /**
     * @param \DateTimeInterface $dt [optional]
     * @return string
     */
    private function createTimestamp(\DateTimeInterface $dt = null)
    {
        if (!$dt) {
            $dt = \DateTime::createFromFormat(
                'U.u',
                sprintf('%.6F', $this->microtime()),
                new \DateTimeZone('UTC')
            );
        }

        return (string) new Timestamp($dt);
    }
}
