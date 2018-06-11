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

        $rootPath = $this->executionPath;
        foreach ($this->files as $file) {
            $currentFileArr = $this->isComponent
                ? explode("/$basePath/", $file)
                : explode("$rootPath", $file);

            if (isset($currentFileArr[1])) {
                $currentFile = str_replace('src/', '', $currentFileArr[1]);
            } else {
                throw new \Exception(
                    sprintf('Failed to determine currentFile: %s', $file)
                );
            }

            $isPhp = strrpos($file, '.php') == strlen($file) - strlen('.php');

            if ($isPhp) {
                $parser = new CodeParser(
                    $file,
                    $fileReflectorRegister,
                    $rootPath,
                    $this->componentId,
                    $this->manifestPath,
                    $this->release,
                    $this->isComponent
                );
            } else {
                $content = file_get_contents($file);
                $parser = new MarkdownParser($currentFile, $content);
            }

            $document = $parser->parse();
            if ($document) {
                $writer = new Writer($document, $this->outputPath, $pretty);
                $writer->write($currentFile);
                $pathInfo = pathinfo($currentFile);
                $servicePath = $pathInfo['dirname'] === '.'
                    ? strtolower($pathInfo['filename'])
                    : strtolower($pathInfo['dirname'] . '/' . $pathInfo['filename']);
                $id = $this->isComponent
                    ? strtolower($basePath) . '/' . $servicePath
                    : $servicePath;

                $this->types->addType([
                    'id' => $id,
                    'title' => $document['title'],
                    'contents' => $servicePath . '.json'
                ]);
            }
        }
    }
}
