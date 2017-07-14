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
    private $componentId;
    private $manifestPath;
    private $release;
    private $isComponent;

    /**
     * @param array $files
     */
    public function __construct(
        TypeGenerator $types,
        array $files,
        $outputPath,
        $executionPath,
        $componentId,
        $manifestPath,
        $release,
        $isComponent = true
    ) {
        $this->types = $types;
        $this->files = $files;
        $this->outputPath = $outputPath;
        $this->executionPath = $executionPath;
        $this->componentId = $componentId;
        $this->manifestPath = $manifestPath;
        $this->release = $release;
        $this->isComponent = $isComponent;
    }

    /**
     * Generates JSON documentation from provided files.
     *
     * @return void
     */
    public function generate($basePath, $pretty)
    {
        $fileReflectorRegister = new ReflectorRegister();
        foreach ($this->files as $file) {

            if ($basePath) {
                $currentFileArr = explode($basePath, trim($file, '/'));
                if (isset($currentFileArr[1])) {
                    $currentFile = trim($currentFileArr[1], '/');
                }
            }

            $isPhp = strrpos($file, '.php') == strlen($file) - strlen('.php');

            if ($isPhp) {
                $parser = new CodeParser(
                    $file,
                    $currentFile,
                    $fileReflectorRegister,
                    dirname($this->executionPath),
                    $this->componentId,
                    $this->manifestPath,
                    $this->release,
                    $basePath,
                    $this->isComponent
                );
            } else {
                $content = file_get_contents($file);
                $split = explode('src/', $file);
                $parser = new MarkdownParser($split[1], $content);
            }

            $document = $parser->parse();
            if ($document) {
                $writer = new Writer($document, $this->outputPath, $pretty);
                $writer->write($currentFile);

                $this->types->addType([
                    'id' => $document['id'],
                    'title' => $document['title'],
                    'contents' => ($this->isComponent)
                        ? $this->prune($document['id'] . '.json')
                        : $document['id'] . '.json'
                ]);
            }
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
