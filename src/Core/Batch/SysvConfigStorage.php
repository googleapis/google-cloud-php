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
 * ConfigStorageInterface implementation with SystemV IPC shared memory.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class SysvConfigStorage implements ConfigStorageInterface
{
    const VAR_KEY = 1;

    /* @var int */
    private $sysvKey;

    /* @var int */
    private $semid;

    /**
     * Prepare the key for semaphore and shared memory.
     */
    public function __construct()
    {
        $this->sysvKey = ftok(__FILE__, 'A');
        $this->semid = sem_get($this->sysvKey, 1, 0600, 1);
    }

    /**
     * Acquire a lock.
     *
     * @return bool
     */
    public function lock()
    {
        return sem_acquire($this->semid);
    }

    /**
     * Release a lock.
     *
     * @return bool
     */
    public function unlock()
    {
        return sem_release($this->semid);
    }

    /**
     * Save the given BatchConfig.
     *
     * @param BatchConfig $config A BatchConfig to save.
     * @return bool
     * @throws \RuntimeException when failed to attach to the shared memory or serialization fails
     */
    public function save(BatchConfig $config)
    {
        $shmid = shm_attach($this->sysvKey);
        if ($shmid === false) {
            throw new \RuntimeException(
                'Failed to attach to the shared memory'
            );
        }

        // If the variable write fails, clear the memory and re-raise the exception
        try {
            $result = shm_put_var($shmid, self::VAR_KEY, $config);
        } catch (\Exception $e) {
            $this->clear();
            throw new \RuntimeException($e->getMessage());
        } finally {
            shm_detach($shmid);
        }
        return $result;
    }

    /**
     * Load a BatchConfig from the storage.
     *
     * @return BatchConfig
     * @throws \RuntimeException when failed to attach to the shared memory or deserialization fails
     */
    public function load()
    {
        $shmid = shm_attach($this->sysvKey);
        if ($shmid === false) {
            throw new \RuntimeException(
                'Failed to attach to the shared memory'
            );
        }
        if (! shm_has_var($shmid, self::VAR_KEY)) {
            $result = new BatchConfig();
        } else {
            $result = shm_get_var($shmid, self::VAR_KEY);
        }
        shm_detach($shmid);

        if ($result === false) {
            throw new \RuntimeException(
                'Failed to deserialize data from shared memory'
            );
        }
        return $result;
    }

    /**
     * Clear the BatchConfig from storage.
     */
    public function clear()
    {
        $shmid = shm_attach($this->sysvKey);
        shm_remove_var($shmid, self::VAR_KEY);
    }
}
