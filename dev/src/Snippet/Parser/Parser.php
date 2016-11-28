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

use DomDocument;
use Parsedown;
use ReflectionClass;
use ReflectionMethod;
use phpDocumentor\Reflection\DocBlock;

/**
 * A class for parsing code snippets from a class and its methods.
 *
 * Example:
 * ```
 * $parser = new Parser;
 * ```
 */
class Parser
{
    /**
     * Get a snippet from a class.
     *
     * Example:
     * ```
     * $snippet = $parser->classExample(Parser::class);
     * ```
     *
     * @param string $class the name of the class
     * @param int $index The 0-indexed example to return.
     * @return Snippet
     * @throws Exception
     */
    public function classExample($class, $index = 0)
    {
        $class = new ReflectionClass($class);
        $examples = $this->examplesFromClass($class);

        $result = array_filter($examples, function ($example) use ($index) {
            return ($example->index() == $index);
        });

        if (empty($result)) {
            throw new \Exception(sprintf(
                'Given snippet index %d does not exist for class %s',
                $index,
                $class->getName()
            ));
        }

        return current($result);
    }

    /**
     * Get a snippet from a method.
     *
     * Example:
     * ```
     * $snippet = $parser->methodExample(Parser::class, 'methodExample');
     * ```
     *
     * ```
     * // Get the 2nd example (index=1)
     * $snippet = $parser->methodExample(Parser::class, 'methodExample', 1);
     * ```
     *
     * @param string $class The name of the class.
     * @param string $method The name of the method.
     * @param int $index The 0-indexed example to return.
     * @return Snippet
     * @throws Exception
     */
    public function methodExample($class, $method, $index = 0)
    {
        $examples = $this->examplesFromMethod($class, $method);

        $result = array_filter($examples, function ($example) use ($index) {
            return ($example->index() === $index);
        });

        if (empty($result)) {
            throw new \Exception(sprintf(
                'Given snippet index %d does not exist for method %s::%s',
                $index,
                $class,
                $method
            ));
        }

        return current($result);
    }

    /**
     * Retrieve all examples from a class Doc Block.
     *
     * Example:
     * ```
     * $examples = $parser->examplesFromClass($parser);
     * ```
     *
     * @param object|ReflectionClass $class An instance or reflector of the
     *        class to parse examples from.
     * @return array
     */
    public function examplesFromClass($class)
    {
        if (!($class instanceof ReflectionClass)) {
            $class = new ReflectionClass($class);
        }

        $doc = new DocBlock($class);

        return $this->examples(
            $doc,
            $class->getName(),
            $class->getFileName(),
            $class->getStartLine()
        );
    }

    /**
     * Retrieve all examples from a method's Doc Block.
     *
     * Example:
     * ```
     * $examples = $parser->examplesFromMethod($parser, 'examplesFromMethod');
     * ```
     *
     * @param object $class An instance of the class to parse examples from.
     * @param string|ReflectionMethod $method The name of the method to parse
     *        examples from.
     * @return array
     */
    public function examplesFromMethod($class, $method)
    {
        if (!($method instanceof ReflectionMethod)) {
            $method = new ReflectionMethod($class, $method);
        }

        $doc = new DocBlock($method);

        $parent = $method->getDeclaringClass();
        $class = $parent->getName();

        return $this->examples(
            $doc,
            $class .'::'. $method->getName(),
            $method->getFileName(),
            $method->getStartLine()
        );
    }

    /**
     * Retrieve all examples from a class and its methods.
     *
     * Example:
     * ```
     * $examples = $parser->allExamples($parser);
     * ```
     *
     * @param object|ReflectionClass An instance or reflector of the class to
     *        parse.
     * @return array
     */
    public function allExamples($class)
    {
        if (!($class instanceof ReflectionClass)) {
            $class = new ReflectionClass($class);
        }

        $snippets = $this->examplesFromClass($class);

        $methods = $class->getMethods();
        foreach ($methods as $method) {
            $snippets = array_merge($snippets, $this->examplesFromMethod($class, $method));
        }

        return $snippets;
    }

    /**
     * Parse examples from a DocBlock object.
     *
     * Example:
     * ```
     * // Yeah, this example is pretty useless.
     * $examples = $parser->examples($docBlock);
     * ```
     *
     * @param DocBlock $docBlock The DocBlock to parse
     * @param string $file The filename the docblock is in
     * @param int $line The line where the tested method or class is declared.
     * @return array
     */
    public function examples(DocBlock $docBlock, $fullyQualifiedName, $file, $line)
    {
        $text = $docBlock->getText();

        $parts = explode('Example:', $text);

        if (strpos($text, 'Example:') === false) {
            return [];
        }

        $converter = new Parsedown;
        $document = new DOMDocument;

        $parsedText = $converter->text($parts[1]);
        $document->loadHTML($parsedText);

        $examples = $document->getElementsByTagName('code');

        $index = 0;
        $res = [];
        foreach ($examples as $example) {
            $identifier = $this->createIdentifier($fullyQualifiedName, $index);
            $snippet = new Snippet($identifier, [
                'content' => $example->textContent,
                'fqn' => $fullyQualifiedName,
                'index' => $index,
                'file' => $file,
                'line' => $line
            ]);

            $res[$identifier] = $snippet;
            $index++;
        }

        return $res;
    }

    public function createIdentifier($name, $index)
    {
        return sha1($name . $index);
    }
}
