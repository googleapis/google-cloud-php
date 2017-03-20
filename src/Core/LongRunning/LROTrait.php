<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\LongRunning;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;

/**
 * Provide Long Running Operation support to Google Cloud PHP Clients.
 */
trait LROTrait
{
    /**
     * Create a Long Running Operation from an operation name.
     *
     * @param LongRunningConnectionInterface $connection The LRO connection
     * @param string $operationName The name of the Operation.
     * @param array $lroCallables A map of callables to normalize inputs and results.
     * @return LongRunningOperation
     */
    private function lro(LongRunningConnectionInterface $connection, $operationName, array $lroCallables)
    {
        return new LongRunningOperation(
            $connection,
            $operationName,
            $lroCallables
        );
    }
}
