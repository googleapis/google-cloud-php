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

/**
 * Represents a stack frame context.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\SourceLocation;
 * use Google\Cloud\Debugger\StackFrame;
 *
 * $location = new SourceLocation('/path/to/file.php', 10);
 * $stackFrame = new StackFrame('function-name', $location);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#stackframe StackFrame model documentation
 * @codingStandardsIgnoreEnd
 */
class StackFrame
{
    /**
     * @var string Demangled function name at the call site.
     */
    private $function;

    /**
     * @var SourceLocation Source location of the call site.
     */
    private $location;

    /**
     * @var Variable[] Set of arguments passed to this function. Note that this
     *      might not be populated for all stack frames.
     */
    private $arguments = [];

    /**
     * @var Variable[] Set of local variables at the stack frame location. Note
     *      that this might not be populated for all stack frames.
     */
    private $locals = [];

    /**
     * Instantiate a new StackFrame.
     *
     * @access private
     * @param string $function Demangled function name at the call site.
     * @param SourceLocation $location The source location
     */
    public function __construct($function, SourceLocation $location)
    {
        $this->function = $function;
        $this->location = $location;
    }

    /**
     * Instantiate a new StackFrame from JSON form
     *
     * Example:
     * ```
     * $stackFrame = StackFrame::fromJson([
     *     'function' => 'function-name',
     *     'location' => [
     *         'path' => '/path/to/file.php',
     *         'line' => 10
     *     ]
     * ]);
     * ```
     *
     * @access private
     * @param array $data {
     *      @type string $function Demangled function name at the call site.
     *      @type SourceLocation $location The source location
     * }
     * @return StackFrame
     */
    public static function fromJson(array $data)
    {
        $data += [
            'location' => [],
            'function' => null
        ];

        return new static(
            $data['function'],
            SourceLocation::fromJson($data['location'])
        );
    }

    /**
     * Register a local variable in this stack frame.
     *
     * Example:
     * ```
     * $stackFrame->addLocal($variable);
     * ```
     *
     * @param Variable $variable
     */
    public function addLocal(Variable $variable)
    {
        array_push($this->locals, $variable);
    }

    /**
     * Returns the captured locals for this stack frame.
     *
     * Example:
     * ```
     * $locals = $stackFrame->locals();
     * ```
     *
     * @return Variable[]
     */
    public function locals()
    {
        return $this->locals;
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        return [
            'function' => $this->function,
            'location' => $this->location->info(),
            'arguments' => array_map(function ($v) {
                return $v->info();
            }, $this->arguments),
            'locals' => array_map(function ($v) {
                return $v->info();
            }, $this->locals)
        ];
    }
}
