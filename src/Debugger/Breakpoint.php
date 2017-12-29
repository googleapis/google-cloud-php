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
 * This plain PHP class represents a debugger breakpoint resource.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\Breakpoint;
 *
 * $breakpoint = new Breakpoint([
 *     'id' => 'breakpoint-id',
 *     'action' => Breakpoint::ACTION_CAPTURE,
 *     'location' => [
 *         'path' => '/path/to/file.php',
 *         'line' => 10
 *     ]
 * ]);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#Breakpoint Breakpoint model documentation
 * @codingStandardsIgnoreEnd
 */
class Breakpoint implements \JsonSerializable
{
    use ArrayTrait;

    const ACTION_CAPTURE = 'CAPTURE';
    const ACTION_LOG = 'LOG';
    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_WARNING = 'WARNING';
    const LOG_LEVEL_ERROR = 'ERROR';

    /**
     * @var string Breakpoint identifier, unique in the scope of the debuggee.
     */
    private $id;

    /**
     * @var string Action that the agent should perform when the code at the
     *      breakpoint location is hit.
     */
    private $action;

    /**
     * @var SourceLocation Breakpoint source location.
     */
    private $location;

    /**
     * @var string Condition that triggers the breakpoint. The condition is a
     *      compound boolean expression composed using expressions in a
     *      programming language at the source location
     */
    private $condition;

    /**
     * @var string[] List of read-only expressions to evaluate at the breakpoint
     *      location. The expressions are composed using expressions in the
     *      programming language at the source location. If the breakpoint
     *      action is LOG, the evaluated expressions are included in log
     *      statements.
     */
    private $expressions;

    /**
     * @var string Only relevant when action is LOG. Defines the message to log
     *      when the breakpoint hits. The message may include parameter
     *      placeholders $0, $1, etc. These placeholders are replaced with the
     *      evaluated value of the appropriate expression. Expressions not
     *      referenced in logMessageFormat are not logged.
     */
    private $logMessageFormat;

    /**
     * @var string Indicates the severity of the log. Only relevant when action
     *      is LOG.
     */
    private $logLevel;

    /**
     * @var bool When true, indicates that this is a final result and the
     *      breakpoint state will not change from here on.
     */
    private $isFinalState;

    /**
     * @var string Time this breakpoint was created by the server in seconds
     *      resolution. A timestamp in RFC3339 UTC "Zulu" format, accurate to
     *      nanoseconds. Example: "2014-10-02T15:01:23.045123456Z".
     */
    private $createTime;

    /**
     * @var string Time this breakpoint was finalized by the server in seconds
     *      resolution. A timestamp in RFC3339 UTC "Zulu" format, accurate to
     *      nanoseconds. Example: "2014-10-02T15:01:23.045123456Z".
     */
    private $finalTime;

    /**
     * @var string E-mail address of the user that created this breakpoint
     */
    private $userEmail;

    /**
     * @var Status Breakpoint status. The status includes an error flag and a
     *      human readable message. This field is usually unset. The message can
     *      be either informational or an error message. Regardless, clients
     *      should always display the text message back to the user.
     */
    private $status;

    /**
     * @var StackFrame[] The stack at breakpoint time.
     */
    private $stackFrames;

    /**
     * @var Variable[] Values of evaluated expressions at breakpoint time. The
     *      evaluated expressions appear in exactly the same order they are
     *      listed in the expressions field. The name field holds the original
     *      expression text, the value or members field holds the result of the
     *      evaluated expression. If the expression cannot be evaluated, the
     *      status inside the Variable will indicate an error and contain the
     *      error text.
     */
    private $evaluatedExpressions;

    /**
     * @var VariableTable The variableTable exists to aid with computation,
     *      memory and network traffic optimization. It enables storing a
     *      variable once and reference it from multiple variables, including
     *      variables stored in the variableTable itself. For example, the same
     *      this object, which may appear at many levels of the stack, can have
     *      all of its data stored once in this table. The stack frame
     *      variables then would hold only a reference to it.
     */
    private $variableTable;

    /**
     * @var array A set of custom breakpoint properties, populated by the agent,
     *      to be displayed to the user. This is an associative array of key
     *      value pairs.
     */
    private $labels;

