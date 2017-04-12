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
 * A class for executing jobs in batch.
 */
class BatchRunner
{
    use SysvTrait;

    /**
     * @var BatchConfig
     */
    private $config;

    /**
     * @var ConfigStorageInterface
     */
    private $configStorage;

    /**
     * @var SubmitItemInterface
     */
    private $submitter;

    /**
     * Determine internal implementation and loads the configuration.
     *
     * @param ConfigStorageInterface $configStorage [optional] The
     *        ConfigStorage object to use. **Defaults to** null.
     * @param SubmitItemInterface $submitter [optional] The submitter
     *        object to use. **Defaults to** null.
     */
    public function __construct(
        ConfigStorageInterface $configStorage = null,
        SubmitItemInterface $submitter = null
    ) {
        if ($configStorage === null || $submitter === null) {
            if ($this->isSysvIPCLoaded() && $this->isDaemonRunning()) {
                $configStorage = new SysvConfigStorage();
                $submitter = new SysvSubmitter();
            } else {
                $configStorage = InMemoryConfigStorage::getInstance();
                $submitter = $configStorage;
            }
        }
        $this->configStorage = $configStorage;
        $this->submitter = $submitter;
        $this->loadConfig();
    }

    /**
     * Register a job for batch execution.
     *
     * @param string $identifier Unique identifier of the job.
     * @param callable $func Any Callable except for Closure. The callable
     *        should accept an array of items as the first argument.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $batchSize The size of the batch.
     *     @type int $callPeriod The period in seconds from the last execution
     *               to force executing the job.
     *     @type int $workerNum The number of child processes. It only takes
     *               effect with the {@see \Google\Cloud\Core\BatchDaemon}.
     *     @type string $bootstrapFile A file to load before executing the
     *                  job. It's needed for registering global functions.
     * }
     * @return boolean true on success, false on failure
     * @throws \InvalidArgumentException When receiving a Closure.
     */
    public function registerJob($identifier, $func, $options = [])
    {
        if ($func instanceof \Closure) {
            throw new \InvalidArgumentException('Closure is not allowed');
        }
        // Always work on the latest data
        $result = $this->configStorage->lock();
        if ($result === false) {
            return false;
        }
        $this->config = $this->configStorage->load();
        $this->config->registerJob($identifier, $func, $options);

        $result = $this->configStorage->save($this->config);
        if ($result === false) {
            return false;
        }
        $this->configStorage->unlock();
        return true;
    }

    /**
     * Submit an item.
     *
     * @param string $identifier Unique identifier of the job.
     * @param mixed $item It needs to be serializable.
     *
     * @return boolean true on success, false on failure
     */
    public function submitItem($identifier, $item)
    {
        $job = $this->getJobFromId($identifier);
        if ($job === null) {
            throw new \RuntimeException(
                'The identifier does not exist: ' . $identifier
            );
        }
        $idNum = $job->getIdnum();
        return $this->submitter->submit($item, $idNum);
    }

    /**
     * Get the job with the given identifier.
     *
     * @param string $identifier Unique identifier of the job.
     *
     * @return BatchJob|null
     */
    public function getJobFromId($identifier)
    {
        return $this->config->getJobFromId($identifier);
    }

    /**
     * Get the job with the given numeric id.
     *
     * @param int $idNum A numeric id of the job.
     *
     * @return BatchJob|null
     */
    public function getJobFromIdNum($idNum)
    {
        return $this->config->getJobFromIdNum($idNum);
    }

    /**
     * Get all the jobs.
     *
     * @return BatchJob[]
     */
    public function getJobs()
    {
        return $this->config->getJobs();
    }

    /**
     * Load the config from the storage.
     *
     * @return boolean true on success, false on failure
     */
    public function loadConfig()
    {
        $result = $this->configStorage->lock();
        if ($result === false) {
            return false;
        }
        $result = $this->configStorage->load();
        $this->configStorage->unlock();
        if ($result === false) {
            // TODO: think what to do
            return false;
        }
        $this->config = $result;
        return true;
    }
}
