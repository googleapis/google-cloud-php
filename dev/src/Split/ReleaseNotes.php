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

namespace Google\Cloud\Dev\Split;

/**
 * Get release notes for a component
 */
class ReleaseNotes
{
    /**
     * @var array
     */
    private $changelog;

    /**
     * @param string $changelog The full release changelog.
     */
    public function __construct($changelog)
    {
        $this->parseChangelog($changelog);
    }

    /**
     * Get release notes for a component.
     *
     * @param string $component The component ID
     * @return string|null
     */
    public function get($component)
    {
        return isset($this->changelog[$component])
            ? $this->changelog[$component]
            : null;
    }

    private function parseChangelog($changelog)
    {
        libxml_use_internal_errors(true);
        $d = new \DOMDocument;
        $d->loadHTML($changelog);
        $details = $d->getElementsByTagName("details");

        foreach ($details as $d) {
            $v = new \DOMDocument;
            $v->loadHTML($d->nodeValue);
            $nodeValue = trim($d->nodeValue);

            $firstLine = explode(PHP_EOL, $nodeValue)[0];
            preg_match('/\S{0,}\/(\S{1,})/', $firstLine, $matches);
            if (count($matches) > 0) {
                $component = $matches[1];
                $this->changelog[$component] = '## ' . $nodeValue;
            }
        }
    }
}
