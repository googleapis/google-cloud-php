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
 * Represent batch jobs.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class BatchJob
{
    const DEFAULT_BATCH_SIZE = 100;
    const DEFAULT_CALL_PERIOD = 2.0;
    const DEFAULT_WORKERS = 1;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var callable
     */
    private $func;

    /**
     * @var int
     */
    private $idNum;

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
     * @var int
     */
    private $workerNum;

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
     * Run the job with the given items.
     *
     * @param array $items An array of items.
     *
     * @return bool the result of the callback
     */
    public function run(array $items)
    {
        if (! is_null($this->bootstrapFile)) {
            require_once($this->bootstrapFile);
        }
        return call_user_func_array($this->func, [$items]);
    }

    /**
     * @return int
     */
    public function getIdNum()
    {
        return $this->idNum;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
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
     * @return int
     */
    public function getWorkerNum()
    {
        return $this->workerNum;
    }

    /**
     * @return string
     */
    public function getBootstrapFile()
    {
        return $this->bootstrapFile;
    }
}
