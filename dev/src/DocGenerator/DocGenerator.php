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

use Google\Cloud\Core\Testing\Reflection\ReflectionHandlerV4;
use Google\Cloud\Dev\DocGenerator\Parser\CodeParser;
use Google\Cloud\Dev\DocGenerator\Parser\MarkdownParser;
use phpDocumentor\Reflection\File\LocalFile;
use Symfony\Component\Console\Output\OutputInterface;

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
    private $output;
    private $isComponent;

    /**
     * @param TypeGenerator $types
     * @param array $files
     * @param string $outputPath
     * @param string $executionPath
     * @param string $componentId
     * @param string $manifestPath
     * @param string $release
     * @param OutputInterface $output
     * @param bool $isComponent
     */
    public function __construct(
        TypeGenerator $types,
        array $files,
        $outputPath,
        $executionPath,
        $componentId,
        $manifestPath,
        $release,
        OutputInterface $output,
        $isComponent = true
    ) {
        $this->types = $types;
        $this->files = $files;
        $this->outputPath = $outputPath;
        $this->executionPath = $executionPath;
        $this->componentId = $componentId;
        $this->manifestPath = $manifestPath;
        $this->release = $release;
        $this->output = $output;
        $this->isComponent = $isComponent;
    }

    /**
     * Generates JSON documentation from provided files.
     *
     * @return void
     */
    public function generate($basePath, $pretty)
    {
        $localFiles = [];
        foreach ($this->files as $fileName) {
            $localFiles[] = new LocalFile($fileName);
        }
        $reflection = new ReflectionHandlerV4();
        $projectFactory = $reflection->createProjectFactory();
        $descriptionFactory = $reflection->createDescriptionFactory();
        $project = $projectFactory->create($this->componentId, $localFiles);
        $fileRegister = new ReflectorRegister($project);

        $rootPath = $this->executionPath;
        foreach ($project->getFiles() as $file) {
            $filePath = $file->getPath();
            $currentFileArr = $this->isComponent
                ? explode("/$basePath/", $filePath, 2)
                : explode("$rootPath", $filePath, 2);

            if (isset($currentFileArr[1])) {
                $currentFile = str_replace('src/', '', $currentFileArr[1]);
            } else {
                throw new \Exception(
                    sprintf('Failed to determine currentFile: %s', $filePath)
                );
            }

            $isPhp = strrpos($filePath, '.php') == strlen($filePath) - strlen('.php');
            $pathInfo = pathinfo($currentFile);
            $servicePath = $pathInfo['dirname'] === '.'
                ? strtolower($pathInfo['filename'])
                : strtolower($pathInfo['dirname'] . '/' . $pathInfo['filename']);
            $id = $this->isComponent
                ? strtolower($basePath) . '/' . $servicePath
                : $servicePath;

            if ($isPhp) {
                $parser = new CodeParser(
                    $file,
                    $fileRegister,
                    $descriptionFactory,
                    $rootPath,
                    $this->componentId,
                    $this->manifestPath,
                    $this->release,
                    $this->output,
                    $id,
                    $this->isComponent
                );
            } else {
                $content = file_get_contents($filePath);
                $parser = new MarkdownParser($currentFile, $content, $id);
            }

            $document = $parser->parse();
            if ($document) {
                $writer = new Writer($document, $this->outputPath, $pretty);
                $writer->write($currentFile);

                $this->types->addType([
                    'id' => $id,
                    'title' => $document['title'],
                    'contents' => $servicePath . '.json'
                ]);
            }
        }
    }
}
