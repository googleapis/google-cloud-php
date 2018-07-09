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

use Google\Cloud\Core\Batch\ClosureSerializerInterface;
use Google\Cloud\Core\Batch\SimpleJobTrait;
use Google\Cloud\Core\Batch\SerializableClientTrait;
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Core\Report\MetadataProviderInterface;
use Google\Cloud\Core\Report\MetadataProviderUtils;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Google\Cloud\Debugger\BreakpointStorage\FileBreakpointStorage;
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
 * $daemon = new Daemon();
 * $daemon->run();
 * ```
 */
class Daemon
{
    use SimpleJobTrait;

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
     * @var array Source context configuration.
     */
    private $extSourceContext;

    /**
     * @var string The uniquifier for this daemon's debuggee.
     */
    private $uniquifier;

    /**
     * @var string The description for this daemon's debuggee.
     */
    private $description;

    /**
     * @var array A set of custom debuggee properties, populated by the agent,
     *      to be displayed to the user.
     */
    private $labels;

    /**
     * Creates a new Daemon instance.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $sourceRoot The full path to the source root.
     *            **Defaults to** the current working directory.
     *      @type array $clientConfig The options to instantiate the default
     *            DebuggerClient.
     *            {@see Google\Cloud\Debugger\DebuggerClient::__construct()}
     *            for the available options.
     *      @type array $sourceContext The source code identifier. **Defaults
     *            to** values autodetected from the environment.
     *      @type array $extSourceContext The source code identifier. **Defaults
     *            to** the $sourceContext option.
     *      @type string $uniquifier A string when uniquely identifies this
     *            debuggee. **Defaults to** a value autodetected from the
     *            environment.
     *      @type string $description A display name for the debuggee in the
     *            Stackdriver Debugger UI. **Defaults to** a value
     *            autodetected from the environment.
     *      @type BreakpointStorageInterface $storage The breakpoint storage
     *            mechanism to use. **Defaults to** a new SysvBreakpointStorage
     *            instance.
     *      @type array $labels A set of custom debuggee properties, populated
     *            by the agent, to be displayed to the user. **Defaults to**
     *            labels detected from the environment.
     *      @type MetadataProviderInterface $metadataProvider **Defaults to** An
     *            automatically chosen provider, based on detected environment
     *            settings.
     *      @type ClosureSerializerInterface $closureSerializer An implementation
     *            responsible for serializing closures used in the
     *            `$clientConfig`. This is especially important when using the
     *            batch daemon. **Defaults to**
     *            {@see Google\Cloud\Core\Batch\OpisClosureSerializer} if the
     *            `opis/closure` library is installed.
     *      @type bool $register Whether to start the worker in the background
     *            using the BatchRunner. **Defaults to** false.
     * }
     */
    public function __construct(array $options = [])
    {
        $options += [
            'sourceRoot' => '.',
            'sourceContext' => [],
            'extSourceContext' => [],
            'uniquifier' => null,
            'description' => null,
            'debuggee' => null,
            'labels' => null,
            'metadataProvider' => null,
            'register' => false
        ];

        $this->setSerializableClientOptions($options);
        $this->sourceRoot = realpath($options['sourceRoot']);
        $sourceContext = $options['sourceContext'] ?: $this->defaultSourceContext();
        $this->extSourceContext = $options['extSourceContext'];
        if (!$this->extSourceContext && $sourceContext) {
            $this->extSourceContext = [
                'context' => $sourceContext
            ];
        }

        $this->uniquifier = $options['uniquifier'];
        $this->description = $options['description'] ?: $this->defaultDescription();
        $this->labels = $options['labels'] ?: $this->defaultLabels($options['metadataProvider']);
        $this->storage = array_key_exists('storage', $options)
            ? $options['storage']
            : $this->defaultStorage();

        if ($options['register']) {
            $this->setSimpleJobProperties($options + [
                'identifier' => 'debugger-daemon'
            ]);
        }
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
    public function run(DebuggerClient $client = null, $asDaemon = true)
    {
        $client = $client ?: $this->defaultClient();
        $extSourceContexts = $this->extSourceContext ? [$this->extSourceContext] : [];
        $uniquifier = $this->uniquifier ?: $this->defaultUniquifier();

        do {
            $debuggee = $client->debuggee(null, [
                'uniquifier' => $uniquifier,
                'description' => $this->description,
                'extSourceContexts' => $extSourceContexts,
                'labels' => $this->labels
            ]);

            // If registration with backoff fails, then propagate the exception.
            $backoff = new ExponentialBackoff();
            $backoff->execute(function () use ($debuggee) {
                $debuggee->register();
            });

            try {
                $options = [];
                do {
                    try {
                        $resp = $debuggee->breakpointsWithWaitToken($options);
                        $this->setBreakpoints($debuggee, $resp['breakpoints']);
                        $options['waitToken'] = $resp['nextWaitToken'];
                    } catch (ConflictException $e) {
                        // The hanging GET call returns a 409 (Conflict) response
                        // when the request times out with a status of 'ABORTED'.
                        // In this case, we'll fetch again with the same waitToken.
                    }
                    gc_collect_cycles();
                } while ($asDaemon);
            } catch (ServiceException $e) {
                // For any other ServiceExceptions, re-register and start over.
            }
            gc_collect_cycles();
        } while ($asDaemon);
    }

    private function setBreakpoints(Debuggee $debuggee, $breakpoints)
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

        $this->storage->save($debuggee, $validBreakpoints);

        if (!empty($invalidBreakpoints)) {
            $debuggee->updateBreakpointBatch($invalidBreakpoints);
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
        return php_uname('n') . ' - ' . getcwd();
    }

    private function defaultSourceContext()
    {
        $sourceContextFile = implode(DIRECTORY_SEPARATOR, [$this->sourceRoot, 'source-context.json']);
        if (file_exists($sourceContextFile)) {
            return json_decode(file_get_contents($sourceContextFile), true);
        }
        return [];
    }

    private function defaultClient()
    {
        return new DebuggerClient($this->getUnwrappedClientConfig());
    }

    private function defaultLabels(MetadataProviderInterface $metadataProvider = null)
    {
        $metadataProvider = $metadataProvider ?: MetadataProviderUtils::autoSelect($_SERVER);
        $labels = [];
        if ($metadataProvider->projectId()) {
            $labels['projectid'] = $metadataProvider->projectId();
        }
        if ($metadataProvider->serviceId()) {
            $labels['module'] = $metadataProvider->serviceId();
        }
        if ($metadataProvider->versionId()) {
            $labels['version'] = $metadataProvider->versionId();
        }
        return $labels;
    }

    private function defaultStorage()
    {
        return $this->isSysvIPCLoaded()
            ? new SysvBreakpointStorage()
            : new FileBreakpointStorage();
    }
}
