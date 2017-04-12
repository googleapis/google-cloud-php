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
 * In-memory ConfigStorageInterface implementation.
 */
final class InMemoryConfigStorage implements
    ConfigStorageInterface,
    SubmitItemInterface
{
    use HandleFailureTrait;

    /* @var BatchConfig */
    private $config;

    /* @var array */
    private $items = [];

    /* @var array */
    private $lastInvoked = [];

    /* @var float */
    private $created;

    /**
     * Singleton getInstance.
     *
     * @return InMemoryConfigStorage
     */
    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new InMemoryConfigStorage();
        }
        return $instance;
    }

    private function __clone()
    {
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * The constructor registers the shutdown function for running the job for
     * remainder items when the script exits.
     */
    private function __construct()
    {
        $this->config = new BatchConfig();
        $this->created = microtime(true);
        $this->initFailureFile();
        register_shutdown_function([$this, 'shutdown']);
    }

    /**
     * Just return true
     *
     * @return boolean
     */
    public function lock()
    {
        return true;
    }

    /**
     * Just return true
     *
     * @return boolean
     */
    public function unlock()
    {
        return true;
    }

    /**
     * Save the given BatchConfig.
     *
     * @param BatchConfig $config A BatchConfig to save.
     * @return bool
     */
    public function save(BatchConfig $config)
    {
        $this->config = $config;
        return true;
    }

    /**
     * Load a BatchConfig from the storage.
     *
     * @return BatchConfig
     */
    public function load()
    {
        return $this->config;
    }

    /**
     * Hold the items in memory and run the job in the same process when it
     * meets the condition.
     * @param mixed $item An item to submit.
     * @param int $idNum A numeric id for the job.
     * @return void
     */
    public function submit($item, $idNum)
    {
        if (!array_key_exists($idNum, $this->items)) {
            $this->items[$idNum] = [];
            $this->lastInvoked[$idNum] = $this->created;
        }
        $this->items[$idNum][] = $item;
        $job = $this->config->getJobFromIdNum($idNum);
        $batchSize = $job->getBatchSize();
        $period = $job->getCallPeriod();
        if ((count($this->items[$idNum]) >= $batchSize)
             || (count($this->items[$idNum]) !== 0
                 && microtime(true) > $this->lastInvoked[$idNum] + $period)) {
            $this->run($idNum);
            $this->items[$idNum] = [];
            $this->lastInvoked[$idNum] = microtime(true);
        }
    }

    /**
     * Run the job with the given id.
     * @param int $idNum A numeric id for the job.
     */
    private function run($idNum)
    {
        $job = $this->config->getJobFromIdNum($idNum);
        if (! $job->run($this->items[$idNum])) {
            $this->handleFailure($idNum, $this->items[$idNum]);
        }
    }

    /**
     * Run the job for remainder items.
     */
    public function shutdown()
    {
        foreach ($this->items as $idNum => $items) {
            if (count($items) !== 0) {
                $this->run($idNum);
            }
        }
    }
}
