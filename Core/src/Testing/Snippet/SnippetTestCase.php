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

namespace Google\Cloud\Core\Testing\Snippet;

use Google\Cloud\Core\Testing\CheckForClassTrait;
use Google\Cloud\Core\Testing\Snippet\Container;
use Google\Cloud\Core\Testing\Snippet\Parser\Snippet;
use PHPUnit\Framework\TestCase;

/**
 * Provide helpers for Snippet tests.
 *
 * Snippet test cases should extend this class.
 *
 * @experimental
 * @internal
 */
class SnippetTestCase extends TestCase
{
    const PROJECT = 'my-awesome-project';

    use CheckForClassTrait;

    private static $coverage;
    private static $parser;

    /**
     * Run to set up class before testing
     *
     * @experimental
     * @internal
     */
    public static function setUpBeforeClass(): void
    {
        self::$coverage = Container::$coverage;
        self::$parser = Container::$parser;
    }

    /**
     * Retrieve a snippet from a class-level docblock.
     *
     * @param string $class The class name.
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     *
     * @experimental
     * @internal
     */
    public static function snippetFromClass($class, $indexOrName = 0)
    {
        $identifier = self::$parser->createIdentifier($class, $indexOrName);

        $snippet = self::$coverage->cache($identifier);
        if (!$snippet) {
            $snippet = self::$parser->classExample($class, $indexOrName);
        }

        self::$coverage->cover($snippet->identifier());

        return clone $snippet;
    }

    /**
     * Retrieve a snippet from a magic method docblock (i.e. `@method` tag
     * nexted inside a class-level docblock).
     *
     * @param string $class The class name
     * @param string $method The method name
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     *
     * @experimental
     * @internal
     */
    public static function snippetFromMagicMethod($class, $method, $indexOrName = 0)
    {
        $name = $class .'::'. $method;
        $identifier = self::$parser->createIdentifier($name, $indexOrName);

        $snippet = self::$coverage->cache($identifier);
        if (!$snippet) {
            throw new \Exception('Magic Method '. $name .' was not found');
        }

        self::$coverage->cover($identifier);

        return clone $snippet;
    }

    /**
     * Retrieve a snippet from a method docblock.
     *
     * @param string $class The class name
     * @param string $method The method name
     * @param string|int $indexOrName The index of the snippet, or its name.
     * @return Snippet
     *
     * @experimental
     * @internal
     */
    public static function snippetFromMethod($class, $method, $indexOrName = 0)
    {
        $name = $class .'::'. $method;
        $identifier = self::$parser->createIdentifier($name, $indexOrName);

        $snippet = self::$coverage->cache($identifier);
        if (!$snippet) {
            $snippet = self::$parser->methodExample($class, $method, $indexOrName);
        }

        self::$coverage->cover($identifier);

        return clone $snippet;
    }

    /**
     * Retrieve a snippet from a markdown file.
     *
     * @param string $fileName The path to the file
     * @param string $header The markdown header the snippet is under
     * @param int $index The index of the snippet
     * @return Snippet
     *
     * @experimental
     * @internal
     */
    public static function snippetFromMarkdown(string $fileName, string $header = '', int $index = 0)
    {
        // Normalize line endings to \n to make regex handling consistent across platforms
        $markdown = str_replace(
            ["\r\n", "\r"],
            "\n",
            file_get_contents($fileName)
        );

        // select by header
        if ($header) {
            $pattern = '/^#+\s*' . preg_quote($header, '/') . '\s*\n([\s\S]*?)(?=^#+.*$|\Z)/m';
            if (!preg_match($pattern, $markdown, $matches)) {
                throw new \Exception('Heeader "' . $header . '" not found in markdown file ' . basename($fileName));
            }
            $markdown = trim($matches[1]);
        }

        /**
         * Regex Explanation:
         * * (?m)        : Enable multi-line mode (^ matches start of line).
         * ^             : Start of a line.
         * (\s*)         : Group 1: Capture indentation.
         * (`{3,}|~{3,}) : Group 2: Capture the fence (3+ backticks or tildes).
         * [ \t]* : Consume optional spaces.
         * (.*?)         : Group 3: Capture the language (and/or extra info) non-greedily.
         * \n            : End of the opening line.
         * ([\s\S]*?)    : Group 4: Content (non-greedy).
         * \n            : Newline before closing fence.
         * \1            : Match exact indentation from Group 1.
         * \2            : Match exact fence from Group 2.
         * \s* : Consume any trailing whitespace/newlines on the closing line.
         */
        $pattern = '/^(?m)(\s*)(`{3,}|~{3,})[ \t]*(.*?)\n([\s\S]*?)\1\2\s*$/m';
        $snippets = [];
        if (!preg_match_all($pattern, $markdown, $matches, PREG_SET_ORDER)) {
            throw new \Exception('No snippets found in markdown file ' . basename($fileName));
        }
        foreach ($matches as $i => $match) {
            // Group 3 is the language info string. Trim it to remove extra spaces.
            $language = isset($match[3]) ? trim($match[3]) : '';

            // Fallback to 'text' if empty
            if ($language === '') {
                $language = 'text';
            }

            // Group 4 is the actual code content
            $code = $match[4];

            $snippets[] = new Snippet($fileName . '-' . $i, [
                'content' => $code,
                'file' => $fileName,
                'index' => $i,
                'name' => strtolower($language),
            ]);
        }

        if (!isset($snippets[$index])) {
            throw new \Exception('No snippet found in markdown file ' . basename($fileName) . ' at index ' . $index);
        }

        return clone $snippets[$index];
    }
}
