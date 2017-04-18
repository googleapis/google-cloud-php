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
 * use Google\Cloud\Logging\BatchLogger;
 *
 * $logger = new BatchLogger('app');
 * $logger->log(LogLevel::INFO, 'My log message');
 * ```
 */
class BatchLogger implements LoggerInterface
{
    const ID_TEMPLATE = 'stackdriver-logging-%s';
    const MESSAGE_KEY = 'message';

    /** @var array */
    private $batchOptions;

    /** @var array */
    private $clientOptions;

    /** @var string */
    private $logName;

    /** @var MetadataProviderInterface */
    private $metadataProvider;

    /** @var BatchRunner */
    private $batchRunner;

    /** @var string */
    private $identifier;

    /** @var boolean */
    private $debugOutput;

    /** @var array */
    private static $logLevels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug'
    ];

    /**
     * Return a Logger object for the current logName.
     *
     * @return Logger
     */
    private function getLogger()
    {
        static $loggers = [];
        if (! array_key_exists($this->logName, $loggers)) {
            $c = new LoggingClient($this->clientOptions);
            $resource = $this->metadataProvider->getMonitoredResource();
            if (empty($resource)) {
                $loggers[$this->logName] = $c->logger($this->logName);
            } else {
                $loggers[$this->logName] = $c->logger($this->logName, ['resource' => $resource]);
            }
        }
        return $loggers[$this->logName];
    }

    /**
     * @param string $logName The name of the log.
     * @param boolean $debugOutput [optional] **Defaults to false** Set to true for debug output.
     * @param array $batchOptions [optional] **Defaults to []** An option to BatchJob
     *        {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for details.
     * @param array $clientOptions [optional] **Defaults to []** An option to LoggingClient
     *        {@see \Google\Cloud\Logging\LoggingClient::__construct()} for details.
     * @param MetadataProviderInterface $metadataProvider [optional] **Defaults to null** If null,
     *        it will be automatically chosen.
     * @param BatchRunner $batchRunner [optional] **Defaults to null** A BatchRunner object. Mainly used for the
     *        tests to inject a mock.
     */
    public function __construct(
        $logName,
        $debugOutput = false,
        array $batchOptions = [],
        array $clientOptions = [],
        MetadataProviderInterface $metadataProvider = null,
        BatchRunner $batchRunner = null
    ) {
        $this->logName = $logName;
        $this->debugOutput = $debugOutput;
        $this->identifier = sprintf(self::ID_TEMPLATE, $this->logName);
        $this->metadataProvider = $metadataProvider === null
            ? MetadataProviderUtils::autoSelect()
            : $metadataProvider;
        $this->clientOptions = $clientOptions;
        $this->batchOptions = array_merge(
            // Default values
            [
                'batchSize' => 1000,
                'callPeriod' => 2.0,
                'workerNum' => 10,
            ],
            $batchOptions
        );
        $this->batchRunner = ($batchRunner !== null)
            ? $batchRunner
            : new BatchRunner();
        $this->batchRunner->registerJob(
            $this->identifier,
            [$this, 'sendEntries'],
            $this->batchOptions
        );
    }

    /**
     * Return the MetadataProvider.
     *
     * @return MetadataProviderInterface
     */
    public function getMetadataProvider()
    {
        return $this->metadataProvider;
    }

    /**
     * Log an emergency entry.
     *
     * Example:
     * ```
     * $logger->emergency('emergency message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function emergency($message, array $context = [])
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Log an alert entry.
     *
     * Example:
     * ```
     * $logger->alert('alert message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function alert($message, array $context = [])
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Log a critical entry.
     *
     * Example:
     * ```
     * $logger->critical('critical message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function critical($message, array $context = [])
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Log an error entry.
     *
     * Example:
     * ```
     * $logger->error('error message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function error($message, array $context = [])
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Log a warning entry.
     *
     * Example:
     * ```
     * $logger->warning('warning message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function warning($message, array $context = [])
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Log a notice entry.
     *
     * Example:
     * ```
     * $logger->notice('notice message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function notice($message, array $context = [])
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Log an info entry.
     *
     * Example:
     * ```
     * $logger->info('info message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function info($message, array $context = [])
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Log a debug entry.
     *
     * Example:
     * ```
     * $logger->debug('debug message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\BatchLogger::log()}
     *        for the available options.
     */
    public function debug($message, array $context = [])
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Write a log entry.
     *
     * Example:
     * ```
     * use Psr\Log\LogLevel;
     *
     * $logger->log(LogLevel::ALERT, 'alert message');
     * ```
     * @param string $level The severity of the log entry.
     * @param string $message The message to log.
     * @param array $context {
     *     Context is an associative array which can include placeholders to be
     *     used in the `$message`. Placeholders must be delimited with a single
     *     opening brace `{` and a single closing brace `}`. The context will be
     *     added as additional information on the `jsonPayload`. Please note
     *     that the key `stackdriverOptions` is reserved for logging Google
     *     Stackdriver specific data.
     *
     *     @type array $stackdriverOptions['resource'] The
     *           [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate this log entry with. **Defaults to** type global.
     *     @type array $stackdriverOptions['httpRequest'] Information about the
     *           HTTP request associated with this log entry, if applicable.
     *           Please see
     *           [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#httprequest)
     *           for more information.
     *     @type array $stackdriverOptions['labels'] A set of user-defined
     *           (key, value) data that provides additional information about
     *           the log entry.
     *     @type array $stackdriverOptions['operation'] Additional information
     *           about a potentially long-running operation with which a log
     *           entry is associated. Please see
     *           [the API docs](https://cloud.google.com/logging/docs/api/reference/rest/v2/LogEntry#logentryoperation)
     *           for more information.
     * }
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        $this->validateLogLevel($level);
        $options = [];

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $context['exception'] = (string) $context['exception'];
        }

        if (isset($context['stackdriverOptions'])) {
            $options = $context['stackdriverOptions'];
            unset($context['stackdriverOptions']);
        }

        $formatter = new NormalizerFormatter();
        $processor = new PsrLogMessageProcessor();
        $processedData = $processor([
            'message' => (string) $message,
            'context' => $formatter->format($context)
        ]);
        $jsonPayload = [SELF::MESSAGE_KEY => $processedData['message']];

        $entry = $this->getLogger()->entry(
            $jsonPayload + $processedData['context'],
            $options + [
                'severity' => strtoupper($level)
            ]
        );

        $this->batchRunner->submitItem($this->identifier, $entry);
    }

    /**
     * Send the given entries.
     *
     * @param array $entries An array of entries to send.
     * @return boolean
     */
    public function sendEntries($entries)
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

    /**
     * Validates whether or not the provided log level exists.
     *
     * @param string $level The severity of the log entry.
     * @return bool
     * @throws InvalidArgumentException
     */
    private function validateLogLevel($level)
    {
        if (in_array($level, self::$logLevels)) {
            return true;
        }
        throw new InvalidArgumentException(
            "Severity level '$level' is not defined."
        );
    }
}
