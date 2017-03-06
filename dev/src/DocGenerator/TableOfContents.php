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

namespace Google\Cloud\Dev\DocGenerator;

class TableOfContents
{
    private $template;
    private $component;
    private $componentVersion;
    private $outputPath;

    public function __construct(array $template, array $component, $componentVersion, $outputPath)
    {
        $this->template = $template;
        $this->component = $component;
        $this->componentVersion = $componentVersion;
        $this->outputPath = $outputPath;
    }

    public function generate()
    {
        $toc = $this->template;
        $toc['services'] = $this->component;
        $toc['tagName'] = $this->componentVersion;

        $writer = new Writer(json_encode($toc), $this->outputPath);
        $writer->write('toc.json');
    }
}
