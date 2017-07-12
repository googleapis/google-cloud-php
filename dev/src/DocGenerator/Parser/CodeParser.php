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

use Google\Cloud\Dev\DocBlockStripSpaces;
use Google\Cloud\Dev\GetComponentsTrait;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\FileReflector;

class CodeParser implements ParserInterface
{
    use GetComponentsTrait;

    const CLASS_TYPE_REGEX = '/[Generator\<]?(Google\\\Cloud\\\[\w\\\]{0,})[\>]?[\[\]]?/';
    const SNIPPET_NAME_REGEX = '/\/\/\s?\[snippet\=(\w{0,})\]/';

    private static $composerFiles = [];

    private $path;
    private $fileName;
    private $reflector;
    private $markdown;
    private $projectRoot;
    private $externalTypes;
    private $componentId;
    private $manifestPath;
    private $release;
    private $isComponent;
    private $basePath;

    public function __construct(
        $path,
        $fileName,
        FileReflector $reflector,
        $projectRoot,
        $componentId,
        $manifestPath,
        $release,
        $basePath,
        $isComponent = true
    ) {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->reflector = $reflector;
        $this->markdown = \Parsedown::instance();
        $this->projectRoot = $projectRoot;
        $this->externalTypes = json_decode(file_get_contents($this->projectRoot . '/docs/external-classes.json'), true);
        $this->componentId = $componentId;
        $this->manifestPath = $manifestPath;
        $this->release = $release;
        $this->basePath = $basePath;
        $this->isComponent = $isComponent;
    }

    public function parse()
    {
        $this->reflector->process();
        $reflector = $this->getReflector($this->reflector);

        return $reflector
            ? $this->buildDocument($reflector)
            : null;
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

        return null;
    }

    private function loadFileFromName($name)
    {
        if (empty($name)) {
            return null;
        }
        if (substr_compare($name, '\Google\Cloud', 0, 13) != 0) {
            echo "Skipping external class $name\n";
            return null;
        }
        if (!(class_exists($name) || interface_exists($name) || trait_exists($name))) {
            throw new \RuntimeException("Could not find class, trait or interface for $name");
        }
        $refClass = new \ReflectionClass((string) $name);
        $fileName = $refClass->getFileName();
        if (empty($fileName)) {
            throw new \RuntimeException("Could not find file for $name");
        }
        $fileReflector = new FileReflector($fileName);
        $fileReflector->process();
        return $fileReflector;
    }

    private function getMethods($reflector)
    {
        $fileReflector = $this->reflector;
        $methods = [];
        $methodInfoArray = [];

        $this->getMethodsRecursive($fileReflector, $reflector, $methods, $methodInfoArray);

        return [$methods, $methodInfoArray];
    }

    private function getInherited($reflector)
    {
        $inherited = [];
        if (method_exists($reflector, 'getTraits')) {
            $inherited += $reflector->getTraits();
        }
        if (method_exists($reflector, 'getParentClass')) {
            $inherited[] = $reflector->getParentClass();
        }
        if (method_exists($reflector, 'getParentInterfaces')) {
            $inherited += $reflector->getParentInterfaces();
        }
        return $inherited;
    }

    private function getMethodsRecursive($fileReflector, $reflector, &$methods, &$methodInfoArray)
    {
        if (is_null($reflector)) {
            return;
        }

        foreach ($reflector->getMethods() as $name => $method) {
            if (!array_key_exists($name, $methods)) {
                $methods[$name] = $method;
                $methodInfoArray[$name] = [
                    'source' => $this->getPath($fileReflector),
                ];
            }
        }

        foreach ($this->getInherited($reflector) as $superName) {
            $superFile = $this->loadFileFromName($superName);
            if (isset($superFile)) {
                $super = $this->getReflector($superFile);
                $this->getMethodsRecursive($superFile, $super, $methods, $methodInfoArray);
            }
        }

    }

