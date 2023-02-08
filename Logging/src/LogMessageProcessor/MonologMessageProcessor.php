<?php
/**
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\Logging\LogMessageProcessor;

use Google\Cloud\Logging\LogMessageProcessorInterface;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Processor\PsrLogMessageProcessor;

/**
 * Uses the Monolog 1/2 PsrLogMessageProcessor to process a
 * record's message according to PSR-3 rules.
 */
final class MonologMessageProcessor implements LogMessageProcessorInterface
{
    /**
     * @var NormalizerFormatter
     */
    private $formatter;

    /**
     * @var PsrLogMessageProcessor
     */
    private $processor;

    public function __construct()
    {
        $this->formatter = new NormalizerFormatter();
        $this->processor = new PsrLogMessageProcessor();
    }

    /**
     * {@inheritdoc}
     */
    public function processLogMessage($message, $context)
    {
        $processor = $this->processor;

        return $processor([
            'message' => (string) $message,
            'context' => $this->formatter->format($context)
        ]);
    }
}
