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
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $locals = [];

    /**
     * Create a snippet
     *
     * @param string $identifier The snippet ID
     * @param array $config The snippet config
     */
    public function __construct($identifier, array $config = [])
    {
        $this->identifier = $identifier;
        $this->config = $config + [
            'content' => '',
            'fqn' => '',
            'index' => 0,
            'file' => '',
            'line' => 0,
            'name' => null
        ];
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
        return $this->config['file'];
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
        return $this->config['line'];
    }

    /**
     * The snippet content.
     *
     * @return string
     */
    public function content()
    {
        return $this->config['content'];
    }

    /**
     * The Snippet Index
     *
     * @return int
     */
    public function index()
    {
        return $this->config['index'];
    }

    /**
     * The snippet name
     *
     * @return string
     */
    public function name()
    {
        return $this->config['name'];
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
            $res = eval($this->config['content'] ."\n\n". $return);
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
        return $this->config;
    }
}
