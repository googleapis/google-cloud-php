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

use Google\Cloud\Core\Testing\DocBlockStripSpaces;
use Google\Cloud\Dev\DocGenerator\ReflectorRegister;
use Google\Cloud\Dev\GetComponentsTrait;
use Symfony\Component\Console\Output\OutputInterface;
use phpDocumentor\Reflection\ClassReflector;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tag\SeeTag;
use phpDocumentor\Reflection\DocBlock\Type\Collection;
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
    private $register;
    private $markdown;
    private $projectRoot;
    private $externalTypes;
    private $componentId;
    private $manifestPath;
    private $release;
    private $isComponent;

    public function __construct(
        $path,
        ReflectorRegister $register,
        $projectRoot,
        $componentId,
        $manifestPath,
        $release,
        OutputInterface $output,
        $id,
        $isComponent = true
    ) {
        $this->path = $path;
        $this->register = $register;
        $this->markdown = \Parsedown::instance();
        $this->projectRoot = $projectRoot;
        $this->externalTypes = json_decode(file_get_contents($this->projectRoot . '/docs/external-classes.json'), true);
        $this->componentId = $componentId;
        $this->manifestPath = $manifestPath;
        $this->release = $release;
        $this->output = $output;
        $this->id = $id;
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
                'source' => $fileReflector->getFileName(),
                'container' => $reflector->getName(),
            ];
        }
        return $methods;
    }

    private function buildDocument($fileReflector, $reflector)
    {
        $name = $reflector->getShortName();
        $fullName = $reflector->getName();
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
            throw new \Exception(sprintf('%s has no description (%s)', $fullName, $fileReflector->getFilename()));
        }

        $split = $this->splitDescription($docBlock->getText());

        if ($this->isInterface($reflector)) {
            $classInfo = $this->buildInterfaceInfo($fileReflector, $reflector);
            $description = $this->buildInterfaceDescription($classInfo, $docBlock, $split['description'], $reflector);
            $methods = $this->buildMethods($classInfo['interfaceMethods'], $fullName);
        } else {
            $classInfo = $this->buildInfo($fileReflector, $reflector);
            $description = $this->buildClassDescription($classInfo, $docBlock, $split['description'], $reflector);
            $methods = $this->buildMethods($classInfo['methods'], $fullName);
        }

        return [
            'id' => $this->id,
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

    private function buildDescription($docBlock, $content = null, $reflector = null)
    {
        return $this->markdown->parse(
            $this->buildDescriptionContent(
                $docBlock,
                $content,
                $reflector
            )
        );
    }

    private function buildClassDescription($classInfo, $docBlock, $content = null, $reflector = null)
    {
        $content = $this->buildDescriptionContent($docBlock, $content, $reflector);
        $content .= $this->buildInheritDoc($classInfo);
        return $this->markdown->parse($content);
    }

    private function buildInterfaceDescription($classInfo, $docBlock, $content = null, $reflector = null)
    {
        $content = $this->buildDescriptionContent($docBlock, $content, $reflector);
        $content .= $this->buildInterfaceInheritDoc($classInfo);
        return $this->markdown->parse($content);
    }

    private function buildDescriptionContent($docBlock, $content = null, $reflector = null)
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
                } elseif ($this->isInheritDocTag($part)) {
                    if ($reflector === null) {
                        throw new \Exception(sprintf(
                            "Inherit Doc tag ({@inheritdoc}) is only supported when \$reflector is not null.\nContext:\n%s",
                            $content));
                    }

                    if (!($reflector instanceof ClassReflector)) {
                        throw new \Exception(sprintf(
                            "Inherit Doc tag ({@inheritdoc}) is not supported for reflector type %s (found in: %s)."
                            . "\nContext:\n%s", get_class($reflector), $reflector->getName(), $content));
                    }

                    $parentClass = $reflector->getParentClass();
                    if (empty($parentClass)) {
                        throw new \Exception(sprintf('%s has {@inheritdoc} tag but no parent class', $reflector->getName()));
                    }
                    list($parentFileReflector, $parentReflector) = $this->register->getReflectors($parentClass);

                    $parentDocBlock = $parentReflector->getDocBlock();
                    $parentDocSplit = $this->splitDescription($parentDocBlock->getText());
                    $part = $this->buildDescriptionContent($parentDocBlock, $parentDocSplit['description'], $parentReflector);
                }
            }

            $content = implode('', $parsedContents);
        }

        $content = str_ireplace('[optional]', '', $content);
        return $content;
    }

    private function isInheritDocTag($tag)
    {
        return $tag instanceof Tag && ($tag->getName() == 'inheritDoc' || $tag->getName() == 'inheritdoc');
    }

    private function buildReference($reference, $default = null)
    {
        if ($this->hasInternalType($reference)) {
            return $this->buildInternalLink($reference);
        } elseif ($this->hasExternalType($reference)) {
            return $this->buildExternalLink($reference);
        } else {
            return isset($default) ? $default : $reference;
        }
    }

    private function buildInheritDoc($classInfo)
    {
        $content = '';
        if (count($classInfo['parents']) > 0) {
            $content .= $this->implodeInheritDocLinks(" &raquo; ", $classInfo['parents'], "Extends");
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
                $this->output->writeln(sprintf('%s::%s has no description', $className, $name));
                continue;
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

        $description = $this->buildDescription($docBlock, $split['description'], $method);
        if ($methodInfo['container'] !== $className) {
            $description .= "\n\nImplemented in " . $this->buildReference($methodInfo['container']);
        }

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $this->getSource($methodInfo['source']) . '#L' . $method->getLineNumber(),
            'description' => $description,
            'examples' => $this->buildExamples($split['examples']),
            'resources' => $this->buildResources($resources),
            'params' => $this->buildParams($params, $description),
            'exceptions' => $this->buildExceptions($exceptions),
            'returns' => $this->buildReturns($returns, $className)
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
            'source' => $this->getSource($this->path),
            'description' => $this->buildDescription($docBlock, $docText, $magicMethod),
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

    private function buildParams($params, $methodDescription = null)
    {
        if (count($params) === 0) {
            return $params;
        }

        $paramsArray = [];

        foreach ($params as $param) {
            $description = $param->getDescription();

            $descriptionString = $this->buildDescription($param->getDocBlock(), $description, $param);
            $nestedParamsArray = [];

            // To handle generated protobuf files
            if ($descriptionString === '' && $methodDescription) {
                $pos = strpos($methodDescription, '<p>Generated from protobuf field');
                if ($pos) {
                    $descriptionString = substr($methodDescription, 0, $pos);
                }
            }

            if (strpos($param->getType(), 'array') === 0 && $this->hasNestedParams($description)) {
                $nestedParamString = trim(str_replace('[optional]', '', $description));
                $nestedParamString = substr($nestedParamString, 1, -1);
                $nestedParams = explode('@type', $nestedParamString);
                $nestedParamString = trim(array_shift($nestedParams));
                $nestedParamsArray = $this->buildNestedParams($nestedParams, $param);

                $descriptionString = $this->buildDescription($param->getDocBlock(), $nestedParamString, $param);
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

            $types = new Collection(
                array($type),
                $origParam->getDocBlock() ? $origParam->getDocBlock()->getContext() : null
            );

            $paramsArray[] = [
                'name' => substr($origParam->getVariableName(), 1) . '.' . $name,
                'description' => $this->buildDescription($origParam->getDocBlock(), $description, $origParam),
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

        return $description[0] === '{';
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

    private function buildReturns($returns, $className = null)
    {
        if (count($returns) === 0) {
            return $returns;
        }

        $returnsArray = [];

        foreach ($returns as $return) {
            $context = $return->getDocBlock()->getContext();

            $returnsArray[] = [
                'types' => $this->handleTypes(
                    $return->getTypes(),
                    $context,
                    $className
                ),
                'description' => $this->buildDescription(null, $return->getDescription(), $return)
            ];
        }

        return $returnsArray;
    }

    private function handleTypes($types, $context = null, $className = null)
    {
        $res = [];
        foreach ($types as $type) {
            $matches = [];

            if (preg_match('/\\\\?(.*?)\<(.*?)\>/', $type, $matches)) {
                $aliases = $context
                    ? $context->getNamespaceAliases()
                    : [];
                $namespace = $context
                    ? $context->getNamespace()
                    : null;
                $matches[1] = $this->buildReference(
                    $this->resolveTypeAlias($matches[1], $aliases, $namespace)
                );
                $matches[2] = $this->buildReference(
                    $this->resolveTypeAlias($matches[2], $aliases, $namespace)
                );

                $type = sprintf(htmlentities('%s<%s>'), $matches[1], $matches[2]);
            } elseif ($type === '$this') {
                $type = $this->buildReference($className);
            } else {
                $type = $this->buildReference($type);
            }

            $res[] = $type;
        }

        return $res;
    }

    private function resolveTypeAlias($type, array $aliases, $namespace = null)
    {
        $pieces = explode('\\', $type);
        $basename = array_pop($pieces);
        if (array_key_exists($basename, $aliases)) {
            $type = $aliases[$basename];
        } elseif (count(explode('\\', $type)) === 1) {
            if (class_exists($namespace .'\\'. $type)) {
                $type = $namespace .'\\'. $type;
            }
        }

        return $type;
    }

    private function hasInternalType($type)
    {
        $type = trim($type, '\\');

        if (substr_compare($type, 'Google\\Cloud', 0, 12) === 0) {
            $ref = $this->getReflectionClass($type);

            $vendorPath = $this->projectRoot . 'vendor';
            if (substr($ref->getFileName(), 0, strlen($vendorPath)) === $vendorPath) {
                return false;
            }

            return true;
        }

        return false;
    }

    private function hasExternalType($type)
    {
        $type = trim($type, '\\');
        $types = array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        });

        return count($types) !== 0;
    }

    private function buildExternalLink($type)
    {
        $type = trim($type, '\\');
        $types = array_values(array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        }));

        $external = $types[0];
        $href = sprintf(
            $external['uri'],
            str_replace(
                $external['name'],
                '',
                str_replace('[]', '', $type)
            )
        );
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $href,
            $type
        );
    }

    private function buildInternalLink($content)
    {
        $componentId = null;
        $ref = $this->getReflectionClass($content);
        $fileName = $ref->getFileName();

        if ($this->isComponent) {
            $composer = $this->getComponentComposerFile($fileName);
            $componentId = $composer['extra']['component']['id'];
        }

        $content = trim($content, '\\');
        $parts = explode('::', $content);
        $type = $this->fileNameToType($fileName);

        if ($componentId) {
            $version = ($this->release)
                ? $this->getComponentVersion($this->manifestPath, $componentId)
                : 'master';

            $type = $componentId .'/'. $version .'/'. $type;
        }

        $openTag = "<a data-custom-type=\"$type\"";

        if (isset($parts[1])) {
            $method = str_replace('()', '', $parts[1]);
            $openTag .= " data-method=\"$method\">";
        } else {
            $openTag .= '>';
        }

        return "$openTag$content</a>";
    }

    private function getComponentComposerFile($fileName)
    {
        $originalFileName = $fileName;
        $recurse = true;

        do {
            $composer = dirname($fileName) .'/composer.json';
            if (file_exists($composer)) {
                if (isset(self::$composerFiles[$composer])) {
                    return self::$composerFiles[$composer];
                }

                $contents = json_decode(file_get_contents($composer), true);

                if (isset($contents['extra']['component'])) {
                    self::$composerFiles[$composer] = $contents;
                    return $contents;
                }

                $recurse = false;
            } elseif (trim($fileName, '/') === trim($this->projectRoot, '/')) {
                $recurse = false;
            } else {
                $fileName = dirname($fileName);
            }
        } while($recurse);

        throw new \Exception(sprintf(
            'Unable to find composer file for %s',
            $originalFileName
        ));
    }

    private function fileNameToType($fileName)
    {
        return str_replace('src/', '', substr(
            strtolower($fileName),
            strlen($this->projectRoot) + 1,
            -4
        ));
    }

    private function splitDescription($description)
    {
        $examples = null;
        $parts = [];

        if (strpos($description, 'Example:' . PHP_EOL . '```') !== false) {
            $parts = explode('Example:' . PHP_EOL, $description);
            $examples = $parts[1];
        }

        return [
            'description' => $parts[0],
            'examples' => $examples
        ];
    }

    private function getSource($path)
    {
        $filePieces = explode('/', $path);

        $srcIdx = [];
        array_walk($filePieces, function ($piece, $i) use (&$srcIdx) {
            if ($piece === 'src') {
                $srcIdx[] = $i;
            }
        });

        // Just in case you're running inside a different src directory...
        $realSrcIndex = end($srcIdx);

        $base = $realSrcIndex - 1;

        return implode('/', array_slice($filePieces, $base));
    }

    private function getReflectionClass($type)
    {
        try {
            $matches = [];
            preg_match(self::CLASS_TYPE_REGEX, $type, $matches);
            return new \ReflectionClass($matches[1]);
        } catch (\ReflectionException $e) {
            throw new \Exception(sprintf(
                'Reflection Exception: %s in %s. Given class was %s',
                $e->getMessage(),
                realpath($this->path),
                $type
            ));
        }
    }
}
