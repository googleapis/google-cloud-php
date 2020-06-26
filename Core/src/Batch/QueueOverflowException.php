<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Core\Batch;

/**
 * Exception thrown in {@see Google\Cloud\Core\Batch\SysvProcessor::submit()}
 * method when it cannot add an item to the message queue.
 * Possible causes include:
 *
 * - batch daemon is not running
 * - no job registered for this queue
 * - items are submitted faster than a job can handle them
 */
class QueueOverflowException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Item queue overflow. Check that the batch daemon is running.');
    }
}
