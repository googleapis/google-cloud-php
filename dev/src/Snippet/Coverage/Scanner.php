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

namespace Google\Cloud\Dev\Snippet\Coverage;

use Google\Cloud\Dev\Snippet\Parser\Parser;
use phpDocumentor\Reflection\FileReflector;

/**
 * Scan a directory for files, a set of files for classes, and a set of classes
 * for code snippets.
 */
class Scanner implements ScannerInterface
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param Parser $parser An instance of the Snippet Parser.
     * @param string $basepath The path to scan for PHP files.
     */
    public function __construct(Parser $parser, $basePath)
    {
        $this->parser = $parser;
        $this->basePath = $basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function files()
    {
        $regexIterator = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->basePath)
            ),
            '/^.+\.php$/i',
            \RecursiveRegexIterator::GET_MATCH
        );

        $files = [];
        foreach ($regexIterator as $item) {
            array_push($files, $item[0]);
        }

        return $files;
    }

    private function checkExclude($className, array $exclude)
    {
        foreach ($exclude as $pattern) {
            if (preg_match($pattern, $className)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function classes(array $files, array $exclude = [])
    {
        $classes = [];
        foreach ($files as $file) {
            $f = new FileReflector($file);
            $f->process();
            foreach ($f->getClasses() as $class) {
                if ($this->checkExclude($class->getName(), $exclude)) {
                    continue;
                }
                $classes[] = $class->getName();
            }
        }
        return $classes;
    }

    /**
     * {@inheritDoc}
     */
    public function snippets(array $classes)
    {
        $snippets = [];
        foreach ($classes as $class) {
            $snippets = array_merge(
                $snippets,
                $this->parser->allExamples(new \ReflectionClass($class))
            );
        }

        return $snippets;
    }
}