    /**
     * Instantiate a Breakpoint from its JSON representation
     *
     * @access private
     * @param array $data {
     *      Breakpoint data.
     *
     *      @type string $id Breakpoint identifier, unique in the scope of the debuggee.
     *      @type string $action Action that the agent should perform when the code at the
     *            breakpoint location is hit.
     *      @type array $location Breakpoint source location in JSON form
     *      @type string $condition Condition that triggers the breakpoint. The condition is a
     *            compound boolean expression composed using expressions in a
     *            programming language at the source location
     *      @type string[] $expressions List of read-only expressions to evaluate at the breakpoint
     *            location. The expressions are composed using expressions in the
     *            programming language at the source location. If the breakpoint
     *            action is LOG, the evaluated expressions are included in log
     *            statements.
     *      @type string $logMessageFormat Only relevant when action is LOG. Defines the message to log
     *            when the breakpoint hits. The message may include parameter
     *            placeholders $0, $1, etc. These placeholders are replaced with the
     *            evaluated value of the appropriate expression. Expressions not
     *            referenced in logMessageFormat are not logged.
     *      @type string $logLevel Indicates the severity of the log. Only relevant when action is LOG.
     *      @type bool $isFinalState When true, indicates that this is a final result and the
     *            breakpoint state will not change from here on.
     *      @type string $createTime Time this breakpoint was created by the server in seconds
     *            resolution. A timestamp in RFC3339 UTC "Zulu" format, accurate to
     *            nanoseconds. Example: "2014-10-02T15:01:23.045123456Z".
     *      @type string $finalTime Time this breakpoint was finalized by the server in seconds
     *            resolution. A timestamp in RFC3339 UTC "Zulu" format, accurate to
     *            nanoseconds. Example: "2014-10-02T15:01:23.045123456Z".
     *      @type string $userEmail E-mail address of the user that created this breakpoint
     *      @type array $status Breakpoint status in JSON form. The status includes an error flag and a
     *            human readable message. This field is usually unset. The message can
     *            be either informational or an error message. Regardless, clients
     *            should always display the text message back to the user.
     *      @type array $stackFrames The stack at breakpoint time. Each stackframe is in JSON form.
     *      @type array $evaluatedExpressions Values of evaluated expressions at breakpoint time in JSON form. The
     *            evaluated expressions appear in exactly the same order they are
     *            listed in the expressions field. The name field holds the original
     *            expression text, the value or members field holds the result of the
     *            evaluated expression. If the expression cannot be evaluated, the
     *            status inside the Variable will indicate an error and contain the
     *            error text.
     *      @type array $variableTable The variableTable exists to aid with computation,
     *            memory and network traffic optimization. It enables storing a
     *            variable once and reference it from multiple variables, including
     *            variables stored in the variableTable itself. For example, the same
     *            this object, which may appear at many levels of the stack, can have
     *            all of its data stored once in this table. The stack frame
     *            variables then would hold only a reference to it. This is an array of Variables
     *            in JSON form.
     *      @type array $labels A set of custom breakpoint properties, populated by the agent,
     *            to be displayed to the user. This is an associative array of key
     *            value pairs.
     * }
     */
    public function __construct(array $data = [])
    {
        $data += [
            'id' => null,
            'action' => null,
            'condition' => null,
            'expressions' => [],
            'logMessageFormat' => null,
            'logLevel' => null,
            'isFinalState' => null,
            'createTime' => null,
            'finalTime' => null,
            'userEmail' => null,
            'stackFrames' => [],
            'evaluatedExpressions' => [],
            'labels' => [],
            'variableTable' => []
        ];
        $this->id = $data['id'];
        $this->action = $data['action'];
        if (array_key_exists('location', $data)) {
            $this->location = SourceLocation::fromJson($data['location']);
        }
        $this->condition = $data['condition'];
        $this->expressions = $data['expressions'];
        $this->logMessageFormat = $data['logMessageFormat'];
        $this->logLevel = $data['logLevel'];
        $this->isFinalState = $data['isFinalState'];
        $this->createTime = $data['createTime'];
        $this->finalTime = $data['finalTime'];
        $this->userEmail = $data['userEmail'];
        if (array_key_exists('status', $data)) {
            $this->status = StatusMessage::fromJson($data['status']);
        }
        $this->stackFrames = array_map(
            [StackFrame::class, 'fromJson'],
            $data['stackFrames']
        );

        $this->evaluatedExpressions = array_map(
            [Variable::class, 'fromJson'],
            $data['evaluatedExpressions']
        );

        $this->variableTable = new VariableTable(
            array_map([Variable::class, 'fromJson'], $data['variableTable'])
        );
    }

    /**
     * Return the breakpoint id.
     *
     * Example:
     * ```
     * echo $breakpoint->id();
     * ```
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
     * Example:
     * ```
     * echo $breakpoint->action();
     * ```
     *
     * @return string
     */
    public function action()
    {
        return $this->action ?: self::ACTION_CAPTURE;
    }

    /**
     * Return the source location for this breakpoint.
     *
     * Example:
     * ```
     * $location = $breakpoint->location();
     * ```
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
     * Example:
     * ```
     * echo $breakpoint->condition();
     * ```
     *
     * @return string
     */
    public function condition()
    {
        return $this->condition;
    }

