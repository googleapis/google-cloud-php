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
use phpDocumentor\Reflection\ClassReflector;
use phpDocumentor\Reflection\FileReflector;
use phpDocumentor\Reflection\InterfaceReflector;
use phpDocumentor\Reflection\TraitReflector;

class ReflectorRegister
{
    private $fileReflectors = [];
    private $nameFileMap = [];

    /**
     * @param string $name The name of a class, trait or interface
     * @return array [$fileReflector, $reflector]
     */
    public function getReflectors($name)
    {
        $fileName = $this->getFileForName($name);
        return $this->getReflectorsFromFileName($fileName);
    }

    /**
     * @param string $fileName The file name containing a single class, trait or interface
     * @return array [$fileReflector, $reflector]
     */
    public function getReflectorsFromFileName($fileName)
    {
        $fileReflector = $this->getFileReflector($fileName);
        $reflector = $this->getReflectorFromFileReflector($fileReflector);
        return [$fileReflector, $reflector];
    }

    /**
     * @param $fileName
     * @return FileReflector|null
     */
    private function getFileReflector($fileName)
    {
        if (empty($fileName)) {
            return null;
        }

        if (!isset($this->fileReflectors[$fileName])) {
            $this->fileReflectors[$fileName] = new FileReflector($fileName);
            $this->fileReflectors[$fileName]->process();
        }
        return $this->fileReflectors[$fileName];
    }

    /**
     * @param FileReflector $fileReflector
     * @return InterfaceReflector|ClassReflector|TraitReflector|null
     */
    private function getReflectorFromFileReflector($fileReflector)
    {
        if (is_null($fileReflector)) {
            return null;
        }

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

    /**
     * @param $name
     * @return string|null
     */
    private function getFileForName($name)
    {
        if (empty($name)) {
            return null;
        }
        if (!array_key_exists($name, $this->nameFileMap)) {
            if (class_exists($name) || interface_exists($name) || trait_exists($name)) {
                $refClass = new \ReflectionClass((string)$name);
                $fileName = $refClass->getFileName();
                if (empty($fileName)) {
                    echo "Could not find file for $name\n";
                }
            } else {
                $fileName = null;
                echo "Could not find class, trait or interface for $name\n";
            }
            $this->nameFileMap[$name] = $fileName;
        }
        return $this->nameFileMap[$name];
    }
}
