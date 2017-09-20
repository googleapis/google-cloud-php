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
 * Represents a location in the source code.
 */
class SourceLocation implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $line;

    /**
     * Instantiate a new SourceLocation
     *
     * @param [type] $data [description]
     */
    public function __construct(array $data = [])
    {
        $data = $data ?: [];
        $this->path = $this->pluck('path', $data, false);
        $this->line = $this->pluck('line', $data, false);
    }

    /**
     * Returns the path to the source file.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Returns the line inside the file.
     *
     * @return int
     */
    public function line()
    {
        return $this->line;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'path' => $this->path,
            'line' => $this->line
        ];
    }
}
