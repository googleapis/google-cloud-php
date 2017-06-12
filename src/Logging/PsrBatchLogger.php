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

namespace Google\Cloud\Logging;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\RegisterJobTrait;
use Google\Cloud\Core\Report\MetadataProviderInterface;
use Google\Cloud\Core\Report\MetadataProviderUtils;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A PSR-3 compliant logger that writes entries to Google Stackdriver Logging
 * with background batching.
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $psrBatchLogger = $logging->psrBatchLogger('my-log');
 * ```
 *
 * @method emergency() {
 *     Log an emergency entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->emergency('emergency message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method alert() {
 *     Log an alert entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->alert('alert message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method critical() {
 *     Log a critical entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->critical('critical message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method error() {
 *     Log an error entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->error('error message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method warning() {
 *     Log a warning entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->warning('warning message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method notice() {
 *     Log a notice entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->notice('notice message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method info() {
 *     Log an info entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->info('info message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method debug() {
 *     Log a debug entry.
 *
 *     Example:
 *     ```
 *     $psrBatchLogger->debug('debug message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @method log() {
 *     Write a log entry.
 *
 *     Example:
 *     ```
 *     use Google\Cloud\Logging\Logger;
 *
 *     $psrBatchLogger->log(Logger::ALERT, 'alert message');
 *     ```
 *
 *     ```
 *     // Write a log entry using the context array with placeholders.
 *     use Google\Cloud\Logging\Logger;
 *
 *     $psrBatchLogger->log(Logger::ALERT, 'alert: {message}', [
 *         'message' => 'my alert message'
 *     ]);
 *     ```
 *
 *     ```
 *     // Log information regarding an HTTP request
 *     use Google\Cloud\Logging\Logger;
 *
 *     $psrBatchLogger->log(Logger::ALERT, 'alert message', [
 *         'stackdriverOptions' => [
 *             'httpRequest' => [
 *                 'requestMethod' => 'GET'
 *             ]
 *         ]
 *     ]);
 *     ```
 *
 *     @param string|int $level The severity of the log entry.
 *     @param string $message The message to log.
 *     @param array $context {
 *         Context is an associative array which can include placeholders to be
 *         used in the `$message`. Placeholders must be delimited with a single
 *         opening brace `{` and a single closing brace `}`. The context will be
 *         added as additional information on the `jsonPayload`. Please note
 *         that the key `stackdriverOptions` is reserved for logging Google
 *         Stackdriver specific data.
 *
 *         @type array $stackdriverOptions['resource'] The
 *               [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
 *               to associate this log entry with. **Defaults to** type global.
 *         @type array $stackdriverOptions['httpRequest'] Information about the
 *               HTTP request associated with this log entry, if applicable.
 *               Please see
 *               [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#httprequest)
 *               for more information.
 *         @type array $stackdriverOptions['labels'] A set of user-defined
 *               (key, value) data that provides additional information about
 *               the log entry.
 *         @type array $stackdriverOptions['operation'] Additional information
 *               about a potentially long-running operation with which a log
 *               entry is associated. Please see
 *               [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#logentryoperation)
 *               for more information.
 *     }
 *     @throws InvalidArgumentException
 * }
 *
 * @see http://www.php-fig.org/psr/psr-3/#psrlogloggerinterface Psr\Log\LoggerInterface
 */
class PsrBatchLogger implements LoggerInterface
{
    use PsrLoggerTrait;
    use RegisterJobTrait;

    const ID_TEMPLATE = 'stackdriver-logging-%s';

    /** @var array */
    private static $loggers = [];

    /** @var string */
    private $logName;

    /** @var string */
    private $messageKey = 'message';

    /**
     * @param string $logName The name of the log.
     * @param array $options [optional] {
     *     Configuration options.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           **Defaults to** false.
     *     @type array $batchOptions An option to BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()}
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'workerNum' => 10].
     *     @type array $clientConfig A config to LoggingClient
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}
     *           **Defaults to** an empty array.
     *     @type MetadataProviderInterface $metadataProvider
     *           **Defaults to null** If null, it will be automatically chosen.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     * }
     */
    public function __construct($logName, array $options = [])
    {
        $this->setJobProperties($options + [
            'identifier' => sprintf(self::ID_TEMPLATE, $logName)
        ]);
        $this->logName = $logName;
        $this->metadataProvider = isset($options['metadataProvider'])
            ? $options['metadataProvider']
            : MetadataProviderUtils::autoSelect($_SERVER);

        $this->batchRunner->registerJob(
            $this->identifier,
            [$this, 'sendEntries'],
            $this->batchOptions
        );
    }

    /**
     * Return a Logger object for the current logName.
     *
     * @return Logger
     */
    protected function getLogger()
    {
        if (!array_key_exists($this->logName, self::$loggers)) {
            $c = new LoggingClient($this->clientConfig);
            self::$loggers[$this->logName] = $c->logger($this->logName);
        }
        return self::$loggers[$this->logName];
    }

    /**
     * Submit the given entry to the BatchRunner.
     *
     * @param Entry $entry
     */
    private function sendEntry(Entry $entry)
    {
        $this->batchRunner->submitItem($this->identifier, $entry);
    }

    /**
     * Send the given entries.
     *
     * @param array $entries An array of entries to send.
     * @return bool
     */
    public function sendEntries(array $entries)
    {
        $start = microtime(true);
        try {
            $this->getLogger()->writeBatch($entries);
        } catch (\Exception $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            return false;
        }
        $end = microtime(true);
        if ($this->debugOutput) {
            printf(
                '%f seconds for writeBatch %d entries' . PHP_EOL,
                $end - $start,
                count($entries)
            );
            printf('memory used: %d' . PHP_EOL, memory_get_usage());
        }
        return true;
    }
}
