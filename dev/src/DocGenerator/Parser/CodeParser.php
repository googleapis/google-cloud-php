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

namespace Google\Cloud\Dev\DocGenerator\Parser;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\FileReflector;

class CodeParser implements ParserInterface
{
    private $path;
    private $outputName;
    private $reflector;
    private $markdown;

    public function __construct($path, $outputName, FileReflector $reflector)
    {
        $this->path = $path;
        $this->outputName;
        $this->reflector = $reflector;
        $this->markdown = \Parsedown::instance();
    }

    public function parse()
    {
        $this->reflector->process();
        return $this->buildDocument($this->getReflector($this->reflector));
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

        throw new \Exception('Could not get reflector for '. $this->outputName);
    }

    private function buildDocument($reflector)
    {
        $name = $reflector->getShortName();
        $id = substr($reflector->getName(), 14);
        $id = str_replace('\\', '/', $id);
        // @todo see if there is a better way to determine the type
        $parts = explode('_', get_class($reflector->getNode()));
        $type = end($parts);

        $docBlock = $reflector->getDocBlock();

        $magic = [];
        if ($docBlock && $docBlock->getTags()) {
            $magicMethods = array_filter($docBlock->getTags(), function ($tag) {
                return ($tag->getName() === 'method');
            });

            $magic = $this->buildMagicMethods($magicMethods, $name);
        }

        $methods = $reflector->getMethods();

        if (is_null($docBlock)) {
            throw new \Exception(sprintf('%s has no description', $reflector->getName()));
        }

        $split = $this->splitDescription($docBlock->getText());

        return [
            'id' => strtolower($id),
            'type' => strtolower($type),
            'title' => $reflector->getNamespace() . '\\' . $name,
            'name' => $name,
            'description' => $this->buildDescription($docBlock, $split['description']),
            'examples' => $this->buildExamples($split['examples']),
            'resources' => $this->buildResources($docBlock->getTagsByName('see')),
            'methods' => array_merge(
                $this->buildMethods($methods, $name),
                $magic
            )
        ];
    }

    private function buildDescription($docBlock, $content = null)
    {
        if ($content === null) {
            $content = $docBlock->getText();
        }

        $desc = new Description($content, $docBlock);
        $parsedContents = $desc->getParsedContents();

        if (count($parsedContents) > 1) {
            // convert inline {@see} tag to custom type link
            foreach ($parsedContents as &$part) {
                if ($part instanceof Seetag) {
                    $reference = $part->getReference();
                    if (substr_compare($reference, 'Google\Cloud', 0, 12) === 0) {
                        $part = $this->buildLink($reference);
                    }
                }
            }

            $content = implode('', $parsedContents);
        }

        $content = str_ireplace('[optional]', '', $content);
        return $this->markdown->parse($content);
    }

    private function buildMethods($methods, $className)
    {
        $methodArray = [];
        foreach ($methods as $name => $method) {
            if ($method->getVisibility() !== 'public') {
                continue;
            }

            $docBlock = $method->getDocBlock();
            if (is_null($docBlock)) {
                throw new \Exception(sprintf('%s::%s has no description', $className, $name));
            }

            $access = $docBlock->getTagsByName('access');

            if (!empty($access)) {
                if ($access[0]->getContent() === 'private') {
                    continue;
                }
            }

            $methodArray[] = $this->buildMethod($method);
        }

        return $methodArray;
    }

    private function buildMagicMethods($magicMethods, $className)
    {
        $methodArray = [];
        foreach ($magicMethods as $method) {
            $description = $method->getDescription();
            if (is_null($description)) {
                throw new \Exception(sprintf('%s::%s (magic method) has no description', $className, $method->getMethodName()));
            }

            $methodArray[] = $this->buildMagicMethod($method);
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

        $split = $this->splitDescription($fullDescription);

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $this->outputName . '#L' . $method->getLineNumber(),
            'description' => $this->buildDescription($docBlock, $split['description']),
            'examples' => $this->buildExamples($split['examples']),
            'resources' => $this->buildResources($resources),
            'params' => $this->buildParams($params),
            'exceptions' => $this->buildExceptions($exceptions),
            'returns' => $this->buildReturns($returns)
        ];
    }

