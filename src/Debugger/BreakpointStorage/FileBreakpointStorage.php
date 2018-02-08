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

namespace Google\Cloud\Debugger\BreakpointStorage;

use Google\Cloud\Core\Lock\FlockLock;
use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;

/**
 * This implementation of BreakpointStorageInterface using a local file.
 */
class FileBreakpointStorage implements BreakpointStorageInterface
{
    const DEFAULT_FILENAME = 'debugger-breakpoints';

    /* @var string */
    private $filename;

    /* @var LockInterface */
    private $lock;

    /**
     * Create a new FileBreakpointStorage instance.
     *
     * @param string $filename [optional] The full path to the storage file.
     *      **Defaults to** a temporary file in the system's temp directory.
     */
    public function __construct($filename = null)
    {
        $filename = $filename ?: self::DEFAULT_FILENAME;
        $this->filename = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), $filename]);
        $this->lock = new FlockLock($filename . '.lock');
    }

    /**
     * Save the given debugger breakpoints.
     *
     * @param Debuggee $debuggee
     * @param Breakpoint[] $breakpoints
     * @return bool
     */
    public function save(Debuggee $debuggee, array $breakpoints)
    {
        $data = [
            'debuggeeId' => $debuggee->id(),
            'breakpoints' => $breakpoints
        ];

        $success = false;

        // Acquire an exclusive write lock (blocking). There should only be a
        // single Daemon that can call this.
        try {
            $success = $this->lock->synchronize(function () use ($data) {
                return file_put_contents($this->filename, serialize($data)) !== false;
            });
        } catch (\RuntimeException $e) {
            // Do nothing
        }
        return $success;
    }

    /**
     * Load debugger breakpoints from the storage. Returns a 2-arity array
     * with the debuggee id and the list of breakpoints.
     *
     * @return array
     */
    public function load()
    {
        $debuggeeId = null;
        $breakpoints = [];

        // Acquire a read lock (non-blocking). If we fail (file is locked
        // for writing), then we return an empty list of breakpoints and
        // skip debugging for this request.
        try {
            $this->lock->acquire([
                'blocking' => false,
                'exclusive' => false
            ]);
            try {
                $contents = file_get_contents($this->filename);
                $data = unserialize($contents);
                $debuggeeId = $data['debuggeeId'];
                $breakpoints = $data['breakpoints'];
            } finally {
                $this->lock->release();
            }
        } catch (\RuntimeException $e) {
            // Do nothing
        }
        return [$debuggeeId, $breakpoints];
    }
}
