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

class Daemon
{
    /**
     * @var Debuggee
     */
    private $debuggee;

    private $sourceRoot;

    private $storage;

    public function __construct($sourceRoot, array $info = [])
    {
        $client = array_key_exists('client', $info)
            ? $info['client']
            : new DebuggerClient();

        $this->sourceRoot = realpath($sourceRoot);

        $sourceContext = array_key_exists('sourceContext', $info)
            ? $info['sourceContext']
            : $this->defaultSourceContext();
            var_dump($sourceContext);

        $uniquifier = $this->defaultUniquifier();
        $name = $uniquifier;
        $description = $uniquifier . ' debugger';
        $this->debuggee = $client->debuggee($name, [
            'uniquifier' => $uniquifier,
            'description' => $description,
            'sourceContexts' => [$sourceContext]
        ]);
        $this->debuggee->register();

        $this->storage = new BreakpointStorage();
    }

    public function run()
    {
        echo "fetching breakpoints...\n";
        $breakpoints = $this->debuggee->breakpoints();
        $this->setBreakpoints($breakpoints);

        while (array_key_exists('nextWaitToken', $breakpoints)) {
            try {
                echo "fetching breakpoints...\n";
                $breakpoints = $this->debuggee->breakpoints(['waitToken' => $breakpoints['nextWaitToken']]);
                $this->setBreakpoints($breakpoints);
            } catch (ConflictException $e) {

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
            // echo "{$breakpoint->id()}: {$breakpoint->location()->path}:{$breakpoint->location->line}\n";
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

    private function defaultUniquifier()
    {
        if (isset($_SERVER['GAE_SERVICE'])) {
            return $_SERVER['GAE_SERVICE'] . '-' . $_SERVER['GAE_VERSION'];
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
