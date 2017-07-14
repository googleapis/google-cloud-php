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

use Google\Cloud\Dev\DocGenerator\Parser\CodeParser;
use Google\Cloud\Dev\DocGenerator\Parser\MarkdownParser;
use phpDocumentor\Reflection\FileReflector;

class ReflectorRegister
{
    private $reflectors = [];
    private $fileReflectors = [];
    private $nameFileMap = [];

    public function getFileReflector($fileName)
    {
        if (!isset($this->fileReflectors[$fileName])) {
            $this->fileReflectors[$fileName] = new FileReflector($fileName);
            $this->fileReflectors[$fileName]->process();
        }
        return $this->fileReflectors[$fileName];
    }

    public function getReflector($name)
    {
        if (!isset($this->reflectors[$name])) {
            $fileName = $this->getFileForName($name);
            if (empty($fileName)) {
                return null;
            }
            $fileReflector = $this->getFileReflector($fileName);
            $reflector = $this->getReflectorFromFileReflector($fileReflector);
            $this->reflectors[$name] = $reflector;
        }
        return $this->reflectors[$name];
    }

    public function getReflectorFromFileReflector($fileReflector)
    {
        if (isset($fileReflector->getClasses()[0])) {
            return $fileReflector->getClasses()[0];
        }

        if (isset($fileReflector->getInterfaces()[0])) {
            return $fileReflector->getInterfaces()[0];
        }

        if (isset($fileReflector->getTraits()[0])) {
            return $fileReflector->getTraits()[0];
        }

        return null;
    }

    public function getFileForName($name)
    {
        // FIXME: handle nulls correctly
        if (!isset($this->nameFileMap[$name])) {
            if (!(class_exists($name) || interface_exists($name) || trait_exists($name))) {
                echo "Could not find class, trait or interface for $name\n";
                return null;
            }
            $refClass = new \ReflectionClass((string)$name);
            $fileName = $refClass->getFileName();
            if (empty($fileName)) {
                echo "Could not find file for $name\n";
            }
            $this->nameFileMap[$name] = $fileName;
        }
        return $this->nameFileMap[$name];
    }
}
