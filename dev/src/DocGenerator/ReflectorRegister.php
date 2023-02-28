<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

use phpDocumentor\Reflection\Php\File;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Element;
use phpDocumentor\Reflection\File\LocalFile;
use phpDocumentor\Reflection\Php\Project;
use phpDocumentor\Reflection\Php\ProjectFactory;
use phpDocumentor\Reflection\Php\Interface_;
use phpDocumentor\Reflection\Php\Trait_;

class ReflectorRegister
{
    private $elementMap;
    private $fileMap;
    private $skippedFqsen = [];

    public function __construct(Project $project)
    {
        $this->writeProjectToCache($project);
    }

    public function getElementFromFqsen(Fqsen $elementFqsen): ?Element
    {
        $fqsen = (string) $elementFqsen;
        if (isset($this->elementMap[$fqsen])) {
            return $this->elementMap[$fqsen];
        }

        if ($this->writeFqsenToCache($fqsen)) {
            return $this->elementMap[$fqsen];
        }

        return null;
    }

    public function getFileFromFqsen(Fqsen $elementFqsen): File
    {
        $fqsen = (string) $elementFqsen;
        if (false !== strpos($fqsen, '::')) {
            $fqsen = explode('::', $fqsen)[0];
        }
        if (isset($this->fileMap[$fqsen])) {
            return $this->fileMap[$fqsen];
        }

        if ($this->writeFqsenToCache($fqsen)) {
            return $this->fileMap[$fqsen];
        }

        throw new \LogicException('File not found for Fqsen ' . $fqsen);
    }

    public function getSkipped()
    {
        return array_values($this->skippedFqsen);
    }

    /**
     * @param FileReflector $fileReflector
     * @return File|Trait_|Interface_|null
     */
    public function getElementFromFile(File $file): ?Element
    {
        if (is_null($file)) {
            throw new \LogicException('null file reflector');
        }

        $classes = $file->getClasses();
        if (count($classes) > 0) {
            return array_shift($classes);
        }

        $interfaces = $file->getInterfaces();
        if (count($interfaces) > 0) {
            return array_shift($interfaces);
        }

        $traits = $file->getTraits();
        if (count($traits) > 0) {
            return array_shift($traits);
        }

        // No classes, interfaces, or traits found in file
        return null;
    }

    public function getContextFromFqsen(Fqsen $fqsen): ?Context
    {
        $file = $this->getFileFromFqsen($fqsen);
        $fileElement = $this->getElementFromFile($file);

        return $fileElement->getDocBlock()->getContext();
    }

    private function writeFqsenToCache(string $fqsen): bool
    {
        if (!class_exists($fqsen) && !interface_exists($fqsen) && !trait_exists($fqsen)) {
            // echo "Could not find class, trait or interface for $fqsen\n";
            return false;
        }

        $refClass = new \ReflectionClass($fqsen);
        $fileName = $refClass->getFileName();

        if (empty($fileName)) {
            // echo "Could not find file for $fqsen\n";
            return false;
        }

        if (!file_exists($fileName)) {
            // echo "File $fileName does not exist\n";
            return false;
        }

        $project = ProjectFactory::createInstance()->create('', [
            new LocalFile($fileName)
        ]);

        $this->writeProjectToCache($project);

        if (!isset($this->fileMap[$fqsen])) {
            throw new \LogicException("$fqsen not found in $fileName. Possibly an alias.");
        }

        return true;
    }

    private function writeProjectToCache(Project $project): void
    {
        foreach ($project->getFiles() as $path => $file) {
            foreach ($file->getClasses() as $fqsen => $class) {
                $this->elementMap[$fqsen] = $class;
                $this->fileMap[$fqsen] = $file;
            }
            foreach ($file->getInterfaces() as $fqsen => $interface) {
                $this->elementMap[$fqsen] = $interface;
                $this->fileMap[$fqsen] = $file;
            }
            foreach ($file->getTraits() as $fqsen => $trait) {
                $this->elementMap[$fqsen] = $trait;
                $this->fileMap[$fqsen] = $file;
            }
        }
    }
}
