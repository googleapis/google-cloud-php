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

    const ACTION_CAPTURE = 'CAPTURE';
    const ACTION_LOG = 'LOG';
    const REFERENCE_UNSPECIFIED = 'UNSPECIFIED';
    const REFERENCE_BREAKPOINT_SOURCE_LOCATION = 'BREAKPOINT_SOURCE_LOCATION';
    const REFERENCE_BREAKPOINT_CONDITION = 'BREAKPOINT_CONDITION';
    const REFERENCE_BREAKPOINT_EXPRESSION = 'BREAKPOINT_EXPRESSION';
    const REFERENCE_BREAKPOINT_AGE = 'BREAKPOINT_AGE';
    const REFERENCE_VARIABLE_NAME = 'VARIABLE_NAME';
    const REFERENCE_VARIABLE_VALUE = 'VARIABLE_VALUE';
    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_WARNING = 'WARNING';
    const LOG_LEVEL_ERROR = 'ERROR';

    /**
     * @var array Breakpoint data
     */
    private $info;

    /**
     * Instantiate a Breakpoint from its JSON representation
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->info = $this->pluckArray([
            'id',
            'action',
            'condition',
            'expressions',
            'logMessageFormat',
            'logLevel',
            'isFinalState',
            'createTime',
            'finalTime',
            'userEmail',
            'labels'
        ], $data);

        if (array_key_exists('location', $data)) {
            $this->info['location'] = new SourceLocation($data['location']);
        }

        if (array_key_exists('status', $data)) {
            $this->info['status'] = new StatusMessage($data['status']);
        }

        if (array_key_exists('stackFrames', $data)) {
            $this->info['stackFrames'] = array_map(
                function ($data) {
                    return StackFrame::fromJson($data);
                },
                $data['stackFrames']
            );
        }

        if (array_key_exists('evaluatedExpressions', $data)) {
            $this->info['evaluatedExpressions'] = array_map(
                function ($data) {
                    return new Variable($data);
                },
                $data['evaluatedExpressions']
            );
        }

        if (array_key_exists('variableTable', $data)) {
            $this->info['variableTable'] = new VariableTable($data['variableTable']);
        }
    }

    /**
     * Return the breakpoint id.
     *
     * @return string
     */
    public function id()
    {
        return $this->info['id'];
    }

    /**
     * Return the type of breakpoint.
     *
     * @return string
     */
    public function action()
    {
        return isset($this->info['action']) ? $this->info['action'] : self::ACTION_CAPTURE;
    }

    /**
     * Return the source location for this breakpoint.
     *
     * @return SourceLocation
     */
    public function location()
    {
        return $this->info['location'];
    }

    /**
     * Return the condition for this breakpoint.
     *
     * @return string
     */
    public function condition()
    {
        return isset($this->info['condition']) ? $this->info['condition'] : '';
    }

    /**
     * Returns the log level for this breakpoint.
     *
     * @return string
     */
    public function logLevel()
    {
        return isset($this->info['logLevel']) ? $this->info['logLevel'] : self::LOG_LEVEL_INFO;
    }

    /**
     * Return the log message format for this breakpoint.
     *
     * @return string
     */
    public function logMessageFormat()
    {
        return isset($this->info['logMessageFormat']) ? $this->info['logMessageFormat'] : '';
    }

    /**
     * Return the expressions to evaluate for this breakpoint.
     *
     * @return string[]
     */
    public function expressions()
    {
        return isset($this->info['expressions']) ? $this->info['expressions'] : [];
    }

    /**
     * Return the breakpoint's data
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->info;
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
        $this->info['finalTime'] = $when->format('Y-m-d\TH:i:s.u\Z');
        $this->info['isFinalState'] = true;
    }

    /**
     * Add collected data to this breakpoint.
     *
     * @param array $stackFrames
     */
    public function addStackFrames(array $stackFrames)
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
     * }
     */
    public function addStackFrame($stackFrameData)
    {
        $function = isset($stackFrameData['function'])
            ? $stackFrameData['function']
            : null;

        $sf = new StackFrame(
            $function,
            new SourceLocation([
                'path' => $stackFrameData['filename'],
                'line' => $stackFrameData['line']
            ])
        );

        if (isset($stackFrameData['locals'])) {
            foreach ($stackFrameData['locals'] as $local) {
                $value = isset($local['value']) ? $local['value'] : null;
                $variable = $this->addVariable($local['name'], $value);
                $sf->addLocal($variable);
            }
        }
        if (!array_key_exists('stackFrames', $this->info)) {
            $this->info['stackFrames'] = [];
        }
        array_push($this->info['stackFrames'], $sf);
    }

    /**
     * Add evaluated expression results to this breakpoint.
     *
     * @param array $expressions Key is the expression executed. Value is the
     *        execution result.
     */
    public function addEvaluatedExpressions(array $expressions)
    {
        if (!array_key_exists('evaluatedExpressions', $this->info)) {
            $this->info['evaluatedExpressions'] = [];
        }
        foreach ($expressions as $expression => $result) {
            $variable = $this->addVariable($expression, $result);
            array_push($this->info['evaluatedExpressions'], $variable);
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
        if ($this->condition() && !empty($this->condition())) {
            // validate that the condition is ok for debugging
            try {
                if (!stackdriver_debugger_valid_statement($this->condition())) {
                    $this->setError(
                        self::REFERENCE_BREAKPOINT_CONDITION,
                        'Invalid breakpoint condition - Invalid operations: $0.',
                        [$this->condition]
                    );
                    return false;
                }
            } catch (\ParseError $e) {
                $this->setError(
                    self::REFERENCE_BREAKPOINT_CONDITION,
                    'Invalid breakpoint condition - Parse error: $0.',
                    [$this->condition]
                );
                return false;
            }
        }

        if ($this->expressions()) {
            foreach ($this->expressions() as $expression) {
                if (!stackdriver_debugger_valid_statement($expression)) {
                    $this->setError(
                        self::REFERENCE_BREAKPOINT_EXPRESSION,
                        'Invalid breakpoint expression: $0',
                        [$expression]
                    );
                    return false;
                }
            }
        }
        return true;
    }

    private function setError($type, $message, $parameters)
    {
        $this->info['status'] = new StatusMessage([
            'isError' => true,
            'refersTo' => $type,
            'description' => new FormatMessage([
                'format' => $message,
                'parameters' => $parameters
            ])
        ]);
    }

    private function addVariable($name, $value)
    {
        if (!array_key_exists('variableTable', $this->info)) {
            $this->info['variableTable'] = new VariableTable();
        }
        return $this->info['variableTable']->register($name, $value);
    }
}