    private function getPath($fileReflector)
    {
        $fileSplit = explode($this->basePath, trim($fileReflector->getFileName(), '/'));
        return 'src/' . trim($fileSplit[1], '/');
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

        list($methods, $methodInfoArray) = $this->getMethods($reflector);

        if (is_null($docBlock)) {
            throw new \Exception(sprintf('%s has no description', $reflector->getName()));
        }

        $split = $this->splitDescription($docBlock->getText());

        return [
            'id' => strtolower($id),
            'type' => strtolower($type),
            'title' => $reflector->getNamespace() . '\\' . $name,
            'name' => $name,
            'description' => $this->buildClassDescription($reflector, $docBlock, $split['description']),
            'examples' => $this->buildExamples($split['examples']),
            'resources' => $this->buildResources($docBlock->getTagsByName('see')),
            'methods' => array_merge(
                $this->buildMethods($methods, $name, $methodInfoArray),
                $magic
            )
        ];
    }

    private function buildDescription($docBlock, $content = null)
    {
        return $this->markdown->parse($this->buildDescriptionContent($docBlock, $content));
    }

    private function buildClassDescription($reflector, $docBlock, $content = null)
    {
        $content = $this->buildDescriptionContent($docBlock, $content);
        $content .= $this->buildInheritDoc($reflector);
        return $this->markdown->parse($content);
    }

    private function buildDescriptionContent($docBlock, $content = null)
    {
        if ($content === null) {
            $content = $docBlock->getText();
        }

        $desc = new Description($content, $docBlock);
        $parsedContents = $desc->getParsedContents();

        if (count($parsedContents) > 1) {
            // convert inline {@see} tag to custom type link
            foreach ($parsedContents as &$part) {
                if ($part instanceof SeeTag) {
                    $part = $this->buildReference($part->getReference(), $part);
                }
            }

            $content = implode('', $parsedContents);
        }

        $content = str_ireplace('[optional]', '', $content);
        return $content;
    }

    private function buildReference($reference, $default = null)
    {
        if ($this->hasInternalType($reference)) {
            return $this->buildLink($reference);
        } elseif ($this->hasExternalType($reference)) {
            return $this->buildExternalType($reference);
        } else {
            return isset($default) ? $default : $reference;
        }
    }

    private function buildInheritDoc($reflector)
    {
        $content = '';
        if (method_exists($reflector, 'getParentClass')) {
            $parentClass = $reflector->getParentClass();
            if (isset($parentClass)) {
                $content .= "\nExtends " . $this->buildReference($parentClass);
            }
        } elseif (method_exists($reflector, 'getParentInterfaces')) {
            foreach($reflector->getParentInterfaces() as $trait) {
                $content .= "\nExtends " . $this->buildReference($trait);
            }
        }

        if (method_exists($reflector, 'getTraits')) {
            foreach($reflector->getTraits() as $trait) {
                $content .= "\nUses " . $this->buildReference($trait);
            }
        }

        if (method_exists($reflector, 'getInterfaces')) {
            foreach($reflector->getInterfaces() as $trait) {
                $content .= "\nImplements " . $this->buildReference($trait);
            }
        }
    }

    private function buildMethods($methods, $className, $methodInfoArray)
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

            $methodArray[] = $this->buildMethod($method, $methodInfoArray[$name]);
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

    private function buildMethod($method, $methodInfo)
    {
        $docBlock = $method->getDocBlock();
        $fullDescription = $docBlock->getText();
        $resources = $docBlock->getTagsByName('see');
        $params = $docBlock->getTagsByName('param');
        $exceptions = $docBlock->getTagsByName('throws');
        $returns = $docBlock->getTagsByName('return');
        $examples = null;

        $split = $this->splitDescription($fullDescription);

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $methodInfo['source'] . '#L' . $method->getLineNumber(),
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
            'source' => $this->getSource(),
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

            $example = preg_replace(self::SNIPPET_NAME_REGEX, '', $example);
            $lines = explode(PHP_EOL, trim($example));

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
                'code' => trim(implode(PHP_EOL, $lines))
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
            $context = $return->getDocBlock()->getContext();
            $aliases = $context ? $context->getNamespaceAliases() : [];

            $returnsArray[] = [
                'types' => $this->handleTypes($return->getTypes(), $aliases),
                'description' => $this->buildDescription(null, $return->getDescription())
            ];
        }

