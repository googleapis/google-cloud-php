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

namespace Google\Cloud\Logging;

use Google\Cloud\Logging\LogMessageProcessor\MonologMessageProcessor;
use Google\Cloud\Logging\LogMessageProcessor\MonologV3MessageProcessor;
use Monolog\Logger as MonologLogger;
use RuntimeException;

/**
 * Returns a LogMessageProcessor that can be used with the currently install Monolog version
 */
class LogMessageProcessorFactory
{
    /**
     * @return LogMessageProcessorInterface
     */
    public static function build()
    {
        $version = defined('\Monolog\Logger::API') ? MonologLogger::API : 1;

        switch ($version) {
            case 1:
            case 2:
                return new MonologMessageProcessor();
            case 3:
                return new MonologV3MessageProcessor();
            default:
                throw new RuntimeException('Version not supported');
        }
    }
}
