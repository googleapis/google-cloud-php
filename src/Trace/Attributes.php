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

namespace Google\Cloud\Trace;

use Google\Cloud\Core\ArrayTrait;

/**
 * This plain PHP class represents a Link resource. A set of attributes, each in
 * the format [KEY]:[VALUE].
 *
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/Attributes
 */
class Attributes implements \JsonSerializable, \ArrayAccess
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * Callback for \ArrayAccess []= setter.
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Callback for \ArrayAccess isset.
     *
     * @param string $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Callback for \ArrayAccess unset.
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Callback for \ArrayAccess [$key] getter.
     *
     * @param string $offset
     */
    public function offsetGet($offset)
    {
        return isset($this->attributes[$offset])
            ? $this->attributes[$offset]
            : null;
    }

    /**
     * Returns a serializable array representing this Link.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [];
        foreach ($this->attributes as $key => $value) {
            switch (gettype($value)) {
                case 'boolean':
                    $data[$key] = [
                        'boolValue' => $value
                    ];
                    break;
                case 'integer':
                    $data[$key] = [
                        'intValue' => $value
                    ];
                    break;
                default:
                    $data[$key] = [
                        'stringValue' => ['value' => (string) $value]
                    ];
            }
        }
        return [
            'attributeMap' => $data
        ];
    }
}
