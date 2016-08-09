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

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A PSR-3 compliant logger used to write entries to Google Stackdriver Logging.
 */
class PsrLogger implements LoggerInterface
{
    /**
     * @var Logger The logger used to write entries.
     */
    private $logger;

    /**
     * @var array A monitored resource.
     */
    private $resource;

    /**
     * @param Logger $logger The logger used to write entries.
     * @param array $resource The
     *        [monitored resource](https://cloud.google.com/logging/docs/api/ref_v2beta1/rest/v2beta1/MonitoredResource)
     *        to associate log entries with.
     */
    public function __construct(Logger $logger, array $resource)
    {
        $this->logger = $logger;
        $this->resource = $resource;
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @param array $context Please see {@see Google\Cloud\Logging\PsrLogger::log()}
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
     * @codingStandardsIgnoreStart
     * @param string $level The severity of the log entry.
     * @param string $message The message to log.
     * @param array $context {
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
     * }
     * @codingStandardsIgnoreEnd
     */
    public function log($level, $message, array $context = [])
    {
        $message = (string) $message;

        if (!defined(Logger::class . '::' . strtoupper($level))) {
            throw new InvalidArgumentException("Severity level '$level' is not defined.");
        }

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $message .= ' : ' . (string) $context['exception'];
            unset($context['exception']);
        }

        $entry = $this->logger->entry(
            $message,
            $this->resource,
            $context + ['severity' => $level]
        );

        $this->logger->write($entry);
    }
}
