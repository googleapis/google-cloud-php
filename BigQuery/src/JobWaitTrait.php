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

namespace Google\Cloud\BigQuery;

use Google\Cloud\BigQuery\Exception\JobException;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\Core\ExponentialBackoff;

/**
 * A utility trait which utilizes exponential backoff to wait until an operation
 * is complete.
 */
trait JobWaitTrait
{
    /**
     * Waits for an operation to complete.
     *
     * @param callable $isCompleteFn
     * @param callable $reloadFn
     * @param Job $job
     * @param int $maxRetries
     * @throws JobException
     */
    private function wait(
        callable $isCompleteFn,
        callable $reloadFn,
        Job $job,
        $maxRetries
    ) {
        if (!$isCompleteFn()) {
            if ($maxRetries === null) {
                $maxRetries = Job::MAX_RETRIES;
            }

            $retryFn = function () use ($isCompleteFn, $reloadFn, $job) {
                $reloadFn();

                if (!$isCompleteFn()) {
                    throw new JobException('Job did not complete within the allowed number of retries.', $job);
                }
            };

            (new ExponentialBackoff($maxRetries))
                ->execute($retryFn);
        }
    }
}
