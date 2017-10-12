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
 * Represents a variable or an argument possibly of a compound object type.
 */
class Variable implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var array
     */
    private $info;

    /**
     * Instantiate a new Variable
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->info = $this->pluckArray([
            'name',
            'value',
            'type',
            'varTableIndex'
        ], $data);

        if (array_key_exists('members', $data)) {
            $this->info['members'] = array_map(function ($member) {
                return ($member instanceof static)
                    ? $member
                    : new static ($member);
            }, $data['members']);
        }

        if (array_key_exists('status', $data)) {
            $this->info['status'] = new StatusMessage($data['status']);
        }
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->info;
    }
}
