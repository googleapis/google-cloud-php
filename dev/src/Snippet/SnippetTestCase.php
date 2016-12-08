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

namespace Google\Cloud\Dev\Snippet;

use Google\Cloud\Dev\Snippet\Container;

/**
 * Provide helpers for Snippet tests.
 *
 * Snippet test cases should extend this class.
 */
class SnippetTestCase extends \PHPUnit_Framework_TestCase
{
    const HOOK_BEFORE = 1000;
    const HOOK_AFTER = 1001;

    private $coverage;
    private $parser;

    public function __construct()
    {
        parent::__construct();

        $this->coverage = Container::$coverage;
        $this->parser = Container::$parser;
    }

    /**
     * Retrieve a snippet from a class-level docblock.
     *
     * @param string $class The class name.
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     */
    public function snippetFromClass($class, $indexOrName = 0)
    {
        $identifier = $this->parser->createIdentifier($class, $indexOrName);

        $snippet = $this->coverage->cache($identifier);
        if (!$snippet) {
            $snippet = $this->parser->classExample($class, $indexOrName);
        }

        $this->coverage->cover($snippet->identifier());

        return $snippet;
    }

    /**
     * Retrieve a snippet from a magic method docblock (i.e. `@method` tag
     * nexted inside a class-level docblock).
     *
     * @param string $class The class name
     * @param string $method The method name
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     */
    public function snippetFromMagicMethod($class, $method, $indexOrName = 0)
    {
        $name = $class .'::'. $method;
        $identifier = $this->parser->createIdentifier($name, $indexOrName);

        $snippet = $this->coverage->cache($identifier);
        if (!$snippet) {
            throw new \Exception('Magic Method '. $name .' was not found');
        }

        $this->coverage->cover($identifier);

        return $snippet;
    }

    /**
     * Retrieve a snippet from a method docblock.
     *
     * @param string $class The class name
     * @param string $method The method name
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     */
    public function snippetFromMethod($class, $method, $indexOrName = 0)
    {
        $name = $class .'::'. $method;
        $identifier = $this->parser->createIdentifier($name, $indexOrName);

        $snippet = $this->coverage->cache($identifier);
        if (!$snippet) {
            $snippet = $this->parser->methodExample($class, $method, $indexOrName);
        }

        $this->coverage->cover($identifier);

        return $snippet;
    }
}
