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
 * Represents a location in the source code.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\SourceLocation;
 *
 * $location = new SourceLocation('/path/to/file.php', 10);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#sourcelocation SourceLocation model documentation
 * @codingStandardsIgnoreEnd
 */
class SourceLocation implements \JsonSerializable
{
    /**
     * @var string Path to the source file within the source context of the
     *      target binary.
     */
    private $path;

    /**
     * @var int Line inside the file. The first line in the file has the value 1.
     */
    private $line;

    /**
     * Instantiate a new SourceLocation
     *
     * @access private
     * @param string $path Path to the source file within the source context
     *        of the target binary.
     * @param int $line Line inside the file. The first line in the file has
     *        the value 1.
     */
    public function __construct($path, $line)
    {
        $this->path = $path;
        $this->line = $line;
    }

    /**
     * Load a SourceLocation from JSON form
     *
     * Example:
     * ```
     * $location = SourceLocation::fromJSON([
     *     'path' => '/path/to/file.php',
     *     'line' => 10
     * ]);
     * ```
     *
     * @access private
     * @param array $data {
     *      SourceLocation data
     *
     *      @type string $path Path to the source file within the source context
     *            of the target binary.
     *      @type int $line Line inside the file. The first line in the file has
     *            the value 1.
     * }
     */
    public static function fromJson(array $data)
    {
        $data += [
            'path' => null,
            'line' => null
        ];
        return new static($data['path'], $data['line']);
    }

    /**
     * Returns the path to the source file.
     *
     * Example:
     * ```
     * echo $location->path();
     * ```
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
     * Example:
     * ```
     * echo $location->line();
     * ```
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
     * @access private
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
