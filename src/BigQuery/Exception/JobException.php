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

namespace Google\Cloud\BigQuery\Exception;

use Google\Cloud\BigQuery\Job;

/**
 * Exception thrown when a job fails to complete.
 */
class JobException extends \RuntimeException
{
    /**
     * @param string $message
     * @param Job $job
     */
    public function __construct($message, Job $job)
    {
        $this->job = $job;
        parent::__construct($message, 0);
    }

    /**
     * Returns the job instance associated with the failure.
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
