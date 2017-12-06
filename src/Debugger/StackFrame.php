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
 * Represents a stack frame context.
 */
class StackFrame implements \JsonSerializable
{
    use ArrayTrait;

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
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function fromJson($data)
    {
        $location = array_key_exists('location', $data)
            ? $data['location']
            : null;
        return new static(
            array_key_exists('function', $data) ? $data['function'] : null,
            new SourceLocation($location)
        );
    }

    /**
     * Register a local variable in this stack frame.
     *
     * @param Variable $variable
     */
    public function addLocal(Variable $variable)
    {
        array_push($this->locals, $variable);
    }

    /**
     * Returns a JSON serializable array representation of the stack frame.
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'function' => $this->function,
            'location' => $this->location,
            'arguments' => $this->arguments,
            'locals' => $this->locals
        ];
    }
}
