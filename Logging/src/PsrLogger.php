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

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\BatchTrait;
use Google\Cloud\Core\Batch\ClosureSerializerInterface;
use Google\Cloud\Core\Report\MetadataProviderInterface;
use Google\Cloud\Core\Report\MetadataProviderUtils;
use Google\Cloud\Core\Timestamp;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * A PSR-3 compliant logger used to write entries to Google Stackdriver Logging.
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $psrLogger = $logging->psrLogger('my-log');
 * ```
 *
 * ```
 * // Write entries with background batching.
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $psrLogger = $logging->psrLogger('my-log', [
 *     'batchEnabled' => true
 * ]);
 * ```
 *
 * @see http://www.php-fig.org/psr/psr-3/#psrlogloggerinterface Psr\Log\LoggerInterface
 */
class PsrLogger implements LoggerInterface, \Serializable
{
    use BatchTrait;

    const ID_TEMPLATE = 'stackdriver-logging-%s';

    /**
     * @var array
     */
    private static $loggers = [];

    /**
     * @var Logger The logger used to write entries.
     */
    protected $logger;

    /**
     * @var string The key to use for messages logged in the `jsonPayload`.
     */
    private $messageKey;

    /**
     * @var bool
     */
    private $batchEnabled;

    /**
     * @var MetadataProviderInterface
     */
    private $metadataProvider;

    /**
     * @var string
     */
    private $logName;

    /**
     * @param Logger $logger The logger used to write entries.
     * @param string $messageKey The key in the `jsonPayload` used to contain
     *        the logged message. **Defaults to** `message`.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type MetadataProviderInterface $metadataProvider **Defaults to** An
     *           automatically chosen provider, based on detected environment
     *           settings.
     *     @type bool $batchEnabled Determines whether or not to use background
     *           batching. **Defaults to** `false`. Note that this option is
     *           currently considered **experimental** and is subject to change.
     *     @type resource $debugOutputResource A resource to output debug output
     *           to.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           Please note debug output currently only applies in CLI based
     *           applications. **Defaults to** `false`. Applies only when
     *           `batchEnabled` is set to `true`.
     *     @type array $batchOptions A set of options for a BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for
     *           more details.
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'numWorkers' => 2]. Applies only when
     *           `batchEnabled` is set to `true`.
     *     @type array $clientConfig Configuration options for the Logging client
     *           used to handle processing of batch items. For valid options
     *           please see
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}.
     *           Applies only when `batchEnabled` is set to `true`.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner. Applies only when `batchEnabled` is set to `true`.
     *     @type ClosureSerializerInterface $closureSerializer An implementation
     *           responsible for serializing closures used in the
     *           `$clientConfig`. This is especially important when using the
     *           batch daemon. **Defaults to**
     *           {@see Google\Cloud\Core\Batch\OpisClosureSerializer} if the
     *           `opis/closure` library is installed.
     * }
     */
    public function __construct(
        Logger $logger,
        $messageKey = null,
        array $options = []
    ) {
        $this->logger = $logger;
        $this->logName = $logger->name();
        $this->messageKey = $messageKey ?: 'message';
        $this->metadataProvider = isset($options['metadataProvider'])
            ? $options['metadataProvider']
            : MetadataProviderUtils::autoSelect($_SERVER);

        if (isset($options['batchEnabled']) && $options['batchEnabled'] === true) {
            $this->batchEnabled = true;
            $this->setCommonBatchProperties($options + [
                'identifier' => sprintf(self::ID_TEMPLATE, $this->logger->name()),
                'batchMethod' => 'writeBatch'
            ]);
        }
    }

    /**
     * Log an emergency entry.
     *
     * Example:
     * ```
     * $psrLogger->emergency('emergency message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->log(Logger::EMERGENCY, $message, $context);
    }

    /**
     * Log an alert entry.
     *
     * Example:
     * ```
     * $psrLogger->alert('alert message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->log(Logger::ALERT, $message, $context);
    }

    /**
     * Log a critical entry.
     *
     * Example:
     * ```
     * $psrLogger->critical('critical message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->log(Logger::CRITICAL, $message, $context);
    }

    /**
     * Log an error entry.
     *
     * Example:
     * ```
     * $psrLogger->error('error message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->log(Logger::ERROR, $message, $context);
    }

    /**
     * Log a warning entry.
     *
     * Example:
     * ```
     * $psrLogger->warning('warning message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->log(Logger::WARNING, $message, $context);
    }

    /**
     * Log a notice entry.
     *
     * Example:
     * ```
     * $psrLogger->notice('notice message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->log(Logger::NOTICE, $message, $context);
    }

    /**
     * Log an info entry.
     *
     * Example:
     * ```
     * $psrLogger->info('info message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->log(Logger::INFO, $message, $context);
    }

    /**
     * Log a debug entry.
     *
     * Example:
     * ```
     * $psrLogger->debug('debug message');
     * ```
     *
     * @param string $message The message to log.
     * @param array $context [optional] Please see {@see Google\Cloud\Logging\PsrLogger::log()}
     *        for the available options.
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->log(Logger::DEBUG, $message, $context);
    }

    /**
     * Write a log entry.
     *
     * Example:
     * ```
     * use Google\Cloud\Logging\Logger;
     *
     * $psrLogger->log(Logger::ALERT, 'alert message');
     * ```
     *
     * ```
     * // Write a log entry using the context array with placeholders.
     * use Google\Cloud\Logging\Logger;
     *
     * $psrLogger->log(Logger::ALERT, 'alert: {message}', [
     *     'message' => 'my alert message'
     * ]);
     * ```
     *
     * ```
     * // Log information regarding an HTTP request
     * use Google\Cloud\Logging\Logger;
     *
     * $psrLogger->log(Logger::ALERT, 'alert message', [
     *     'stackdriverOptions' => [
     *         'httpRequest' => [
     *             'requestMethod' => 'GET'
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @param string|int $level The severity of the log entry.
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
     *     @type string $stackdriverOptions['insertId'] A unique identifier for
     *           the log entry.
     *     @type \DateTimeInterface|Timestamp|string|null $stackdriverOptions['timestamp'] The
     *           timestamp associated with this entry. If providing a string it
     *           must be in RFC3339 UTC "Zulu" format. Example:
     *           "2014-10-02T15:01:23.045123456Z". If explicitly set to `null`
     *           the timestamp will be generated by the server at the moment the
     *           entry is received (with nanosecond precision). **Defaults to**
     *           the current time, generated by the client with microsecond
     *           precision.
     * }
     * @return void
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        $this->validateLogLevel($level);
        $options = [];

        if (isset($context['exception'])
            && ($context['exception'] instanceof \Exception || $context['exception'] instanceof \Throwable)) {
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
        $jsonPayload = [$this->messageKey => $processedData['message']];

        // Adding labels for log request correlation.
        $labels = $this->getLabels();
        if (!empty($labels)) {
            $options['labels'] =
                (isset($options['labels'])
                 ? $options['labels']
                 : []) + $labels;
            // Copy over the value for 'appengine.googleapis.com/trace_id' to
            // `trace` option too.
            if (isset($labels['appengine.googleapis.com/trace_id'])) {
                $options['trace'] =
                    $labels['appengine.googleapis.com/trace_id'];
            }
        }
        // Adding MonitoredResource
        $resource = $this->metadataProvider->monitoredResource();
        if (!empty($resource)) {
            $options['resource'] =
                (isset($options['resource'])
                 ? $options['resource']
                 : []) + $resource;
        }
        $entry = $this->logger->entry(
            $jsonPayload + $processedData['context'],
            $options + [
                'severity' => $level
            ]
        );
        $this->sendEntry($entry);
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
     * Serializes data.
     *
     * @return string
     * @access private
     */
    public function serialize()
    {
        return serialize($this->__serialize());
    }

    /**
     * Unserializes data.
     *
     * @param string
     * @access private
     */
    public function unserialize($data)
    {
        $this->__unserialize(unserialize($data));
    }

    public function __serialize()
    {
        $debugOutputResource = null;
        if (is_resource($this->debugOutputResource)) {
            $metadata = stream_get_meta_data($this->debugOutputResource);
            $debugOutputResource = [
                'uri' => $metadata['uri'],
                'mode' => $metadata['mode']
            ];
        }

        return [
            $this->messageKey,
            $this->batchEnabled,
            $this->metadataProvider,
            $this->debugOutput,
            $this->clientConfig,
            $this->batchMethod,
            $this->logName,
            $debugOutputResource
        ];
    }

    public function __unserialize(array $data)
    {
        list(
            $this->messageKey,
            $this->batchEnabled,
            $this->metadataProvider,
            $this->debugOutput,
            $this->clientConfig,
            $this->batchMethod,
            $this->logName,
            $debugOutputResource
        ) = $data;

        if (is_array($debugOutputResource)) {
            $this->debugOutputResource = fopen(
                $debugOutputResource['uri'],
                $debugOutputResource['mode']
            );
        }
    }

    /**
     * Returns an array representation of a callback which will be used to write
     * batch items.
     *
     * @return array
     */
    protected function getCallback()
    {
        if (!array_key_exists($this->logName, self::$loggers)) {
            $c = new LoggingClient($this->getUnwrappedClientConfig());
            self::$loggers[$this->logName] = $c->logger($this->logName);
        }
        return [self::$loggers[$this->logName], $this->batchMethod];
    }

    /**
     * Validates whether or not the provided log level exists.
     *
     * @param string|int $level The severity of the log entry.
     * @return bool
     * @throws InvalidArgumentException
     */
    private function validateLogLevel($level)
    {
        $map = Logger::getLogLevelMap();
        $level = (string) $level;

        if (isset($map[$level]) || isset(array_flip($map)[strtoupper($level)])) {
            return true;
        }

        throw new InvalidArgumentException("Severity level '$level' is not defined.");
    }

    /**
     * Send the given entry.
     *
     * @param Entry $entry
     */
    private function sendEntry(Entry $entry)
    {
        if ($this->batchEnabled) {
            $this->batchRunner->submitItem($this->identifier, $entry);
            return;
        }

        $this->logger->write($entry);
    }

    /**
     * Return additional labels. Now it returns labels for log request
     * correlation.
     *
     * @return array
     */
    private function getLabels()
    {
        return $this->metadataProvider->labels();
    }
}
