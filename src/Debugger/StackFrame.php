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
     * @var string
     */
    private $function;

    /**
     * @var SourceLocation
     */
    private $location;

    /**
     * @var Variable[]
     */
    private $arguments = [];

    /**
     * @var Variable[]
     */
    private $locals = [];

    /**
     * Instantiate a new StackFrame.
     *
     * @type string $function The name of the function
     * @type SourceLocation $location The source location
     */
    public function __construct($function, SourceLocation $location)
    {
        $this->function = $this->pluck('function', $data, false);
        $this->location = new SourceLocation($this->pluck('location', $data, false));
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
