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

namespace Google\Cloud\Core\Batch;

/**
 * Hold configurations for the \Google\Cloud\Core\Batch\BatchRunner.
 */
class BatchConfig
{
    /**
     * @var \Google\Cloud\Core\Batch\BatchJob[]
     */
	private $jobs;

    /**
     * @var array
     */
    private $idmap;

    /**
     * @var array
     */
    private $idmap_reverse;

    /**
     * Just initialize the internal arrays.
     */
    public function __construct()
    {
        $this->jobs = array();
        $this->idmap = array();
        $this->idmap_reverse = array();
    }

    /**
     * Get the job with the given identifier.
     *
     * @param string $identifier Unique identifier of the job.
     *
     * @return \Google\Cloud\Core\Batch\BatchJob|null
     */
	public function getJobFromId($identifier)
	{
		return array_key_exists($identifier, $this->idmap) ?
            $this->jobs[$identifier] :
            null;
	}

    /**
     * Get the job with the given numeric id.
     *
     * @param int $idNum A numeric id of the job.
     *
     * @return \Google\Cloud\Core\Batch\BatchJob|null
     */
    public function getJobFromIdNum($idNum)
    {
        return array_key_exists($idNum, $this->idmap_reverse) ?
            $this->jobs[$this->idmap_reverse[$idNum]] :
            null;
    }

    /**
     * Register a job for.
     *
     * @param string $identifier Unique identifier of the job.
     * @param callable $func Any Callable except for Closure. The callable
     *        should accept an array of items as the first argument.
     * @param array $options [optional] {
     *    Configuration options.
     *    @type int $batchSize The size of the batch.
     *    @type int $callPeriod The period in seconds from the last execution
     *              to force executing the job.
     *    @type int $workerNum The number of child processes. It only takes
     *              effect when you run the \Google\Cloud\Core\BatchDaemon.
     *    @type string $bootstrapFile A file to load before executing the
     *                 job. It's needed for registering global functions.
     * }
     * @return void
     */
	public function registerJob($identifier, $func, $options = [])
    {
        if (array_key_exists($identifier, $this->idmap)) {
            $idNum = $this->idmap[$identifier];
        } else {
            $idNum = count($this->idmap) + 1;
            $this->idmap_reverse[$idNum] = $identifier;
        }
		$this->jobs[$identifier] = new BatchJob(
            $identifier,
            $func,
            $options,
            $idNum
        );
        $this->idmap[$identifier] = $idNum;
    }

    /**
     * Get all the jobs.
     *
     * @return \Google\Cloud\Core\Batch\BatchJob[]
     */
    public function getJobs()
    {
        return $this->jobs;
    }
}
