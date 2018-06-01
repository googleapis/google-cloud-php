<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Dev\AddComponent;

/**
 * Create .gitattributes file.
 */
class GitAttributes
{
    const ATTRIBUTES_TPL = 'template-gitattributes.txt';

    /**
     * @var string
     */
    private $cliBasePath;

    /**
     * @var string
     */
    private $path;


    public function __construct($cliBasePath, $path)
    {
        $this->cliBasePath = $cliBasePath;
        $this->path = $path;
    }

    public function run()
    {
        $source = $this->cliBasePath . '/src/AddComponent/templates/' . self::ATTRIBUTES_TPL;
        $dest = $this->path .'/.gitattributes';

        copy($source, $dest);
    }
}
