<?php
/**
 * Copyright 2018 Google Inc.
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
 * Create pull request template file.
 */
class PullRequestTemplate
{
    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var string
     */
    private $path;


    public function __construct($rootPath, $path)
    {
        $this->rootPath = $rootPath;
        $this->path = $path;
    }

    public function run()
    {
        $source = $this->rootPath . '/dev/src/AddComponent/templates/template-pull_request_template.md.txt';
        $dir = $this->path .'/.github';
        $dest = $dir . '/pull_request_template.md';
        @mkdir($dir);

        $pathParts = explode('/', $this->path);
        $template = file_get_contents($source);
        $template = str_replace('{clientBase}', array_pop($pathParts), $template);

        file_put_contents($dest, $template);
    }
}
