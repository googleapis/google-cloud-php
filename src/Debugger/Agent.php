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

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\BatchTrait;
use Google\Cloud\Logging\LoggingClient;

class Agent
{
    use BatchTrait;

    /**
     * @var Debuggee
     */
    private static $debuggee;
    private $debuggeeId;

    private $breakpoints = [];

    public function __construct(array $options = [])
    {
        $storage = new BreakpointStorage();
        list($this->debuggeeId, $breakpoints) = $storage->load();

        $this->setCommonBatchProperties($options + [
            'identifier' => 'stackdriver-debugger',
            'batchMethod' => 'insertBatch'
        ]);
        self::$debuggee = isset($options['debuggee'])
            ? $options['debuggee']
            : $this->defaultDebuggee();

        if (empty($breakpoints)) {
            return;
        }

        $sourceFile = isset($options['sourceRoot'])
            ? $options['sourceRoot'] . '/foo'
            : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file'];

        foreach ($breakpoints as $breakpoint) {
            $this->breakpoints[$breakpoint->id()] = $breakpoint;
            switch ($breakpoint->action()) {
                case null:
                case Action::CAPTURE:
                    $sourceLocation = $breakpoint->location();
                    stackdriver_debugger_add_snapshot(
                        $sourceLocation->path(),
                        $sourceLocation->line(),
                        $breakpoint->id(),
                        $breakpoint->condition(),
                        $breakpoint->expressions(),
                        $sourceFile
                    );

                    break;
                case Action::LOG:
                default:
                    continue;
            }
        }

        register_shutdown_function([$this, 'onFinish']);
    }

    public function onFinish()
    {
        $list = stackdriver_debugger_list();
        foreach ($list as $snapshot) {
            if (array_key_exists($snapshot['id'], $this->breakpoints)) {
                $breakpoint = $this->breakpoints[$snapshot['id']];
                $breakpoint->finalize();
                $breakpoint->addEvaluatedExpressions($snapshot['evaluatedExpressions']);
                $breakpoint->addStackFrames($snapshot['stackframes']);
                $this->batchRunner->submitItem($this->identifier, $breakpoint);
            }
        }
    }

    protected function getCallback()
    {
        if (!isset(self::$debuggee)) {
            self::$debuggee = $this->defaultDebuggee();
        }
        return [self::$debuggee, 'updateBreakpointBatch'];
    }

    private function defaultDebuggee()
    {
        $client = new DebuggerClient($this->clientConfig);
        return $client->debuggee($this->debuggeeId, [
            'uniquifier' => 'foo-bar2',
            'description' => 'Debugger for test'
        ]);
    }
}
