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
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\Daemon;
 *
 * $daemon = new Daemon('/path/to/source/root');
 * $daemon->run();
 * ```
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
     *      @type array $extSourceContext The source code identifier. **Defaults
     *            to** values autodetected from the environment.
     *      @type string $uniquifier A string when uniquely identifies this
     *            debuggee. **Defaults to** a value autodetected from the
     *            environment.
     *      @type string $description A display name for the debuggee in the
     *            Stackdriver Debugger UI. **Defaults to** the uniquifier.
     *      @type BreakpointStorageInterface $storage The breakpoint storage
     *            mechanism to use. **Defaults to** a new SysvBreakpointStorage
     *            instance.
     * }
     */
    public function __construct($sourceRoot, array $options = [])
    {
        $client = array_key_exists('client', $options)
            ? $options['client']
            : new DebuggerClient();

        $options += [
            'sourceContext' => [],
            'extSourceContext' => [],
            'uniquifier' => null,
            'description' => null
        ];

        $this->sourceRoot = realpath($sourceRoot);

        $sourceContext = $options['sourceContext'] ?: $this->defaultSourceContext();
        $extSourceContext = $options['extSourceContext'];
        if (!$extSourceContext && $sourceContext) {
            $extSourceContext = [
                'context' => $sourceContext
            ];
        }

        $uniquifier = $options['uniquifier'] ?: $this->defaultUniquifier();
        $description = $options['description'] ?: $this->defaultDescription();

        $this->debuggee = $client->debuggee(null, [
            'uniquifier' => $uniquifier,
            'description' => $description,
            'extSourceContexts' => $extSourceContext ? [$extSourceContext] : []
        ]);

        $this->debuggee->register();

        $this->storage = array_key_exists('storage', $options)
            ? $options['storage']
            : new SysvBreakpointStorage();
    }

    /**
     * Main loop for the daemon. Fetches breakpoints from the DebuggerClient
     * and stores them in shared storage for the application to read. This
     * function runs indefinitely.
     *
     * Example:
     * ```
     * $daemon->run();
     * ```
     */
    public function run()
    {
        $resp = $this->debuggee->breakpointsWithWaitToken();
        $this->setBreakpoints($resp['breakpoints']);

        while (array_key_exists('nextWaitToken', $resp)) {
            try {
                $resp = $this->debuggee->breakpointsWithWaitToken([
                    'waitToken' => $resp['nextWaitToken']
                ]);
                $this->setBreakpoints($resp['breakpoints']);
            } catch (ConflictException $e) {
                // Ignoring this exception
            }
        }
    }

    private function setBreakpoints($breakpoints)
    {
        $validBreakpoints = [];
        $invalidBreakpoints = [];
        foreach ($breakpoints as $breakpoint) {
            // validate breakpoint condition and/or expressions
            if ($breakpoint->validate()) {
                array_push($validBreakpoints, $breakpoint);
            } else {
                $breakpoint->finalize();
                array_push($invalidBreakpoints, $breakpoint);
            }
        }

        $this->storage->save($this->debuggee, $validBreakpoints);

        if (!empty($invalidBreakpoints)) {
            $this->debuggee->updateBreakpointBatch($invalidBreakpoints);
        }
    }

    private function defaultUniquifier()
    {
        $dir = new \RecursiveDirectoryIterator($this->sourceRoot);
        $iterator = new \RecursiveIteratorIterator($dir);
        $regex = new \RegexIterator(
            $iterator,
            '/^.+\.php$/i',
            \RecursiveRegexIterator::GET_MATCH
        );

        $files = array_keys(iterator_to_array($regex));
        return sha1(implode(':', array_map(function ($filename) {
            $relativeFilename = str_replace($this->sourceRoot, '', $filename);
            return $relativeFilename . ':' . filesize($filename);
        }, $files)));
    }

    private function defaultDescription()
    {
        if (isset($_SERVER['GAE_SERVICE'])) {
            return $_SERVER['GAE_SERVICE'] . ' - ' . $_SERVER['GAE_VERSION'];
        }
        return gethostname() . ' - ' . getcwd();
    }

    private function defaultSourceContext()
    {
        $sourceContextFile = implode(DIRECTORY_SEPARATOR, [$this->sourceRoot, 'source-context.json']);
        if (file_exists($sourceContextFile)) {
            return json_decode(file_get_contents($sourceContextFile), true);
        }
        return [];
    }
}
