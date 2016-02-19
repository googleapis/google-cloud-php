<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

require 'vendor/autoload.php';

use phpDocumentor\Reflection\FileReflector;

class DocGenerator
{
    private $currentFile;
    private $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function generate()
    {
        foreach ($this->files as $file) {
            $this->currentFile = $file;
            $fileReflector = new FileReflector($file);
            $fileReflector->process();
            $document = $this->buildClass($fileReflector->getClasses()[0]);

            // @todo output json
        }
    }

    private function buildClass($class)
    {
        $namespaceParts = explode('\\', $class->getName());
        $name = end($namespaceParts);

        return [
            'id' => lcfirst($name),
            'metadata' => [
                'name' => $name,
                'description' => $class->getDocBlock()->getText()
            ],
            'methods' => $this->buildMethods($class->getMethods())
        ];
    }

    private function buildMethods($methods)
    {
        $methodArray = [];
        foreach ($methods as $method) {
            $methodArray[] = $this->buildMethod($method);
        }

        return $methodArray;
    }

    private function buildMethod($method)
    {
        $docBlock = $method->getDocBlock();
        $fullDescription = $docBlock->getText();
        $resources = $docBlock->getTagsByName('see');
        $params = $docBlock->getTagsByName('param');
        $exceptions = $docBlock->getTagsByName('throws');
        $returns = $docBlock->getTagsByName('return');
        $docText = null;
        $examples = null;

        if (strpos($fullDescription, 'Example:') !== false) {
            list($docText, $examples) = explode('Example:', $fullDescription);
        }

        return [
            'metadata' => [
                'constructor' => $method->getName() === '__construct' ? true : false,
                'name' => $method->getName(),
                'source' => $this->currentFile . '#L' . $method->getLineNumber(),
                'description' => trim($docText),
                'examples' => $this->buildExamples($examples),
                'resources' => $this->buildResources($resources)
            ],
            'params' => $this->buildParams($params),
            'exceptions' => $this->buildExceptions($exceptions),
            'returns' => $this->buildReturns($returns)
        ];
    }

    private function buildExamples($examples)
    {
        $examplesArray = [];

        if (!$examples) {
            return $examplesArray;
        }

        $exampleParts = explode('```', $examples);

        foreach ($exampleParts as $key => $example) {
            $example = trim($example);

            if (strlen($example) === 0) {
                continue;
            }

            $examplesArray[] = [
                'caption' => '', // @todo
                'code' => $example
            ];
        }

        return $examplesArray;
    }

    private function buildResources($resources)
    {
        if (count($resources) === 0) {
            return $resources;
        }

        $resourcesArray = [];

        foreach ($resources as $resource) {
            $resourcesArray[] = [
                'title' => $resource->getDescription(),
                'link' => $resource->getReference()
            ];
        }

        return $resourcesArray;
    }

    // @todo refactor
    private function buildParams($params)
    {
        if (count($params) === 0) {
            return $params;
        }

        $paramsArray = [];

        foreach ($params as $param) {
            $description = $param->getDescription();
            $nestedParamsArray = null;

            if ($param->getType() === 'array' && $this->hasNestedParams($description)) {
                $description = trim(substr($description, 1, -1));
                $nestedParams = explode('@type', $description);
                $description = trim(array_shift($nestedParams));
                $nestedParamsArray = $this->buildNestedParams($nestedParams, $param->getVariableName());
            }

            $paramsArray[] = [
                'name' => substr($param->getVariableName(), 1),
                'description' => $description,
                'types' => $param->getTypes(),
                'optional' => null, // @todo
                'nullable' => null // @todo
            ];

            if ($nestedParamsArray) {
                $paramsArray += $nestedParamsArray;
            }
        }

        return $paramsArray;
    }

    // @todo refactor
    private function buildNestedParams($nestedParams, $parentParamName)
    {
        $paramsArray = [];

        foreach ($nestedParams as $param) {
            list($type, $name, $description) = explode(' ', trim($param), 3);
            $name = substr($name, 1);
            $description = preg_replace('/\s+/', ' ', $description);
            $paramsArray[] = [
                'name' => substr($parentParamName, 1) . '.' . $name,
                'description' => $description,
                'types' => explode('|', $type),
                'optional' => null, // @todo
                'nullable' => null //@todo
            ];
        }

        return $paramsArray;
    }

    private function hasNestedParams($description)
    {
        if (strlen($description) === 0) {
            return false;
        }

        if ($description[0] === '{') {
            return true;
        }

        return false;
    }

    private function buildExceptions($exceptions)
    {
        if (count($exceptions) === 0) {
            return $exceptions;
        }

        $exceptionsArray = [];

        foreach ($exceptions as $exception) {
            $exceptionsArray[] = [
                'type' => $exception->getType(),
                'description' => $exception->getDescription()
            ];
        }

        return $exceptionsArray;
    }

    private function buildReturns($returns)
    {
        if (count($returns) === 0) {
            return $returns;
        }

        $returnsArray = [];

        foreach ($returns as $return) {
            $returnsArray[] = [
                'types' => $return->getTypes(),
                'description' => $return->getDescription()
            ];
        }

        return $returnsArray;
    }
}