    /**
     * Returns the log level for this breakpoint.
     *
     * Example:
     * ```
     * echo $breakpoint->logLevel();
     * ```
     *
     * @return string
     */
    public function logLevel()
    {
        return $this->logLevel ?: self::LOG_LEVEL_INFO;
    }

    /**
     * Return the log message format for this breakpoint.
     *
     * Example:
     * ```
     * echo $breakpoint->logMessageFormat();
     * ```
     *
     * @return string
     */
    public function logMessageFormat()
    {
        return $this->logMessageFormat;
    }

    /**
     * Return the expressions to evaluate for this breakpoint.
     *
     * Example:
     * ```
     * $expressions = $breakpoint->expressions();
     * ```
     *
     * @return string[]
     */
    public function expressions()
    {
        return $this->expressions;
    }

    /**
     * Return the list of collected stack frames
     *
     * Example:
     * ```
     * $stackFrames = $breakpoint->stackFrames();
     * ```
     *
     * @return StackFrame[]
     */
    public function stackFrames()
    {
        return $this->stackFrames;
    }

    /**
     * Returns the VariableTable
     *
     * Example:
     * ```
     * $variableTable = $breakpoint->variableTable();
     * ```
     *
     * @return VariableTable
     */
    public function variableTable()
    {
        return $this->variableTable;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [];
        foreach ($this as $key => $value) {
            if ($value !== null && !empty($value)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * Mark this breakpoint as final state and record the current timestamp.
     *
     * Example:
     * ```
     * $breakpoint->finalize();
     * ```
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
     * Example:
     * ```
     * $breakpoint->addStackFrames([
     *     [
     *         'filename' => '/path/to/file.php',
     *         'line' => 10
     *     ]
     * ]);
     * $stackFrames = $breakpoint->stackFrames();
     * ```
     *
     * @param array $stackFrames Array of stackframe data.
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
     * Example:
     * ```
     * $breakpoint->addStackFrame([
     *     'filename' => '/path/to/file.php',
     *     'line' => 10
     * ]);
     * $stackFrames = $breakpoint->stackFrames();
     * ```
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
        $stackFrameData += [
            'function' => null,
            'locals' => []
        ];

        $sf = new StackFrame(
            $stackFrameData['function'],
            new SourceLocation($stackFrameData['filename'], $stackFrameData['line'])
        );

        foreach ($stackFrameData['locals'] as $local) {
            $value = isset($local['value']) ? $local['value'] : null;
            $variable = $this->addVariable($local['name'], $value);
            $sf->addLocal($variable);
        }

        array_push($this->stackFrames, $sf);
    }

    /**
     * Add evaluated expression results to this breakpoint.
     *
     * Example:
     * ```
     * $breakpoint->addEvaluatedExpressions([
     *     '2 + 3' => '5',
     *     '$foo' => 'variable value'
     * ]);
     * ```
     *
     * @param array $expressions Key is the expression executed. Value is the
     *        execution result.
     */
    public function addEvaluatedExpressions(array $expressions)
    {
        foreach ($expressions as $expression => $result) {
            $this->evaluatedExpressions[] = $this->addVariable($expression, $result);
        }
    }

    /**
     * Validate that this breakpoint can be executed. If not valid, the status
     * field will be populated with the corresponding error message.
     *
     * Example:
     * ```
     * $valid = $breakpoint->validate();
     * ```
     *
     * @return bool
     */
    public function validate()
    {
        if (!extension_loaded('stackdriver_debugger')) {
            $this->setError(
                StatusMessage::REFERENCE_UNSPECIFIED,
                'PHP extension not installed.'
            );
            return false;
        }

        if ($this->condition()) {
            // validate that the condition is ok for debugging
            try {
                if (!stackdriver_debugger_valid_statement($this->condition())) {
                    $this->setError(
                        StatusMessage::REFERENCE_BREAKPOINT_CONDITION,
                        'Invalid breakpoint condition - Invalid operations: $0.',
                        [$this->condition]
                    );
                    return false;
                }
            } catch (\ParseError $e) {
                $this->setError(
                    StatusMessage::REFERENCE_BREAKPOINT_CONDITION,
                    'Invalid breakpoint condition - Parse error: $0.',
                    [$this->condition]
                );
                return false;
            }
        }

        foreach ($this->expressions as $expression) {
            if (!stackdriver_debugger_valid_statement($expression)) {
                $this->setError(
                    StatusMessage::REFERENCE_BREAKPOINT_EXPRESSION,
                    'Invalid breakpoint expression: $0',
                    [$expression]
                );
                return false;
            }
        }
        return true;
    }

    private function setError($type, $message, array $parameters = [])
    {
        $this->status = new StatusMessage(
            true,
            $type,
            new FormatMessage($message, $parameters)
        );
    }

    private function addVariable($name, $value)
    {
        $this->variableTable = $this->variableTable ?: new VariableTable();
        return $this->variableTable->register($name, $value);
    }
}
