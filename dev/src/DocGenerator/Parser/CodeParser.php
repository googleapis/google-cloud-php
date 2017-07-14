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
use Google\Cloud\Dev\DocGenerator\ReflectorRegister;
use Google\Cloud\Dev\GetComponentsTrait;
use phpDocumentor\Reflection\ClassReflector;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\FileReflector;
use phpDocumentor\Reflection\InterfaceReflector;
use phpDocumentor\Reflection\TraitReflector;

class CodeParser implements ParserInterface
{
    use GetComponentsTrait;

    const CLASS_TYPE_REGEX = '/[Generator\<]?(Google\\\Cloud\\\[\w\\\]{0,})[\>]?[\[\]]?/';
    const SNIPPET_NAME_REGEX = '/\/\/\s?\[snippet\=(\w{0,})\]/';

    private static $composerFiles = [];

    private $path;
    private $fileName;
    private $register;
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
        ReflectorRegister $register,
        $projectRoot,
        $componentId,
        $manifestPath,
        $release,
        $basePath,
        $isComponent = true
    ) {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->register = $register;
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
        list($fileReflector, $reflector) = $this->register->getReflectorsFromFileName($this->path);

        return $reflector
            ? $this->buildDocument($fileReflector, $reflector)
            : null;
    }

    private function buildInfo($fileReflector, $reflector)
    {
        $classInfo = [
            'methods' => [],
            'traits' => [],
            'parents' => [],
            'interfaces' => [],
            'interfaceMethods' => [],
        ];

        $this->buildClassInfoRecursive($fileReflector, $reflector, $classInfo);

        return $classInfo;
    }

    private function buildClassInfoRecursive($fileReflector, $reflector, &$classInfo)
    {
        if (is_null($fileReflector) || is_null($reflector)) {
            return;
        }

        $methods = $this->buildMethodInfo($fileReflector, $reflector);

        $isInternal = substr_compare($reflector->getName(), '\Google\Cloud', 0, 13) === 0;
        if ($isInternal) {
            $classInfo['methods'] += $methods;
        }

        foreach ($reflector->getTraits() as $trait) {
            list($traitFileReflector, $traitReflector) = $this->register->getReflectors($trait);
            $this->buildClassInfoRecursive($traitFileReflector, $traitReflector, $classInfo);
        }

        foreach ($reflector->getInterfaces() as $interface) {
            list($interfaceFileReflector, $interfaceReflector) = $this->register->getReflectors($interface);
            $this->buildInterfaceInfoRecursive($interfaceFileReflector, $interfaceReflector, $classInfo);
        }

        $parent = $reflector->getParentClass();
        if (!empty($parent)) {
            list($parentFileReflector, $parentReflector) = $this->register->getReflectors($parent);
            $this->buildClassInfoRecursive($parentFileReflector, $parentReflector, $classInfo);
            // Add $parent to array after calling getMethodsRecursive so that parents are correctly
            // ordered
            $classInfo['parents'][] = $parent;
        }
    }

    private function buildInterfaceInfo($fileReflector, $reflector)
    {
        $classInfo = [
            'interfaces' => [],
            'interfaceMethods' => [],
        ];

        $this->buildInterfaceInfoRecursive($fileReflector, $reflector, $classInfo);

        return $classInfo;
    }

    private function buildInterfaceInfoRecursive($fileReflector, $reflector, &$classInfo)
    {
        if (is_null($fileReflector) || is_null($reflector)) {
            return false;
        }

        $isInternal = substr_compare($reflector->getName(), '\Google\Cloud', 0, 13) === 0;
        if ($isInternal) {
            $classInfo['interfaceMethods'] += $this->buildMethodInfo($fileReflector, $reflector);
        }

        // Add parent interfaces to array before calling getMethodsRecursive to use PHP array
        // ordering, so that parent interfaces are before more deeply nested interfaces
        $classInfo['interfaces'] += $reflector->getParentInterfaces();
        foreach ($reflector->getParentInterfaces() as $parentInterface) {
            list($parentFileReflector, $parentReflector) = $this->register->getReflectors($parentInterface);
            $this->buildInterfaceInfoRecursive($parentFileReflector, $parentReflector, $classInfo);
        }
    }

    private function buildMethodInfo($fileReflector, $reflector)
    {
        $methods = [];
        foreach ($reflector->getMethods() as $name => $method) {
            if ($method->getVisibility() !== 'public') {
                continue;
            }
            $methods[$name] = [
                'methodReflector' => $method,
                'source' => $this->getPath($fileReflector),
                'container' => $reflector->getName(),
            ];
        }
        return $methods;
    }

    private function getPath($fileReflector)
    {
        $fileSplit = explode($this->basePath, trim($fileReflector->getFileName(), '/'));
        return 'src/' . trim($fileSplit[1], '/');
    }

    private function buildDocument($fileReflector, $reflector)
    {
        $name = $reflector->getShortName();
        $fullName = $reflector->getName();
        $id = substr($fullName, 14);
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

            $magic = $this->buildMagicMethods($magicMethods, $fullName);
        }

        if (is_null($docBlock)) {
            throw new \Exception(sprintf('%s has no description', $fullName));
        }

        $split = $this->splitDescription($docBlock->getText());

        if ($this->isInterface($reflector)) {
            $classInfo = $this->buildInterfaceInfo($fileReflector, $reflector);
            $description = $this->buildInterfaceDescription($classInfo, $docBlock, $split['description']);
            $methods = $this->buildMethods($classInfo['interfaceMethods'], $fullName);
        } else {
            $classInfo = $this->buildInfo($fileReflector, $reflector);
            $description = $this->buildClassDescription($classInfo, $docBlock, $split['description']);
            $methods = $this->buildMethods($classInfo['methods'], $fullName);
        }

        return [
            'id' => strtolower($id),
            'type' => strtolower($type),
            'title' => $reflector->getNamespace() . '\\' . $name,
            'name' => $name,
            'description' => $description,
            'examples' => $this->buildExamples($split['examples']),
            'resources' => $this->buildResources($docBlock->getTagsByName('see')),
            'methods' => array_merge($methods, $magic)
        ];
    }

    private function isInterface($reflector)
    {
        return ($reflector instanceof InterfaceReflector) &&
                !($reflector instanceof ClassReflector);
    }

    private function buildDescription($docBlock, $content = null)
    {
        return $this->markdown->parse($this->buildDescriptionContent($docBlock, $content));
    }

    private function buildClassDescription($classInfo, $docBlock, $content = null)
    {
        $content = $this->buildDescriptionContent($docBlock, $content);
        $content .= $this->buildInheritDoc($classInfo);
        return $this->markdown->parse($content);
    }

    private function buildInterfaceDescription($classInfo, $docBlock, $content = null)
    {
        $content = $this->buildDescriptionContent($docBlock, $content);
        $content .= $this->buildInterfaceInheritDoc($classInfo);
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

    private function buildInheritDoc($classInfo)
    {
        $content = '';
        if (count($classInfo['parents']) > 0) {
            $content .= $this->implodeInheritDocLinks(" > ", $classInfo['parents'], "Extends");
        }
        if (count($classInfo['interfaces']) > 0) {
            $content .= $this->implodeInheritDocLinks(", ", $classInfo['interfaces'], "Implements");
        }

        return $content;
    }

    private function buildInterfaceInheritDoc($classInfo)
    {
        $content = '';
        if (count($classInfo['interfaces']) > 0) {
            $content .= $this->implodeInheritDocLinks(", ", $classInfo['interfaces'], "Extends");
        }

        return $content;
    }

    private function implodeInheritDocLinks($glue, $pieces, $prefix)
    {
        return "\n\n$prefix " . implode($glue, array_map([$this, 'buildReference'], $pieces));
    }

    private function buildMethods($methods, $className)
    {
        $methodArray = [];
        foreach ($methods as $name => $methodInfo) {
            $method = $methodInfo['methodReflector'];

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

            $methodArray[] = $this->buildMethod($method, $methodInfo, $className);
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

    private function buildMethod($method, $methodInfo, $className)
    {
        $docBlock = $method->getDocBlock();
        $fullDescription = $docBlock->getText();
        $resources = $docBlock->getTagsByName('see');
        $params = $docBlock->getTagsByName('param');
        $exceptions = $docBlock->getTagsByName('throws');
        $returns = $docBlock->getTagsByName('return');
        $examples = null;

        $split = $this->splitDescription($fullDescription);

        $description = $this->buildDescription($docBlock, $split['description']);
        if ($methodInfo['container'] !== $className) {
            $description .= "\n\nImplemented in " . $this->buildReference($methodInfo['container']);
        }

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $methodInfo['source'] . '#L' . $method->getLineNumber(),
            'description' => $description,
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
