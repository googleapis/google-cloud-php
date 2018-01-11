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

use Google\Cloud\Core\SysvTrait;

/**
 * Represent batch jobs.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class BatchJob implements JobInterface
{
    const DEFAULT_BATCH_SIZE = 100;
    const DEFAULT_CALL_PERIOD = 2.0;
    const DEFAULT_WORKERS = 1;

    use JobTrait;
    use SysvTrait;

    /**
     * @var callable
     */
    private $func;

    /**
     * @var string
     */
    private $bootstrapFile;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var float
     */
    private $callPeriod;

    /**
     * @param string $identifier Unique identifier of the job.
     * @param callable $func Any Callable except for Closure. The callable
     *        should accept an array of items as the first argument.
     * @param int $idNum A numeric id for the job.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $batchSize The size of the batch. **Defaults to** `100`.
     *     @type float $callPeriod The period in seconds from the last execution
     *                 to force executing the job. **Defaults to** `2.0`.
     *     @type int $workerNum The number of child processes. It only takes
     *               effect with the {@see \Google\Cloud\Core\Batch\BatchDaemon}.
     *               **Defaults to** `1`.
     *     @type string $bootstrapFile A file to load before executing the
     *                  job. It's needed for registering global functions.
     * }
     */
    public function __construct(
        $identifier,
        $func,
        $idNum,
        array $options = []
    ) {
        $this->identifier = $identifier;
        $this->func = $func;
        $this->idNum = $idNum;
        $this->batchSize = array_key_exists('batchSize', $options)
            ? $options['batchSize']
            : self::DEFAULT_BATCH_SIZE;
        $this->callPeriod = array_key_exists('callPeriod', $options)
            ? $options['callPeriod']
            : self::DEFAULT_CALL_PERIOD;
        $this->bootstrapFile = array_key_exists('bootstrapFile', $options)
            ? $options['bootstrapFile']
            : null;
        $this->workerNum = array_key_exists('workerNum', $options)
            ? $options['workerNum']
            : self::DEFAULT_WORKERS;
    }

    /**
     * Run the job.
     */
    public function run()
    {
        $sysvKey = $this->getSysvKey($this->id;
        $q = msg_get_queue($sysvKey);
        $items = [];
        $lastInvoked = microtime(true);

        if (!is_null($this->bootstrapFile)) {
            require_once($this->bootstrapFile);
        }

        while (true) {
            // Fire SIGALRM after 1 second to unblock the blocking call.
            pcntl_alarm(1);
            if (msg_receive(
                $q,
                0,
                $type,
                8192,
                $message,
                true,
                0, // blocking mode
                $errorcode
            )) {
                if ($type === self::$typeDirect) {
                    $items[] = $message;
                } elseif ($type === self::$typeFile) {
                    $items[] = unserialize(file_get_contents($message));
                    @unlink($message);
                }
            }
            pcntl_signal_dispatch();
            // It runs the job when
            // 1. Number of items reaches the batchSize.
            // 2-a. Count is >0 and the current time is larger than lastInvoked + period.
            // 2-b. Count is >0 and the shutdown flag is true.
            if ((count($items) >= $this->batchSize)
                || (count($items) > 0
                    && (microtime(true) > $lastInvoked + $this->callPeriod
                        || $this->shutdown))) {
                printf(
                    'Running the job with %d items' . PHP_EOL,
                    count($items)
                );
                if (!call_user_func_array($this->func, [$items])) {
                    $this->handleFailure($this->id, $items);
                }
                $items = [];
                $lastInvoked = microtime(true);
            }
            gc_collect_cycles();
            if ($this->shutdown) {
                exit;
            }
        }
    }

    /**
     * @return float
     */
    public function getCallPeriod()
    {
        return $this->callPeriod;
    }

    /**
     * @return int
     */
    public function getBatchSize()
    {
        return $this->batchSize;
    }

    /**
     * @return string
     */
    public function getBootstrapFile()
    {
        return $this->bootstrapFile;
    }
}
