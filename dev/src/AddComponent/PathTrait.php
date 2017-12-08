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
 * Methods for dealing with paths and directories.
 */
trait PathTrait
{
    private $GAPIC_PATH_REGEX = '/[vV]\d{0,}/';

    private function pathIsGapic($path)
    {
        $parts = explode('/', $path);
        $last = array_pop($parts);
        return preg_match($this->GAPIC_PATH_REGEX, $last) === 1;
    }

    private function scanDirectory($path, array $excludes = [])
    {
        $excludes = ['..', '.', '.DS_Store', 'VERSION', 'LICENSE', 'CONTRIBUTING.md'] + $excludes;
        return array_diff(scandir($path), $excludes);
    }
}
