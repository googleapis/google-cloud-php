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

use Google\Cloud\Core\ArrayTrait;

/**
 * This plain PHP class represents a debugger breakpoint resource. For more information see
 * [Breakpoint](https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#Breakpoint)
 */
class Breakpoint implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $action;

    /**
     * @var SourceLocation
     */
    private $location;

    /**
     * @var string
     */
    private $condition;

    /**
     * @var string[]
     */
    private $expressions;

    /**
     * @var string
     */
    private $logMessageFormat;

    /**
     * @var LogLevel
     */
    private $logLevel;

    /**
     * @var bool
     */
    private $isFinalState;

    /**
     * @var string
     */
    private $createTime;

    /**
     * @var string
     */
    private $finalTime;

    /**
     * @var string
     */
    private $userEmail;

    /**
     * @var StatusMessage
     */
    private $status;

    /**
     * @var StackFrame[]
     */
    private $stackFrames;

    /**
     * @var Variable[]
     */
    private $evaluatedExpressions;

    /**
     * @var Variable[]
     */
    private $variableTable;

    /**
     * @var array
     */
    private $labels;

    /**
     * Instantiate a Breakpoint from its JSON representation
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->id = $this->pluck('id', $data);
        $this->action = $this->pluck('action', $data, false) ?: Action::CAPTURE;
        $this->location = new SourceLocation($this->pluck('location', $data, false));
        $this->condition = $this->pluck('condition', $data, false) ?: '';
        $this->expressions = $this->pluck('expressions', $data, false) ?: [];
        $this->logMessageFormat = $this->pluck('logMessageFormat', $data, false);
        $this->logLevel = new LogLevel($this->pluck('logLevel', $data, false));
        $this->isFinalState = $this->pluck('isFinalState', $data, false) ?: false;
        $this->createTime = $this->pluck('createTime', $data);
        $this->finalTime = $this->pluck('finalTime', $data, false);
        $this->userEmail = $this->pluck('userEmail', $data, false);
        $this->status = new StatusMessage($this->pluck('status', $data, false));
        $this->stackFrames = array_map(function ($sf) {
            return new StackFrame($sf);
        }, $this->pluck('stackFrames', $data, false) ?: []);
        $this->evaluatedExpressions = array_map(function ($ee) {
            return new Variable($ee);
        }, $this->pluck('evaluatedExpressions', $data, false) ?: []);

        $this->variableTable = new VariableTable();
    }

    /**
     * Return the breakpoint id.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Return the type of breakpoint.
     *
     * @return string
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Return the source location for this breakpoint.
     *
     * @return SourceLocation
     */
    public function location()
    {
        return $this->location;
    }

    /**
     * Return the condition for this breakpoint.
     *
     * @return string
     */
    public function condition()
    {
        return $this->condition;
    }

    /**
     * Return the expressions to evaluate for this breakpoint.
     *
     * @return string[]
     */
    public function expressions()
    {
        return $this->expressions;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'id' => $this->id,
            'action' => $this->action,
            'location' => $this->location,
            'condition' => $this->condition,
            'expressions' => $this->expressions,
            'logMessageFormat' => $this->logMessageFormat,
            'logLevel' => $this->logLevel,
            'isFinalState' => $this->isFinalState,
            'createTime' => $this->createTime,
            'finalTime' => $this->finalTime,
            'userEmail' => $this->userEmail,
            'stackFrames' => $this->stackFrames,
            'evaluatedExpressions' => $this->evaluatedExpressions,
            'variableTable' => $this->variableTable
        ];
        if ($this->status) {
            $data['status'] = $this->status;
        }
        return $data;
    }

    /**
     * Mark this breakpoint as final state and record the current timestamp.
     */
    public function finalize()
    {
        list($usec, $sec) = explode(' ', microtime());
        $micro = sprintf("%06d", $usec * 1000000);
        $when = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        $when->setTimezone(new \DateTimeZone('UTC'));
        $this->finalTime = $when->format('Y-m-d\TH:i:s.u\Z');
        $this->isFinalState = true;
    }

    /**
     * Add collected data to this breakpoint.
     *
     * @param array $stackFrames
     */
    public function addStackFrames($stackFrames)
    {
        foreach ($stackFrames as $stackFrame) {
            $this->addStackFrame($stackFrame);
        }
    }

    /**
     * Add single stackframe of data to this breakpoint.
     *
     * @param array $stackFrameData {
     *      Stackframe information.
     *
     *      @type string $function The name of the function executed.
     *      @type string $filename The name of the file executed.
     *      @type int $line The line number of the file executed.
     *      @type array $locals Captured local variables.
     */
    public function addStackFrame($stackFrameData)
    {
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
                $value = isset($local['value']) ? $local['value'] : null;
                $variable = $this->variableTable->register($local['name'], $value);

                array_push($sf->locals, $variable);
            }
        }
        array_push($this->stackFrames, $sf);
    }

    /**
     * Add evaluated expression results to this breakpoint.
     *
     * @param array $expressions Key is the expression executed. Value is the
     *        execution result.
     */
    public function addEvaluatedExpressions($expressions)
    {
        foreach ($expressions as $expression => $result) {
            $variable = $this->variableTable->register($expression, $result);

            array_push($this->evaluatedExpressions, $variable);
        }
    }

    /**
     * Validate that this breakpoint can be executed. If not valid, the status
     * field will be populated with the corresponding error message.
     *
     * @return bool
     */
    public function validate()
    {
        if ($this->condition && !empty($this->condition)) {
            // validate that the condition is ok for debugging
            if (!stackdriver_debugger_valid_statement($this->condition)) {
                $this->setError(Reference::BREAKPOINT_CONDITION, 'Invalid breakpoint condition: $0.', [$this->condition]);
                return false;
            }
        }

        foreach ($this->expressions as $expression) {
            if (!stackdriver_debugger_valid_statement($expression)) {
                $this->setError(Reference::BREAKPOINT_EXPRESSION, 'Invalid breakpoint expression: $0', [$expression]);
                return false;
            }
        }
        return true;
    }

    private function setError($type, $message, $parameters)
    {
        $this->status = new StatusMessage([
            'isError' => true,
            'refersTo' => $type,
            'description' => new FormatMessage([
                'format' => $message,
                'parameters' => $parameters
            ])
        ]);
    }
}
