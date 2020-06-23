<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Dev\ApiComparator;

/**
 * A collection class for the backwards compatibility test of a file.
 */
class FileResult
{
    private $name;
    private $results = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setResults(array $result)
    {
        $this->results = $result;
    }

    public function passed()
    {
        return !(bool) $this->results;
    }

    public function toString()
    {
        if (empty($this->results)) {
            return '';
        }

        $out = $this->name . PHP_EOL . "--------------------" . PHP_EOL;

        $out .= count($this->results) . " backwards-incompatible change(s) found!" . PHP_EOL . PHP_EOL;
        foreach ($this->results as $result) {
            $out .= $result . PHP_EOL;
        }

        return $out;
    }
}
