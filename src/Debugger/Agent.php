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
            echo "no breakpoints\n";
            return;
        }

        $sourceFile = isset($options['sourceRoot'])
            ? $options['sourceRoot'] . '/foo'
            : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file'];

        echo "found " . count($breakpoints) . " breakpoints\n";

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
        $logger->info("Report collected debugger snapshots\n");
        $list = stackdriver_debugger_list();
        var_dump($list);
        $logger->info(json_encode($list));
        foreach ($list as $snapshot) {
            if (array_key_exists($snapshot['id'], $this->breakpoints)) {
                $breakpoint = $this->breakpoints[$snapshot['id']];
                $this->fillBreakpoint($breakpoint, $snapshot);
                echo "submitting item...\n";
                var_dump($breakpoint);
                $this->batchRunner->submitItem($this->identifier, $breakpoint);
            } else {
                echo "found reported snapshot but couldn't find record\n";
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

        $breakpoint->stackFrames = array_map(function ($stackFrameData) {
            $sf = new StackFrame([]);
            if (isset($stackFrameData['function'])) {
                $sf->function = $stackFrameData['function'];
            }
            $sf->location = new SourceLocation([
                'path' => $stackFrameData['filename'],
                'line' => $stackFrameData['line']
            ]);
            if (isset($stackFrameData['locals'])) {
                $sf->locals = array_map(function ($local) {
                    return new Variable([
                        'name' => $local['name']
                    ]);
                }, $stackFrameData['locals']);
            }
            if (isset($stackFrameData['arguments'])) {
                $sf->arguments = array_map(function ($arg) {
                    return new Variable([
                        'name' => $arg['name']
                    ]);
                }, $stackFrameData['arguments']);
            }
            return $sf;
        }, $snapshot['stackframes']);
    }

    private function fakeFill($bp)
    {
        list($usec, $sec) = explode(' ', microtime());
        $micro = sprintf("%06d", $usec * 1000000);
        $when = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        $when->setTimezone(new \DateTimeZone('UTC'));
        $bp->finalTime = $when->format('Y-m-d\TH:i:s.u000\Z');

        // $variable = new Variable([
        //     'name' => 'foo',
        //     'value' => 'bar',
        //     'type' => 'string',
        //     'varTableIndex' => 0
        // ]);
        //
        // array_push($bp->variableTable, $variable);
        $bp->isFinalState = true;

        $bp->stackFrames = StackFrame::fromBacktrace(debug_backtrace());
        foreach (get_defined_vars() as $name => $value) {
            array_push($bp->stackFrames[0]->locals, Variable::fromVariable($name, $value));
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
        // echo "creating new debugger client\n";
        // var_dump($this->debuggeeId);
        $client = new DebuggerClient($this->clientConfig);
        return $client->debuggee($this->debuggeeId, [
            'uniquifier' => 'foo-bar2',
            'description' => 'Debugger for test'
        ]);
    }
}
