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

use Google\Cloud\Dev\DocGenerator\Parser\CodeParser;
use Google\Cloud\Dev\DocGenerator\Parser\MarkdownParser;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\FileReflector;

/**
 * Parses given files and builds documentation for our common docs site.
 */
class DocGenerator
{
    private $types;
    private $files;
    private $outputPath;
    private $executionPath;

    /**
     * @param array $files
     */
    public function __construct(TypeGenerator $types, array $files, $outputPath, $executionPath)
    {
        $this->types = $types;
        $this->files = $files;
        $this->outputPath = $outputPath;
        $this->executionPath = $executionPath;
    }

    /**
     * Generates JSON documentation from provided files.
     *
     * @return void
     */
    public function generate($basePath)
    {
        foreach ($this->files as $file) {

            if ($basePath) {
                $currentFileArr = explode($basePath, trim($file, '/'));
                if (isset($currentFileArr[1])) {
                    $currentFile = trim($currentFileArr[1], '/');
                }
            }

            $isPhp = strrpos($file, '.php') == strlen($file) - strlen('.php');

            if ($isPhp) {
                $fileReflector = new FileReflector($file);
                $parser = new CodeParser($file, $currentFile, $fileReflector);
            } else {
                $content = file_get_contents($file);
                $parser = new MarkdownParser($currentFile, $content);
            }

            $document = $parser->parse();

            $writer = new Writer(json_encode($document), $this->outputPath);
            $writer->write($currentFile);

            $this->types->addType([
                'id' => $document['id'],
                'title' => $document['title'],
                'contents' => $this->prune($document['id'] . '.json')
            ]);
        }
    }

    private function prune($contentsFileName)
    {
        $explode = explode('/', $contentsFileName);
        if (count($explode) > 1) {
            array_shift($explode);
        }

        return implode('/', $explode);
    }
}
