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
    public $id;

    /**
     * @var Action
     */
    public $action;

    /**
     * @var SourceLocation
     */
    public $location;

    /**
     * @var string
     */
    public $condition;

    /**
     * @var string[]
     */
    public $expressions;

    /**
     * @var string
     */
    public $logMessageFormat;

    /**
     * @var LogLevel
     */
    public $logLevel;

    /**
     * @var bool
     */
    public $isFinalState;

    /**
     * @var string
     */
    public $createTime;

    /**
     * @var string
     */
    public $finalTime;

    /**
     * @var string
     */
    public $userEmail;

    /**
     * @var StatusMessage
     */
    public $status;

    /**
     * @var StackFrame[]
     */
    public $stackFrames;

    /**
     * @var Variable[]
     */
    public $evaluatedExpressions;

    /**
     * @var Variable[]
     */
    public $variableTable;

    /**
     * @var array
     */
    public $labels;

    public function __construct($data)
    {
        $this->id = $this->pluck('id', $data);
        $this->action = new Action($this->pluck('action', $data, false));
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

    public function id()
    {
        return $this->id;
    }

    public function location()
    {
        return $this->location;
    }

    public function jsonSerialize()
    {
        $data = [
            'id' => $this->id,
            'action' => $this->action->jsonSerialize(),
            'location' => $this->location->jsonSerialize(),
            'condition' => $this->condition,
            'expressions' => $this->expressions,
            'logMessageFormat' => $this->logMessageFormat,
            'logLevel' => $this->logLevel->jsonSerialize(),
            'isFinalState' => $this->isFinalState,
            'createTime' => $this->createTime,
            'finalTime' => $this->finalTime,
            'userEmail' => $this->userEmail,
            'stackFrames' => array_map(function ($sf) {
                return $sf->jsonSerialize();
            }, $this->stackFrames),
            'evaluatedExpressions' => array_map(function ($v) {
                return $v->jsonSerialize();
            }, $this->evaluatedExpressions),
            'variableTable' => $this->variableTable->jsonSerialize()
        ];
        if ($this->status) {
            $data['status'] = $this->status;
        }
        return $data;
    }

    public function addStackFrames($stackFrames)
    {
        foreach ($stackFrames as $stackFrame) {
            $this->addStackFrame($stackFrame);
        }
    }

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
                $variable = $this->addValue($local['name'], $value);

                array_push($sf->locals, $variable);
            }
        }
        array_push($this->stackFrames, $sf);
    }

    public function addEvaluatedExpressions($expressions)
    {
        foreach ($expressions as $expression => $result) {
            $variable = $this->addValue($expression, $result);

            array_push($this->evaluatedExpressions, $variable);
        }
    }

    public function addValue($name, $value)
    {
        return $this->variableTable->register($name, $value);
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
}
