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
 * Represents a variable or an argument possibly of a compound object type.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\Variable;
 *
 * $variable = new Variable('myVar', 'string', ['value' => 'some value']);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#variable Variable model documentation
 * @codingStandardsIgnoreEnd
 */
class Variable
{
    /**
     * @var string Name of the variable, if any.
     */
    private $name;

    /**
     * @var string Simple value of the variable.
     */
    private $value;

    /**
     * @var string Variable type (e.g. MyClass). If the variable is split with
     *      varTableIndex, type goes next to value. The interpretation of a type
     *      is agent specific. It is recommended to include the dynamic type
     *      rather than a static type of an object.
     */
    private $type;

    /**
     * @var Variable[] Members contained or pointed to by the variable.
     */
    private $members;

    /**
     * @var int Reference to a variable in the shared variable table. More than
     *      one variable can reference the same variable in the table. The
     *      varTableIndex field is an index into variableTable in Breakpoint.
     */
    private $varTableIndex;

    /**
     * @var StatusMessage Status associated with the variable. This field will
     *      usually stay unset. A status of a single variable only applies to
     *      that variable or expression. The rest of breakpoint data still
     *      remains valid. Variables might be reported in error state even when
     *      breakpoint is not in final state.
     */
    private $status;

    /**
     * Instantiate a new Variable
     *
     * @access private
     * @param string $name Name of the variable, if any.
     * @param string $type Variable type (e.g. MyClass).
     * @param array $options {
     *      Variable options
     *
     *      @type string $value Simple value of the variable.
     *      @type int $varTableIndex The index of this variable in the variable
     *            table.
     *      @type Variable[] $members Any public member variables.
     *      @type Status $status Status associated with the variable.
     * }
     */
    public function __construct($name, $type, array $options = [])
    {
        $this->name = $name;
        $this->type = $type;
        $options += [
            'value' => null,
            'varTableIndex' => null,
            'members' => [],
            'status' => null
        ];
        $this->value = $options['value'];
        $this->varTableIndex = $options['varTableIndex'];
        $this->members = $options['members'];
        $this->status = $options['status'];
    }

    /**
     * Load a Variable from JSON form
     *
     * Example:
     * ```
     * $variable = Variable::fromJson([
     *     'name' => 'myVar',
     *     'type' => 'string',
     *     'value' => 'some value'
     * ]);
     * ```
     *
     * @access private
     * @param array $data {
     *      Variable data.
     *
     *      @type string $name Name of the variable, if any.
     *      @type string $value Simple value of the variable.
     *      @type string $type Variable type (e.g. MyClass).
     *      @type int $varTableIndex The index of this variable in the variable
     *            table.
     *      @type array $members Any public member variables.
     *      @type array $status Status associated with the variable.
     * }
     * @return Variable
     */
    public static function fromJson(array $data)
    {
        if (array_key_exists('members', $data)) {
            $data['members'] = array_map([static::class, 'fromJson'], $data['members']);
        }
        if (array_key_exists('status', $data)) {
            $data['status'] = StatusMessage::fromJson($data['status']);
        }
        return new static($data['name'], $data['type'], $data);
    }

    /**
     * Return the approximate size of this object in bytes
     *
     * @return int
     */
    public function byteSize()
    {
        return mb_strlen($this->name) +
                mb_strlen($this->type) +
                mb_strlen($this->value);
    }

    /**
     * Returns the approximate size of this object including all members in bytes
     *
     * @return int
     */
    public function fullByteSize()
    {
        $size = $this->byteSize();
        foreach ($this->members as $variable) {
            $size += $variable->fullByteSize();
        }
        return $size;
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        $data = [
            'name' => $this->name,
            'type' => $this->type
        ];
        if ($this->value !== null) {
            $data['value'] = $this->value;
        }
        if ($this->varTableIndex !== null) {
            $data['varTableIndex'] = $this->varTableIndex;
        }
        if ($this->members) {
            $data['members'] = array_map(function ($v) {
                return $v->info();
            }, $this->members);
        }
        if ($this->status) {
            $data['status'] = $this->status->info();
        }
        return $data;
    }
}
