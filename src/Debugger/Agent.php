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
            // echo "no breakpoints\n";
            return;
        }

        $sourceFile = isset($options['sourceRoot'])
            ? $options['sourceRoot'] . '/foo'
            : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file'];

        // echo "found " . count($breakpoints) . " breakpoints\n";

        foreach ($breakpoints as $breakpoint) {
            $this->breakpoints[$breakpoint->id] = $breakpoint;

            switch ($breakpoint->action->value) {
                case Action::CAPTURE:
                    $sourceLocation = $breakpoint->location;
                    stackdriver_debugger_add_snapshot(
                        $sourceLocation->path,
                        $sourceLocation->line,
                        $breakpoint->id,
                        $breakpoint->condition,
                        $breakpoint->expressions,
                        $sourceFile
                    );

                    break;
                case Action::LOG:
                default:
                    echo "unsupported breakpoint type\n";
                    continue;
            }
        }

        register_shutdown_function([$this, 'onFinish']);
    }

    public function onFinish()
    {
        $loggingClient = new LoggingClient();
        $logger = $loggingClient->psrBatchLogger('foo');
        $logger->info("Report collected debugger snapshots");
        $list = stackdriver_debugger_list();
        $logger->info("Found " . count($list) . " snapshots");
        foreach ($list as $snapshot) {
            if (array_key_exists($snapshot['id'], $this->breakpoints)) {
                $breakpoint = $this->breakpoints[$snapshot['id']];
                $this->fillBreakpoint($breakpoint, $snapshot);
                $this->batchRunner->submitItem($this->identifier, $breakpoint);
            } else {
                $logger->error("found reported snapshot but couldn't find record");
            }
        }
    }

    private function fillBreakpoint($breakpoint, $snapshot)
    {
        list($usec, $sec) = explode(' ', microtime());
        $micro = sprintf("%06d", $usec * 1000000);
        $when = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        $when->setTimezone(new \DateTimeZone('UTC'));
        $breakpoint->finalTime = $when->format('Y-m-d\TH:i:s.u\Z');
        $breakpoint->isFinalState = true;

        $variableTable = [];
        $varTableIndex = 0;
        $breakpoint->stackFrames = [];
        foreach ($snapshot['stackframes'] as $stackFrameData) {
            $sf = new StackFrame([]);
            if (isset($stackFrameData['function'])) {
                $sf->function = $stackFrameData['function'];
            }
            $sf->location = new SourceLocation([
                'path' => $stackFrameData['filename'],
                'line' => $stackFrameData['line']
            ]);

            if (isset($stackFrameData['locals'])) {
                $sf->locals = [];
                foreach ($stackFrameData['locals'] as $local) {
                    $type = gettype($local['value']);
                    if ($type == 'object') {
                        $type = get_class($local['value']);

                    }
                    array_push($sf->locals, new Variable([
                        'name' => $local['name'],
                        'type' => $type,
                        'varTableIndex' => $varTableIndex
                    ]));
                    $variableTable[$varTableIndex++] = new Variable([
                        'name' => $local['name'],
                        'type' => $type,
                        'value' => is_object($local['value']) ? 'object' : (string)$local['value']
                    ]);
                }
            }
            array_push($breakpoint->stackFrames, $sf);
        }
        $breakpoint->variableTable = array_values($variableTable);
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
        // echo "creating new debugger client\n";
        // var_dump($this->debuggeeId);
        $client = new DebuggerClient($this->clientConfig);
        return $client->debuggee($this->debuggeeId, [
            'uniquifier' => 'foo-bar2',
            'description' => 'Debugger for test'
        ]);
    }
}
