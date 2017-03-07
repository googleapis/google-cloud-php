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

class Writer
{
    private $content;
    private $outputPath;
    private $pretty;

    public function __construct(array $content, $outputPath, $pretty = false)
    {
        $this->content = $content;
        $this->outputPath = $outputPath;
        $this->pretty = (bool) $pretty;
    }

    public function write($currentFile)
    {
        $path = $this->buildOutputPath($currentFile);

        if (!is_dir(dirname($path))) {
            @mkdir(dirname($path), 0777, true);
        }

        $content = ($this->pretty)
            ? json_encode($this->content, JSON_PRETTY_PRINT)
            : json_encode($this->content);

        file_put_contents($path, $content);
    }

    private function buildOutputPath($currentFile)
    {
        $pathInfo = pathinfo($currentFile);
        $servicePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.json';

        if (strpos($servicePath, '/') !== 0) {
            $servicePath = '/' . $servicePath;
        }

        $servicePath = strtolower($servicePath);

        return $this->outputPath . $servicePath;
    }
}
