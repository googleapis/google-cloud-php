<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Lock;

/**
 * Flock based lock implementation.
 *
 * @see http://php.net/manual/en/function.flock.php
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class FlockLock implements LockInterface
{
    use LockTrait;

    const FILE_PATH_TEMPLATE = '%s/%s.lock';

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var resource|null
     */
    private $handle;

    /**
     * @param string $fileName The name of the file to use as a lock.
     * @throws \InvalidArgumentException If an invalid fileName is provided.
     */
    public function __construct($fileName)
    {
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('$fileName must be a string.');
        }

        $this->filePath = sprintf(
            self::FILE_PATH_TEMPLATE,
            sys_get_temp_dir(),
            $fileName
        );
    }

    /**
     * Acquires a lock that will block until released.
     *
     * @return bool
     * @throws \RuntimeException If the lock fails to be acquired.
     */
    public function acquire()
    {
        if ($this->handle) {
            return true;
        }

        $this->handle = $this->initializeHandle();

        if (!flock($this->handle, LOCK_EX)) {
            fclose($this->handle);
            $this->handle = null;

            throw new \RuntimeException('Failed to acquire lock.');
        }

        return true;
    }

    /**
     * Releases the lock.
     *
     * @throws \RuntimeException If the lock fails to release.
     */
    public function release()
    {
        if ($this->handle) {
            $released = flock($this->handle, LOCK_UN);
            fclose($this->handle);
            $this->handle = null;

            if (!$released) {
                throw new \RuntimeException('Failed to release lock.');
            }
        }
    }

    /**
     * Initializes the handle.
     *
     * @return resource
     * @throws \RuntimeException If the lock file fails to open.
     */
    private function initializeHandle()
    {
        $handle = @fopen($this->filePath, 'c');

        if (!$handle) {
            throw new \RuntimeException('Failed to open lock file.');
        }

        return $handle;
    }
}
