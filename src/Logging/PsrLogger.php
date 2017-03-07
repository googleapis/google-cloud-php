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

use Monolog\Formatter\NormalizerFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A PSR-3 compliant logger used to write entries to Google Stackdriver Logging.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $logging = $cloud->logging();
 *
 * $psrLogger = $logging->psrLogger('my-log');
 * ```
 */
class PsrLogger implements LoggerInterface
{
    /**
     * @var Logger The logger used to write entries.
     */
    protected $logger;

    /**
     * @var string The key to use for messages logged in the `jsonPayload`.
     */
    private $messageKey;

    /**
     * @param Logger $logger The logger used to write entries.
     * @param string $messageKey The key in the `jsonPayload` used to contain
     *        the logged message. **Defaults to** `message`.
     */
    public function __construct(Logger $logger, $messageKey = 'message')
    {
        $this->logger = $logger;
        $this->messageKey = $messageKey;
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
        $jsonPayload = [$this->messageKey => $processedData['message']];

        $entry = $this->logger->entry(
            $jsonPayload + $processedData['context'],
            $options + [
                'severity' => $level
            ]
        );

        $this->logger->write($entry);
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
        $map = $this->logger->getLogLevelMap();
        $level = (string) $level;

        if (isset($map[$level]) || isset(array_flip($map)[strtoupper($level)])) {
            return true;
        }

        throw new InvalidArgumentException("Severity level '$level' is not defined.");
    }
}
