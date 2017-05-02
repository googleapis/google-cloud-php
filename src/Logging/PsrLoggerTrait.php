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

use Monolog\Formatter\NormalizerFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\InvalidArgumentException;

/**
 * A trait for PSR-3 compliant logger used to write entries to Google Stackdriver Logging.
 */
trait PsrLoggerTrait
{
    /**
     * Return a Logger for sending logs.
     *
     * @return Logger
     */
    protected abstract function getLogger();

    /**
     * Return common labels for each log entry.
     *
     * @return array
     */
    protected function getLabels()
    {
        return [];
    }

    /**
     * Log an emergency entry.
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

        $entry = $this->getLogger()->entry(
            $jsonPayload + $processedData['context'],
            $options + [
                'severity' => $level
            ] + $this->getLabels()
        );
        $this->sendEntry($entry);
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
        $map = $this->getLogger()->getLogLevelMap();
        $level = (string) $level;

        if (isset($map[$level]) || isset(array_flip($map)[strtoupper($level)])) {
            return true;
        }

        throw new InvalidArgumentException("Severity level '$level' is not defined.");
    }
}
