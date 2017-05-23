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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Tracer\TracerInterface;

/**
 * This implementation of the ReporterInterface uses a provided TraceClient to
 * report Traces and their TraceSpans to Stackdriver directly.
 */
class SyncReporter implements ReporterInterface
{
    /**
     * @var TraceClient
     */
    private $client;

    /**
     * Create a TraceReporter that uses the provided TraceClient to report.
     *
     * @param TraceClient $client
     */
    public function __construct(TraceClient $client)
    {
        $this->client = $client;
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

        $trace = $this->client->trace($tracer->context()->traceId());
        $trace->setSpans($spans);
        try {
            return $this->client->insert($trace);
        } catch (ServiceException $e) {
            return false;
        }
    }
}
