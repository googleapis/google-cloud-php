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
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 *
 * $batchLogger = $logging->psrBatchLogger('my-log');
 * ```
 * @see http://www.php-fig.org/psr/psr-3/#psrlogloggerinterface Psr\Log\LoggerInterface
 */
class PsrBatchLogger implements LoggerInterface
{
    use PsrLoggerTrait;

    const ID_TEMPLATE = 'stackdriver-logging-%s';

    /** @var array */
    private static $loggers = [];

    /** @var array */
    private $batchOptions;

    /** @var array */
    private $clientConfig;

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

    /** @var string */
    private $messageKey = 'message';

    /**
     * Return a Logger object for the current logName.
     *
     * @return Logger
     */
    private function getLogger()
    {
        if (! array_key_exists($this->logName, self::$loggers)) {
            $c = new LoggingClient($this->clientConfig);
            $resource = $this->metadataProvider->getMonitoredResource();
            if (empty($resource)) {
                self::$loggers[$this->logName] = $c->logger($this->logName);
            } else {
                self::$loggers[$this->logName] =
                    $c->logger($this->logName, ['resource' => $resource]);
            }
        }
        return self::$loggers[$this->logName];
    }

    /**
     * @param string $logName The name of the log.
     * @param array $options [optional] {
     *     Configuration options.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           **Defaults to** false
     *     @type array $batchOptions An option to BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()}
     *           **Defaults to** ['batchSize' => 1000,
                                  'callPeriod' => 2.0,
                                  'workerNum' => 10]
     *     @type array $clientConfig A config to LoggingClient
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}
     *           **Defaults to** []
     *     @type MetadataProviderInterface $metadataProvider
     *           **Defaults to null** If null, it will be automatically chosen.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     * }
     */
    public function __construct($logName, array $options = [])
    {
        $this->logName = $logName;
        $this->debugOutput = isset($options['debugOutput'])
            ? $options['debugOutput']
            : false;
        $this->identifier = sprintf(self::ID_TEMPLATE, $this->logName);
        $this->metadataProvider = isset($options['metadataProvider'])
            ? $options['metadataProvider']
            : MetadataProviderUtils::autoSelect();
        $this->clientConfig = isset($options['clientConfig'])
            ? $options['clientConfig']
            : [];
        $batchOptions = isset($options['batchOptions'])
            ? $options['batchOptions']
            : [];
        $this->batchOptions = array_merge(
            ['batchSize' => 1000,
             'callPeriod' => 2.0,
             'workerNum' => 10],
            $batchOptions
        );
        $this->batchRunner = isset($options['batchRunner'])
            ? $options['batchRunner']
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
     * Submit the given entry to the BatchRunner.
     */
    private function sendEntry(Entry $entry)
    {
        $this->batchRunner->submitItem($this->identifier, $entry);
    }

    /**
     * Send the given entries.
     *
     * @param array $entries An array of entries to send.
     * @return boolean
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
