<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\Snippet\Parser;

/**
 * Represents a single code snippet
 */
class Snippet implements \JsonSerializable
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $file;

    /**
     * @var int
     */
    private $line;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $index;

    /**
     * @var array
     */
    private $locals = [];

    /**
     * Create a snippet
     *
     * @param string $file The filename
     * @param int $line The line number
     * @param string $content The snippet
     * @param int $index Represents the 0-indexed location of the snippet in a
     *        docblock.
     */
    public function __construct($file, $line, $content, $index = 0)
    {
        $this->identifier = sha1($file . $line . $content . $index);
        $this->file = $file;
        $this->line = $line;
        $this->content = $content;
        $this->index = $index;
    }

    /**
     * A unique identifier for the snippet.
     *
     * This identifier is deterministic and will remain constant unless the
     * snippet is modified or moved.
     *
     * @return string
     */
    public function identifier()
    {
        return $this->identifier;
    }

    /**
     * The file in which the snippet is found.
     *
     * @return string
     */
    public function file()
    {
        return $this->file;
    }

    /**
     * The line number where the snippet's method or class is declared.
     *
     * Note that this is NOT the line number where the snippet is declared. It
     * indicates the method or class which the snippet annotates.
     *
     * @return int
     */
    public function line()
    {
        return $this->line;
    }

    /**
     * The snippet content.
     *
     * @return string
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * The Snippet Index
     *
     * @return int
     */
    public function index()
    {
        return $this->index;
    }

    /**
     * Eval the snippet and return the result.
     *
     * @return mixed
     */
    public function invoke($returnVar = null)
    {
        $return = ($returnVar)
            ? sprintf('return $%s;', $returnVar)
            : '';

        $cb = function($return) {
            extract($this->locals);

            ob_start();
            $res = eval($this->content ."\n\n". $return);
            $out = ob_get_clean();

            return new InvokeResult($res, $out);
        };

        return $cb($return);
    }

    /**
     * Add a local variable to make available in the snippet execution scope.
     *
     * @param string $name The variable name
     * @param mixed $value The variable value
     * @return void
     */
    public function addLocal($name, $value)
    {
        $this->locals[$name] = $value;
    }

    public function jsonSerialize()
    {
        return [
            'file' => $this->file,
            'line' => $this->line,
            'index' => $this->index,
            'content' => $this->content,
        ];
    }
}
