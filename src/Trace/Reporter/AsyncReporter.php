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
use Google\Cloud\Core\Batch\BatchTrait;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Tracer\TracerInterface;

/**
 * This implementation of the ReporterInterface use the BatchRunner to provide
 * asynchronous reporting of Traces and their TraceSpans.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class AsyncReporter implements ReporterInterface
{
    use BatchTrait;

    /**
     * @var TraceClient
     */
    private static $client;

    /**
     * Create a TraceReporter that utilizes background batching.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type TraceClient $client A trace client used to instantiate traces
     *           to be delivered to the batch queue.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           Please note debug output currently only applies in CLI based
     *           applications. **Defaults to** `false`.
     *     @type array $batchOptions A set of options for a BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for
     *           more details.
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'workerNum' => 2].
     *     @type array $clientConfig Configuration options for the Trace client
     *           used to handle processing of batch items.
     *           For valid options please see
     *           {@see \Google\Cloud\Trace\TraceClient::__construct()}.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     *     @type string $identifier An identifier for the batch job.
     *           **Defaults to** `stackdriver-trace`.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->setCommonBatchProperties($options + [
            'identifier' => 'stackdriver-trace',
            'batchMethod' => 'insertBatch'
        ]);
        self::$client = isset($options['client'])
            ? $options['client']
            : new TraceClient($this->clientConfig);
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

        $trace = self::$client->trace(
            $tracer->context()->traceId()
        );
        $trace->setSpans($spans);

        try {
            return $this->batchRunner->submitItem($this->identifier, $trace);
        } catch (\Exception $e) {
            return false;
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
        if (!isset(self::$client)) {
            self::$client = new TraceClient($this->clientConfig);
        }

        return [self::$client, $this->batchMethod];
    }
}
