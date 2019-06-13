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

namespace Google\Cloud\Debugger\BreakpointStorage;

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;

/**
 * This implementation of BreakpointStorageInterface using PHP's shared memory
 * provided by the [Semaphore Functions](http://php.net/manual/en/ref.sem.php).
 */
class SysvBreakpointStorage implements BreakpointStorageInterface
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
     * Save the given debugger breakpoints.
     *
     * @param Debuggee $debuggee
     * @param Breakpoint[] $breakpoints
     * @return bool
     * @throws \RuntimeException when failed to attach to the shared memory.
     */
    public function save(Debuggee $debuggee, array $breakpoints)
    {
        /** @var resource|bool */
        $shmid = shm_attach($this->sysvKey);
        if ($shmid === false) {
            throw new \RuntimeException(
                'Failed to attach to the shared memory'
            );
        }
        $result = shm_put_var($shmid, self::VAR_KEY, [$debuggee->id(), $breakpoints]);
        shm_detach($shmid);
        return $result;
    }

    /**
     * Load debugger breakpoints from the storage. Returns a 2-arity array
     * with the debuggee id and the list of breakpoints.
     *
     * @return array
     * @throws \RuntimeException when failed to attach to the shared memory.
     */
    public function load()
    {
        /** @var resource|bool */
        $shmid = shm_attach($this->sysvKey);
        if ($shmid === false) {
            throw new \RuntimeException(
                'Failed to attach to the shared memory'
            );
        }
        if (!shm_has_var($shmid, self::VAR_KEY)) {
            $result = [null, []];
        } else {
            $result = shm_get_var($shmid, self::VAR_KEY);
        }
        return $result;
    }
}
