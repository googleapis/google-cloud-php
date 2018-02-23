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

namespace Google\Cloud\Debugger;

use Google\Cloud\Core\Batch\BatchDaemonTrait;
use Google\Cloud\Core\SysvTrait;

/**
 * This class handles command line options and starts a configured Debugger
 * Daemon.
 */
class CliDaemon
{
    use BatchDaemonTrait;
    use SysvTrait;

    /**
     * @var Daemon
     */
    private $daemon;

    /**
     * Create a new DaemonCli instances.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $config Path to a configuration file that should return
     *           a Daemon instance.
     *     @type string $sourceRoot Path to the source root. Ignored if $config
     *           is set.
     * }
     */
    public function __construct(array $options = [])
    {
        $options += [
            'config' => null,
            'sourceRoot' => null
        ];
        $config = $options['config'];
        $sourceRoot = $options['sourceRoot'];

        if ($config) {
            if (!file_exists($config)) {
                throw new \UnexpectedValueException("Config file '$config' does not exist.");
            }
            // Load the config file. The config file should return a configured
            // Daemon instance.
            $this->daemon = require_once $config;

            if (!is_object($this->daemon) || get_class($this->daemon) !== Daemon::class) {
                throw new \UnexpectedValueException('Config file does not return a Daemon instance.');
            }
        } elseif ($sourceRoot) {
            if (!file_exists($sourceRoot)) {
                throw new \UnexpectedValueException("Source root '$sourceRoot' does not exist.");
            }
            if (!is_dir($sourceRoot)) {
                throw new \UnexpectedValueException("Source root '$sourceRoot' is not a directory.");
            }
            $this->daemon = new Daemon([
                'sourceRoot' => $sourceRoot
            ]);
        } else {
            throw new \InvalidArgumentException('Must specify either config or sourceRoot');
        }

        // If the Daemon would be started by the BatchRunner, then don't run it here.
        if ($this->isDaemonRunning() && $this->isSysvIPCLoaded()) {
            throw new \RuntimeException('Daemon should already be running via BatchDaemon');
        }
    }

    /**
     * Start the Daemon. This is expected to run indefinitely.
     */
    public function run()
    {
        $this->daemon->run();
    }
}
