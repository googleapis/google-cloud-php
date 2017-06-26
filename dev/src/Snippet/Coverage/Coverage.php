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

class Coverage
{
    private static $snippetExcludeList = [
        '/\\\Google\\\Cloud\\\Core\\\PhpArray/',
    ];

    /**
     * @var ScannerInterface
     */
    protected $scanner;

    /**
     * @var \Google\Cloud\Dev\Snippet\Parser\Snippet[]
     */
    private $snippets = [];

    /**
     * @var string[]
     */
    private $covered = [];

    /**
     * @param ScannerInterface $scanner The scanner to use
     */
    public function __construct(ScannerInterface $scanner)
    {
        $this->scanner = $scanner;
    }

    private function getSnippetExcludeList()
    {
        return static::$snippetExcludeList;
    }

    /**
     * Creates a list of all snippets which should be covered.
     *
     * @return \Google\Cloud\Dev\Snippet\Parser\Snippet[]
     */
    public function buildListToCover()
    {
        $files = $this->scanner->files();
        $classes = $this->scanner->classes($files, $this->getSnippetExcludeList());

        $this->snippets = $this->scanner->snippets($classes);

        return $this->snippets;
    }

    /**
     * Mark a snippet as covered.
     *
     * @param string $identifier The identifier of the snippet being covered.
     * @return void
     */
    public function cover($identifier)
    {
        $this->covered[] = $identifier;
    }

    /**
     * Return a list of all snippets not marked a covered.
     *
     * @return \Google\Cloud\Dev\Snippet\Parser\Snippet[]
     */
    public function uncovered()
    {
        return array_diff_key($this->snippets, array_flip($this->covered));
    }

    public function cache($identifier)
    {
        return (array_key_exists($identifier, $this->snippets))
            ? $this->snippets[$identifier]
            : null;
    }
}
