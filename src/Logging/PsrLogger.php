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
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $psrLogger = $logging->psrLogger('my-log');
 * ```
 *
 * @method emergency() {
 *     Log an emergency entry.
 *
 *     Example:
 *     ```
 *     $psrLogger->emergency('emergency message');
 *     ```
 *
 *     @param string $message The message to log.
 *     @param array $context [optional] Please see
 *            {@see Google\Cloud\Logging\PsrLogger::log()} for the available
 *            options.
 * }
 *
 * @see http://www.php-fig.org/psr/psr-3/#psrlogloggerinterface Psr\Log\LoggerInterface
 *
 */
class PsrLogger implements LoggerInterface
{
    use PsrLoggerTrait;

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
     * Just return the $logger. It's for allowing to use the trait.
     *
     * @return Logger
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * Send the given entry
     */
    private function sendEntry(Entry $entry)
    {
        $this->logger->write($entry);
    }
}
