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

use Google\Cloud\Trace\Tracer\TracerInterface;
use Psr\Log\LoggerInterface;

/**
 * This implementation of the ReporterInterface appends a json
 * representation of the trace to a file.
 */
class LoggerReporter implements ReporterInterface
{
    const DEFAULT_LOG_LEVEL = 'notice';

    /**
     * @var LoggerInterface The logger to write to.
     */
    private $logger;

    /**
     * @var string Logger level to report at
     */
    private $level;

    /**
     * Create a new LoggerReporter
     *
     * @param LoggerInterface $logger The logger to write to.
     * @param string $level The logger level to write as. **Defaults to** `notice`.
     */
    public function __construct(LoggerInterface $logger, $level = self::DEFAULT_LOG_LEVEL)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    /**
     * Report the provided Trace to a backend.
     *
     * @param  TracerInterface $tracer
     * @return bool
     */
    public function report(TracerInterface $tracer)
    {
        try {
            $this->logger->log($this->level, json_encode($tracer->spans()));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
