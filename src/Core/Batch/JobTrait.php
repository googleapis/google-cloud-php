<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Batch;

/**
 * A trait to assist in implementing the JobInterface
 */
trait JobTrait
{
    /**
     * @var string The job identifier
     */
    private $identifier;

    /**
     * @var int The job id
     */
    private $id;

    /**
     * @var int The number of workers for this job.
     */
    private $numWorkers = 1;

    /**
     * @var string An optional file that is required to run this job.
     */
    private $bootstrapFile;

    /**
     * Return the job identifier
     *
     * @return string
     */
    public function identifier()
    {
        return $this->identifier;
    }

    /**
     * Return the job id
     *
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Returns the number of workers for this job. **Defaults to* 1.
     *
     * @return int
     */
    public function numWorkers()
    {
        return $this->numWorkers;
    }

    /**
     * Returns the optional file required to run this job.
     *
     * @return string|null
     */
    public function bootstrapFile()
    {
        return $this->bootstrapFile;
    }

    /**
     * Callback triggered when this job is deserialized. If there is a required
     * bootstrapFile, we require the file and signal to the parent to retry
     * deserialization.
     */
    public function __wakeup()
    {
        if ($this->bootstrapFile && !in_array($this->bootstrapFile, get_included_files())) {
            require_once $this->bootstrapFile;
            throw new ReloadJobConfigException();
        }
    }
}
