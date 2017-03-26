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
class InMemoryConfigStorage
    implements ConfigStorageInterface, JobSubmitInterface
{

    /* @var \Google\Cloud\Core\Batch\Config */
    private $config;

    /* @var array */
    private $items;

    /* @var array */
    private $lastInvoked;

    /* @var float */
    private $created;

    /* @var string */
    private $failureFile;

    /**
     * The constructor registers the shutdown function for running the job for
     * remainder items when the script exits.
     */
    public function __construct()
    {
        $this->config = new BatchConfig();
        $this->items = array();
        $this->lastInvoked = array();
        $this->created = microtime(true);
        $this->failureFile = tempnam(
            sys_get_temp_dir(),
            sprintf('batch-daemon-failure-%d', getmypid())
        );
        register_shutdown_function(array($this, 'shutdown'));
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
     * @return boolean
     */
    public function save(BatchConfig $config)
    {
        $this->config = $config;
        return true;
    }

    /**
     * Load a BatchConfig from the storage.
     *
     * @return \Google\Cloud\Batch\BatchConfig
     */
    public function load()
    {
        return $this->config;
    }

    /**
     * Hold the items in memory and run the job in the same process when it
     * meets the condition.
     */
    public function submit($item, $idNum)
    {
        if (!array_key_exists($idNum, $this->items)) {
            $this->items[$idNum] = array();
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
            $this->items[$idNum] = array();
            $this->lastInvoked[$idNum] = microtime(true);
        }
    }

    /**
     * Run the job with the given id.
     */
    private function run($idNum)
    {
        $job = $this->config->getJobFromIdNum($idNum);
        printf(
            'Running the job with %d items' . PHP_EOL,
            count($this->items[$idNum])
        );
        if (! $job->run($this->items[$idNum])) {
            // Try to save the items.
            $f = @fopen($this->failureFile, 'w');
            foreach ($this->items[$idNum] as $item) {
                @fwrite($f, serialize($item) . PHP_EOL);
            }
            @fclose($f);
        }
    }

    /**
     * Run the job for remainder items.
     */
    public function shutdown()
    {
        foreach($this->items as $idNum => $items) {
            if (count($items) !== 0) {
                $this->run($idNum);
            }
        }
    }
}
