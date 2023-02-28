<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\DocGenerator;

use Google\Cloud\Dev\DocGenerator\File;
use Google\Cloud\Dev\DocGenerator\Writer;

class TypeGenerator
{
    private $types = [];

    private $outputPath;

    public function __construct($outputPath)
    {
        $this->outputPath = $outputPath;
    }

    public function addType(array $type)
    {
        $this->types[] = $type;
    }

    public function write($pretty = false)
    {
        $writer = new Writer($this->types, $this->outputPath, $pretty);
        $writer->write('types.json');
    }
}
