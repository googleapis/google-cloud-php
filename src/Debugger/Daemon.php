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

namespace Google\Cloud\Debugger;

use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Google\Cloud\Debugger\BreakpointStorage\SysvBreakpointStorage;

/**
 * This class is responsible for registering itself as a Debuggee with the
 * Stackdriver backend. It will fetch the list of breakpoints from the
 * Stackdriver backend, validate and normalize them, and store them into the
 * configured breakpoint storage.
 */
class Daemon
{
    /**
     * @var Debuggee
     */
    private $debuggee;

    /**
     * @var string The full path to the source root
     */
    private $sourceRoot;

    /**
     * @var BreakpointStorageInterface
     */
    private $storage;

    /**
     * Creates a new Daemon instance.
     *
     * @param string $sourceRoot The full path to the source root
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type DebuggerClient $client A DebuggerClient to use. **Defaults
     *            to** a new DebuggerClient.
     *      @type array $sourceContext The source code identifier. **Defaults
     *            to** values autodetected from the environment.
     *      @type string $uniquifier A string when uniquely identifies this
     *            debuggee. **Defaults to** a value autodetected from the
     *            environment.
     *      @type bool $debugOutput Whether or not to enable debug output.
     * }
     */
    public function __construct($sourceRoot, array $options = [])
    {
        $client = array_key_exists('client', $options)
            ? $options['client']
            : new DebuggerClient();

        $this->sourceRoot = realpath($sourceRoot);

        $sourceContext = array_key_exists('sourceContext', $options)
            ? $options['sourceContext']
            : $this->defaultSourceContext();
        var_dump($sourceContext);
        $extSourceContext = new ExtendedSourceContext($sourceContext, []);

        $uniquifier = array_key_exists('uniquifier', $options)
            ? $options['uniquifier']
            : $this->defaultUniquifier();

        $name = array_key_exists('name', $options)
            ? $options['name']
            : $this->defaultName();

        $description = $uniquifier;
        $this->debuggee = $client->debuggee($name, [
            'uniquifier' => $uniquifier,
            'description' => $description,
            'sourceContexts' => [$sourceContext],
            'extendedSourceContexts' => [$extSourceContext]
        ]);
        $this->debuggee->register();

        $this->storage = new SysvBreakpointStorage();
    }

    /**
     * Main loop for the daemon. Fetches breakpoints from the DebuggerClient
     * and stores them in shared storage for the application to read. This
     * function runs indefinitely.
     */
    public function run()
    {
        echo "fetching breakpoints...\n";
        $breakpoints = $this->debuggee->breakpoints();
        $this->setBreakpoints($breakpoints);

        while (array_key_exists('nextWaitToken', $breakpoints)) {
            try {
                echo "fetching breakpoints...\n";
                $breakpoints = $this->debuggee->breakpoints([
                    'waitToken' => $breakpoints['nextWaitToken']
                ]);
                $this->setBreakpoints($breakpoints);
            } catch (ConflictException $e) {
                // Ignoring this exception
            }
        }
    }

    private function setBreakpoints($breakpoints)
    {
        $breakpoints = array_key_exists('breakpoints', $breakpoints)
            ? $breakpoints['breakpoints']
            : [];
        $count = count($breakpoints);
        echo "saving $count breakpoints...\n";
        $validBreakpoints = [];
        $invalidBreakpoints = [];
        foreach ($breakpoints as $breakpoint) {
            echo $breakpoint->id() . PHP_EOL;
            var_dump($breakpoint->location());

            // validate breakpoint condition and/or expressions
            if ($breakpoint->validate()) {
                array_push($validBreakpoints, $breakpoint);
            } else {
                $breakpoint->isFinalState = true;
                array_push($invalidBreakpoints, $breakpoint);
            }
        }

        $this->storage->save($this->debuggee, $validBreakpoints);

        if (!empty($invalidBreakpoints)) {
            $this->debuggee->updateBreakpointBatch($invalidBreakpoints);
        }
    }

    private function defaultName()
    {
        return 'default php debugger name';
    }

    private function defaultUniquifier()
    {
        if (isset($_SERVER['GAE_SERVICE'])) {
            return $_SERVER['GAE_SERVICE'] . ' - ' . $_SERVER['GAE_VERSION'];
        }
        return gethostname() . '-' . getcwd();
    }

    private function defaultSourceContext()
    {
        $sourceContextFile = $this->sourceRoot . '/source-context.json';
        if (file_exists($sourceContextFile)) {
            return json_decode(file_get_contents($sourceContextFile), true);
        } else {
            echo "no source context found " . $sourceContextFile;
        }
    }
}