        return $returnsArray;
    }

    private function handleTypes($types, array $aliases = [])
    {
        $res = [];
        foreach ($types as $type) {
            $matches = [];

            if (preg_match('/\\\\?(.*?)\<(.*?)\>/', $type, $matches)) {
                $matches[1] = $this->resolveTypeAlias($matches[1], $aliases);
                $matches[2] = $this->resolveTypeAlias($matches[2], $aliases);

                $iteratorType = $matches[1];
                if (strpos($matches[1], '\\') !== FALSE) {
                    $matches[1] = $this->buildLink($matches[1]);
                }

                $typeLink = $matches[2];
                if (strpos($matches[2], '\\') !== FALSE) {
                    $matches[2] = $this->buildLink($matches[2]);
                }

                $type = sprintf(htmlentities('%s<%s>'), $matches[1], $matches[2]);
            } else {
                $type = $this->buildReference($type);
            }

            $res[] = $type;
        }

        return $res;
    }

    private function resolveTypeAlias($type, array $aliases)
    {
        $pieces = explode('\\', $type);
        $basename = array_pop($pieces);
        if (array_key_exists($basename, $aliases)) {
            $type = $aliases[$basename];
        }

        return $type;
    }

    private function hasInternalType($type)
    {
        $type = trim($type, '\\');
        if (substr_compare($type, 'Google\\Cloud', 0, 12) === 0) {
            $matches = [];
            preg_match(self::CLASS_TYPE_REGEX, $type, $matches);
            $type = $matches[1];
            $file = $this->projectRoot . '/src' . str_replace('\\', '/', substr($type, 12)) . '.php';
            return file_exists($file);
        }

        return false;
    }

    private function hasExternalType($type)
    {
        $type = trim($type, '\\');
        $types = array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        });

        if (count($types) === 0) {
            return false;
        }

        return true;
    }

    private function buildExternalType($type)
    {
        $type = trim($type, '\\');
        $types = array_values(array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        }));

        $external = $types[0];

        $href = sprintf($external['uri'], str_replace($external['name'], '', $type));
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $href,
            $type
        );
    }

    private function buildLink($content)
    {
        $componentId = null;
        if ($this->isComponent && substr_compare(trim($content, '\\'), 'Google\Cloud', 0, 12) === 0) {
            try {
                $matches = [];
                preg_match(self::CLASS_TYPE_REGEX, $content, $matches);
                $ref = new \ReflectionClass($matches[1]);
            } catch (\ReflectionException $e) {
                throw new \Exception(sprintf(
                    'Reflection Exception: %s in %s. Given class was %s',
                    $e->getMessage(),
                    realpath($this->path),
                    $content
                ));
            }

            $recurse = true;
            $file = $ref->getFileName();

            if (strpos($file, dirname(realpath($this->path))) !== false) {
                $recurse = false;
            }

            do {
                $composer = dirname($file) .'/composer.json';
                if (file_exists($composer) && $component = $this->isComponent($composer)) {
                    $componentId = $component['id'];
                    if ($componentId === $this->componentId) {
                        $componentId = null;
                    }
                    $recurse = false;
                } elseif (trim($file, '/') === trim($this->projectRoot, '/')) {
                    $recurse = false;
                } else {
                    $file = dirname($file);
                }
            } while($recurse);
        }

        $content = trim($content, '\\');

        $displayName = $content;
        $content = substr($content, 13);
        $parts = explode('::', $content);
        $type = strtolower(str_replace('\\', '/', $parts[0]));

        if ($componentId) {
            $version = ($this->release)
                ? $this->getComponentVersion($this->manifestPath, $componentId)
                : 'master';

            $type = $componentId .'/'. $version .'/'. $type;
        }

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

    private function isComponent($composerPath)
    {
        if (isset(self::$composerFiles[$composerPath])) {
            $contents = self::$composerFiles[$composerPath];
        } else {
            $contents = json_decode(file_get_contents($composerPath), true);
            self::$composerFiles[$composerPath] = $contents;
        }

        if (isset($contents['extra']['component'])) {
            return $contents['extra']['component'];
        }

        return false;
    }

    private function getSource()
    {
        return 'src' . explode('src', $this->path)[1];
    }
}
