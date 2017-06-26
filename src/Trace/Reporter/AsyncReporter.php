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

namespace Google\Cloud\Trace\Reporter;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Tracer\TracerInterface;

/**
 * This implementation of the ReporterInterface use the BatchRunner to provide
 * asynchronous reporting of Traces and their TraceSpans.
 */
class AsyncReporter implements ReporterInterface
{
    const BATCH_RUNNER_JOB_NAME = 'stackdriver-trace';

    /**
     * @var TraceClient
     */
    protected static $client;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @var BatchRunner
     */
    private $batchRunner;

    /**
     * @var bool
     */
    private $debugOutput;

    /**
     * Create a TraceReporter that uses the provided TraceClient to report.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $debugOutput Whether or not to output debug information.
     *           **Defaults to** false
     *     @type array $batchOptions An option to BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()}
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'workerNum' => 2]
     *     @type array $clientConfig A config to LoggingClient
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}
     *           **Defaults to** []
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->debugOutput = array_key_exists('debugOutput', $options)
            ? $options['debugOutput']
            : false;
        $this->clientConfig = array_key_exists('clientConfig', $options)
            ? $options['clientConfig']
            : [];
        $batchOptions = array_key_exists('batchOptions', $options)
            ? $options['batchOptions']
            : [];
        $this->batchOptions = $batchOptions + [
            'batchSize' => 1000,
            'callPeriod' => 2.0,
            'workerNum' => 2
        ];

        $this->batchRunner = array_key_exists('batchRunner', $options)
            ? $options['batchRunner']
            : new BatchRunner();
        $this->batchRunner->registerJob(
            self::BATCH_RUNNER_JOB_NAME,
            [$this, 'sendEntries'],
            $this->batchOptions
        );
    }

    /**
     * Report the provided Trace to a backend.
     *
     * @param  TracerInterface $tracer
     * @return bool
     */
    public function report(TracerInterface $tracer)
    {
        $spans = $tracer->spans();
        if (empty($spans)) {
            return false;
        }

        $entry = [
            'traceId' => $tracer->context()->traceId(),
            'spans' => $spans
        ];
        try {
            return $this->batchRunner->submitItem(self::BATCH_RUNNER_JOB_NAME, $entry);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * BatchRunner callback handler for reporting serialied traces
     *
     * @param  array $entries An array of traces to send.
     * @return bool
     */
    public function sendEntries(array $entries)
    {
        $start = microtime(true);
        $client = $this->getClient();
        $traces = array_map(function ($entry) use ($client) {
            $trace = $client->trace($entry['traceId']);
            $trace->setSpans($entry['spans']);
            return $trace;
        }, $entries);

        try {
            $client->insertBatch($traces);
        } catch (ServiceException $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            return false;
        }
        $end = microtime(true);
        if ($this->debugOutput) {
            printf(
                '%f seconds for insertBatch %d entries' . PHP_EOL,
                $end - $start,
                count($entries)
            );
            printf('memory used: %d' . PHP_EOL, memory_get_usage());
        }
        return true;
    }

    protected function getClient()
    {
        if (!isset(self::$client)) {
            self::$client = new TraceClient($this->clientConfig);
        }
        return self::$client;
    }
}
