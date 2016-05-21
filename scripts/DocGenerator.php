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

require __DIR__ . '/../vendor/autoload.php';

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\FileReflector;

/**
 * Parses given files and builds documentation for our common docs site.
 */
class DocGenerator
{
    private $currentFile;
    private $files;
    private $outputPath;

    /**
     * @param array $files
     */
    public function __construct(array $files, $outputPath)
    {
        $this->files = $files;
        $this->outputPath = $outputPath;
        $this->markdown = \Parsedown::instance();
    }

    /**
     * Generates JSON documentation from provided files.
     *
     * @return void
     */
    public function generate()
    {
        $types = [];

        foreach ($this->files as $file) {
            $this->currentFile = substr(str_replace(__DIR__, '', $file), 3);
            $jsonOutputPath = $this->buildOutputPath();
            $fileReflector = new FileReflector($file);
            $fileReflector->process();
            $document = $this->buildDocument($this->getReflector($fileReflector));

            $types[] = [
                'id' => $document['id'],
                'title' => $document['title'],
                'contents' => $document['id'] . '.json'
            ];

            if (!is_dir(dirname($jsonOutputPath))) {
                mkdir(dirname($jsonOutputPath), 0777, true);
            }

            file_put_contents($jsonOutputPath, json_encode($document));
        }

        file_put_contents($this->outputPath . '/types.json', json_encode($types));
    }

    private function getReflector($fileReflector)
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
    }

    private function buildDocument($reflector)
    {
        $name = $reflector->getShortName();
        $id = substr($reflector->getName(), 14);
        $id = str_replace('\\', '/', $id);
        // @todo see if there is a better way to determine the type
        $parts = explode('_', get_class($reflector->getNode()));
        $type = end($parts);

        return [
            'id' => strtolower($id),
            'type' => strtolower($type),
            'title' => $reflector->getNamespace() . '\\' . $name,
            'name' => $name,
            'description' => $this->buildDescription($reflector->getDocBlock()),
            'methods' => $this->buildMethods($reflector->getMethods())
        ];
    }

    private function buildDescription($docBlock, $content = null)
    {
        if ($content === null) {
            $content = $docBlock->getText();
        }

        $desc = new Description($content, $docBlock);
        $parsedContents = $desc->getParsedContents();

        // convert inline {@see} tag to custom type link
        foreach ($parsedContents as &$content) {
            if ($content instanceof Seetag) {
                $reference = $content->getReference();
                if (substr_compare($reference, 'Google\Cloud', 0, 12) === 0) {
                    $content = $this->buildLink($reference);
                }
            }
        }

        return $this->markdown->parse(implode('', $parsedContents));
    }

    private function buildMethods($methods)
    {
        $methodArray = [];
        foreach ($methods as $method) {
            if ($method->getVisibility() !== 'public') {
                continue;
            }

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
        $docText = '';
        $examples = null;

        $parts = explode('Example:', $fullDescription);

        $docText = $parts[0];

        if (strpos($fullDescription, 'Example:') !== false) {
            $examples = $parts[1];
        }

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $this->currentFile . '#L' . $method->getLineNumber(),
            'description' => $this->buildDescription($docBlock, $docText),
            'examples' => $this->buildExamples($examples),
            'resources' => $this->buildResources($resources),
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

        foreach ($exampleParts as $example) {
            $caption = '';

            if (strlen($example) === 0) {
                continue;
            }

            // strip the syntax highlighting, it won't be used in the doc site
            $example = ltrim($example, 'php');
            $example = trim($example);
            $lines = explode(PHP_EOL, $example);

            foreach ($lines as $key => $line) {
                if (substr($line, 0, 2) === '//') {
                    $caption .= $this->markdown->parse(substr($line, 3));
                    unset($lines[$key]);
                } else {
                    break;
                }
            }

            $examplesArray[] = [
                'caption' => $caption,
                'code' => implode(PHP_EOL, $lines)
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

    private function buildParams($params)
    {
        if (count($params) === 0) {
            return $params;
        }

        $paramsArray = [];

        foreach ($params as $param) {
            $description = $param->getDescription();
            $nestedParamsArray = [];

            if ($param->getType() === 'array' && $this->hasNestedParams($description)) {
                $description = substr($description, 1, -1);
                $nestedParams = explode('@type', $description);
                $description = trim(array_shift($nestedParams));
                $nestedParamsArray = $this->buildNestedParams($nestedParams, $param);
            }

            $paramsArray[] = [
                'name' => substr($param->getVariableName(), 1),
                'description' => $this->buildDescription($param->getDocBlock(), $description),
                'types' => $this->handleTypes($param->getTypes()),
                'optional' => null, // @todo
                'nullable' => null // @todo
            ];

            $paramsArray = array_merge($paramsArray, $nestedParamsArray);
        }

        return $paramsArray;
    }

    /**
     * PHPDoc has no support for nested params currently. this is a workaround
     * until it is implemented.
     */
    private function buildNestedParams($nestedParams, $origParam)
    {
        $paramsArray = [];

        foreach ($nestedParams as $param) {
            list($type, $name, $description) = explode(' ', trim($param), 3);
            $name = substr($name, 1);
            $description = preg_replace('/\s+/', ' ', $description);
            $types = explode('|', $type);

            $paramsArray[] = [
                'name' => substr($origParam->getVariableName(), 1) . '.' . $name,
                'description' => $this->buildDescription($origParam->getDocBlock(), $description),
                'types' => $this->handleTypes($types),
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
                'types' => $this->handleTypes($return->getTypes()),
                'description' => $this->markdown->parse($return->getDescription())
            ];
        }

        return $returnsArray;
    }

    private function handleTypes($types)
    {
        foreach ($types as &$type) {
            if (substr_compare($type, '\Google\Cloud', 0, 13) === 0) {
                $type = $this->buildLink($type);
            }
        }

        return $types;
    }

    private function buildLink($content)
    {
        if ($content[0] === '\\') {
            $content = substr($content, 1);
        }

        $displayName = $content;
        $content = substr($content, 13);
        $parts = explode('::', $content);
        $type = strtolower(str_replace('\\', '/', $parts[0]));

        $openTag = '<a data-custom-type="' . $type . '"';

        if (isset($parts[1])) {
            $method = str_replace('()', '', $parts[1]);
            $openTag .= ' data-method="' . $method . '">';
        } else {
            $openTag .= '>';
        }

        return $openTag . $displayName . '</a>';
    }

    private function buildOutputPath()
    {
        $pathInfo = pathinfo($this->currentFile);
        $jsonOutputPath =  $this->outputPath . substr($pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.json', 4);

        return strtolower($jsonOutputPath);
    }
}