    private function buildMagicMethod($magicMethod)
    {
        $docBlock = new DocBlockStripSpaces(substr($magicMethod->getDescription(), 1, -1));
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
            'id' => $magicMethod->getMethodName(),
            'type' => $magicMethod->getMethodName() === '__construct' ? 'constructor' : 'instance',
            'name' => $magicMethod->getMethodName(),
            'source' => $this->outputName,
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
            $example = trim($example);
            $caption = '';

            if (strlen($example) === 0) {
                continue;
            }

            $lines = explode(PHP_EOL, $example);

            // strip the syntax highlighting, it won't be used in the doc site
            if (substr($lines[0], 0, 3) === 'php') {
                unset($lines[0]);
            }

            $captionLines = [];
            foreach ($lines as $key => $line) {
                if (substr($line, 0, 2) === '//') {
                    $captionLines[] = substr($line, 3);
                    unset($lines[$key]);
                } else {
                    break;
                }
            }

            $caption = $this->markdown->parse(implode(' ', $captionLines));

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

            $descriptionString = $this->buildDescription($param->getDocBlock(), $description);
            $nestedParamsArray = [];

            if (strpos($param->getType(), 'array') === 0 && $this->hasNestedParams($description)) {
                $nestedParamString = trim(str_replace('[optional]', '', $description));
                $nestedParamString = substr($nestedParamString, 1, -1);
                $nestedParams = explode('@type', $nestedParamString);
                $nestedParamString = trim(array_shift($nestedParams));
                $nestedParamsArray = $this->buildNestedParams($nestedParams, $param);

                $descriptionString = $this->buildDescription($param->getDocBlock(), $nestedParamString);
            }

            $varName = substr($param->getVariableName(), 1);
            if (!$varName) {
                throw new \Exception('invalid or missing parameter name in "'. $param->getDocBlock()->getShortDescription() .'"');
            }
            $paramsArray[] = [
                'name' => $varName,
                'description' => $descriptionString,
                'types' => $this->handleTypes($param->getTypes()),
                'optional' => (strpos(trim(strtolower($description)), '[optional]') === 0),
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
            $nestedParam = explode(' ', trim($param), 3);
            if (count($nestedParam) < 3) {
                throw new \Exception('nested param is in an invalid format: '. $param);
            }

            list($type, $name, $description) = $nestedParam;
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
        $description = trim(str_replace('[optional]', '', $description));

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
                'description' => $this->buildDescription(null, $return->getDescription())
            ];
        }

        return $returnsArray;
    }

    private function handleTypes($types)
    {
        foreach ($types as &$type) {
            // object is a PHPDoc keyword so it is not capable of detecting the context
            // https://github.com/phpDocumentor/ReflectionDocBlock/blob/2.0.4/src/phpDocumentor/Reflection/DocBlock/Type/Collection.php#L37
            if ($type === 'Object') {
                $type = '\Google\Cloud\Storage\Object';
            }

            if (substr_compare($type, '\Google\Cloud', 0, 13) === 0) {
                $type = $this->buildLink($type);
            }

            $matches = [];
            if (preg_match('/\\\\?Generator\<(.*?)\>/', $type, $matches)) {
                $typeLink = $matches[1];
                if (strpos($matches[1], '\\') !== FALSE) {
                    $typeLink = $this->buildLink($matches[1]);
                }

                $type = sprintf(htmlentities('Generator<%s>'), $typeLink);
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

    private function splitDescription($description)
    {
        $parts = explode('Example:', $description);
        $examples = null;

        if (strpos($description, 'Example:') !== false) {
            $examples = $parts[1];
        }

        return [
            'description' => $parts[0],
            'examples' => $examples
        ];
    }
}

class DocBlockStripSpaces extends DocBlock
{
    /**
     * Strips extra whitespace from the DocBlock comment.
     *
     * @param string $comment String containing the comment text.
     * @param int $spaces The number of spaces to strip.
     *
     * @return string
     */
    public function cleanInput($comment, $spaces = 4)
    {
        $lines = array_map(function ($line) use ($spaces) {
            return substr($line, $spaces);
        }, explode(PHP_EOL, $comment));

        return trim(implode(PHP_EOL, $lines));
    }
}
