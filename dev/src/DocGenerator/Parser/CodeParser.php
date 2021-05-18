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

use Google\Cloud\Dev\DocGenerator\ReflectorRegister;
use Google\Cloud\Dev\GetComponentsTrait;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\Element;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Php\Class_;
use phpDocumentor\Reflection\Php\File;
use phpDocumentor\Reflection\Php\Interface_;
use phpDocumentor\Reflection\Php\Method;
use phpDocumentor\Reflection\Php\Project;
use phpDocumentor\Reflection\Php\Trait_;
use phpDocumentor\Reflection\Php\Visibility;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\StandardTagFactory;
use phpDocumentor\Reflection\FqsenResolver;
use Rize\UriTemplate;
use Symfony\Component\Console\Output\OutputInterface;

class CodeParser implements ParserInterface
{
    use GetComponentsTrait;

    const CLASS_TYPE_REGEX = '/[Generator\<]?(Google\\\Cloud\\\[\w\\\]{0,})[\>]?[\[\]]?/';
    const SNIPPET_NAME_REGEX = '/\/\/\s?\[snippet\=(\w{0,})\]/';

    private static $composerFiles = [];
    private static $lockFile;

    private $file;
    private $register;
    private $markdown;
    private $projectRoot;
    private $externalTypes;
    private $componentId;
    private $manifestPath;
    private $release;
    private $isComponent;
    private $typeResolver;
    private $descriptionFactory;

    public function __construct(
        File $file,
        ReflectorRegister $register,
        DocBlock\DescriptionFactory $descriptionFactory,
        $projectRoot,
        $componentId,
        $manifestPath,
        $release,
        OutputInterface $output,
        $id,
        $isComponent = true
    ) {
        $this->file = $file;
        $this->register = $register;
        $this->markdown = \Parsedown::instance();
        $this->projectRoot = $projectRoot;
        $this->externalTypes = include $this->projectRoot . '/docs/external-classes.php';
        $this->componentId = $componentId;
        $this->manifestPath = $manifestPath;
        $this->release = $release;
        $this->output = $output;
        $this->id = $id;
        $this->isComponent = $isComponent;
        $this->descriptionFactory = $descriptionFactory;
        $this->typeResolver = new TypeResolver();

        if (!$this->externalTypes) {
            throw new \RuntimeException('Error in external types.');
        }
    }

    public function parse(): ?array
    {
        if (!$element = $this->register->getElementFromFile($this->file)) {
            return null;
        }

        return $this->buildDocument($element);
    }

    private function buildDocument(Element $element): array
    {
        if (!$docBlock = $element->getDocBlock()) {
            throw new \LogicException(sprintf(
                'No description (%s)',
                $this->file->getPath()
            ));
        }

        $fullName = (string) $element->getFqsen();
        $magic = $this->buildMagicMethods(
            $docBlock->getTagsByName('method'),
            $fullName
        );

        $description = $this->descriptionFactory->create(
            $docBlock->getSummary() . "\n\n" . $docBlock->getDescription(),
            $docBlock->getContext()
        );

        $split = $this->splitDescription($description);

        $classInfo = $element instanceof Interface_
            ? $this->buildInterfaceInfo($element)
            : $this->buildClassInfo($element);

        $methods = $element instanceof Interface_
            ? $this->buildMethods($classInfo['interfaceMethods'], $fullName)
            : $this->buildMethods($classInfo['methods'], $fullName, $classInfo['isProto']);

        $descriptionString = $element instanceof Interface_
            ? $this->buildInterfaceDescription($classInfo, $description, $split['description'], $element)
            : $this->buildClassDescription($classInfo, $description, $split['description'], $element);

        return [
            'id' => $this->id,
            'type' => '', // For now
            'title' => ltrim($fullName, '\\'),
            'name' => $element->getName(),
            'description' => $descriptionString,
            'examples' => $this->buildExamples($split['examples'], $description, $element),
            'resources' => $this->buildResources($docBlock->getTagsByName('see')),
            'methods' => array_merge($methods, $magic)
        ];
    }

    private function buildClassInfo(
        Element $element,
        array $classInfo = null
    ): array {
        if (is_null($classInfo)) {
            $classInfo = [
                'methods' => [],
                'traits' => [],
                'parents' => [],
                'interfaces' => [],
                'interfaceMethods' => [],
                'isProto' => false
            ];
        }
        $fullName = (string) $element->getFqsen();

        // START proto nested arg missing description workaround
        if (preg_match('/\\V\d{0,}/', $fullName) === 1) {
            $content = $this->file->getSource();
            $lines = explode(PHP_EOL, $content);
            foreach ($lines as $line) {
                if (strpos(trim($line), 'namespace') !== false) {
                    break;
                }

                if (strpos($line, '# Generated by the protocol buffer compiler.  DO NOT EDIT!') !== false) {
                    $classInfo['isProto'] = true;
                    break;
                }
            }
        }
        // END proto nested arg missing description workaround

        $methods = $this->buildMethodInfo($element);

        $isInternal = substr_compare($fullName, '\Google\Cloud', 0, 13) === 0;
        if ($isInternal) {
            $classInfo['methods'] += $methods;
        }

        foreach ($element->getUsedTraits() as $fqsen) {
            if ($trait = $this->register->getElementFromFqsen($fqsen)) {
                $classInfo = $this->buildClassInfo($trait, $classInfo);
            }
        }

        if (!$element instanceof Trait_) {
            foreach ($element->getInterfaces() as $fqsen) {
                if ($interface = $this->register->getElementFromFqsen($fqsen)) {
                    $classInfo = $this->buildInterfaceInfo($interface, $classInfo);
                }
            }

            if ($fqsen = $element->getParent()) {
                if ($parent = $this->register->getElementFromFqsen($fqsen)) {
                    $classInfo = $this->buildClassInfo($parent, $classInfo);
                }
                // Add $parent to array after calling getMethods so that
                // parents are correctly ordered
                $classInfo['parents'][] = $fqsen;
            }
        }

        return $classInfo;
    }

    private function buildInterfaceInfo(Interface_ $interface, array $classInfo = null)
    {
        if (is_null($classInfo)) {
            $classInfo = [
                'interfaces' => [],
                'interfaceMethods' => [],
            ];
        }
        $context = $interface->getDocBlock()->getContext();
        $fullName = (string) $interface->getFqsen();
        $isInternal = substr_compare($fullName, '\Google\Cloud', 0, 13) === 0;
        if ($isInternal) {
            $classInfo['interfaceMethods'] += $this->buildMethodInfo($interface);
        }

        // Add parent interfaces to array before calling getMethods to use PHP array
        // ordering, so that parent interfaces are before more deeply nested interfaces
        $classInfo['interfaces'] += $interface->getParents();
        foreach ($interface->getParents() as $parent) {
            if ($interface = $this->register->getElementFromFqsen($parent)) {
                $classInfo = $this->buildInterfaceInfo($interface, $classInfo);
            }
        }

        return $classInfo;
    }

    private function buildMethodInfo(Element $element): array
    {
        $methods = [];

        $file = $this->register->getFileFromFqsen($element->getFqsen());
        foreach ($element->getMethods() as $fqsen => $method) {
            if ((string) $method->getVisibility() !== Visibility::PUBLIC_) {
                continue;
            }

            list($className, $methodName) = explode('::', $fqsen);

            $methods[$methodName] = [
                'method' => $method,
                'source' => $file->getPath(),
                'container' => (string) $element->getFqsen(),
            ];
        }
        return $methods;
    }

    private function buildClassDescription(
        array $classInfo,
        Description $description,
        string $content = null,
        Element $element = null
    ): string {
        $content = $this->buildDescriptionContent($description, $content, $element);
        $content .= $this->buildInheritDoc($classInfo);
        return $this->markdown->parse($content);
    }

    private function buildInterfaceDescription(
        $classInfo,
        Description $description,
        string $content = null,
        Element $element = null
    ): string {
        $content = $this->buildDescriptionContent($description, $content, $element);
        $content .= $this->buildInterfaceInheritDoc($classInfo);
        return $this->markdown->parse($content);
    }

    private function buildDescription(
        Description $description,
        string $content = null,
        Element $element = null
    ): string {
        return $this->markdown->parse(
            $this->buildDescriptionContent(
                $description,
                $content,
                $element
            )
        );
    }

    private function buildDescriptionContent(
        Description $description,
        string $content = null,
        Element $element = null
    ): string {
        if (is_null($content)) {
            $content = (string) $description->getBodyTemplate();
        }

        // Replace references with links in the tag contents
        if ($tags = $description->getTags()) {
            $tagContent = [];
            // convert inline {@see} tag to custom type link
            foreach ($tags as $tag) {
                if ($tag instanceof Tags\See) {
                    $reference = (string) $tag->getReference();
                    // @TODO: These references do not resolve their Fqsen's properly,
                    // presumably from a bug in the previous version. This code hacks a fix
                    // for that issue, but we should fix the references in the generated
                    // clients and remove this hack.
                    try {
                        $tagContent[] = $this->buildReference($reference);
                    } catch (\LogicException $e) {
                        if ($element) {
                            // Use namespace of element when possible, in case
                            // the namespace of a trait and class are different
                            $parts = explode('\\', $element->getFqsen());
                            $namespace = implode('\\', array_slice($parts, 0, -1));
                        } else {
                            $namespace = (string) array_shift($this->file->getNamespaces());
                        }
                        if (0 !== strpos($reference, $namespace)) {
                            throw $e;
                        }
                        $reference = substr($reference, strlen($namespace));
                        $tagContent[] = $this->buildReference($reference);
                        printf('Manual fix applied (%s). Please fix the reference' . PHP_EOL, $reference);
                    }
                } elseif (strtolower($tag->getName()) === 'inheritdoc') {
                    if ($element === null) {
                        throw new \Exception(sprintf(
                            "Inherit Doc tag ({@inheritdoc}) is only supported when \$element is not null." .
                            "\nContext:\n%s",
                            $content
                        ));
                    }

                    if (!($element instanceof Class_)) {
                        throw new \Exception(sprintf(
                            "Inherit Doc tag ({@inheritdoc}) is not supported for reflector type %s (found in: %s)." .
                            "\nContext:\n%s",
                            get_class($element),
                            $element->getName(),
                            $content
                        ));
                    }

                    if (!$parent = $element->getParent()) {
                        throw new \Exception(sprintf(
                            '%s has {@inheritdoc} tag but no parent class',
                            $element->getName()
                        ));
                    }
                    $parentElement = $this->register->getElementFromFqsen($parent);

                    $parentDoc =  $parentElement->getDocBlock();
                    $parentDocSplit = $this->splitDescription($parentDoc->getDescription());

                    $description = $this->descriptionFactory->create(
                        $parentDoc->getSummary() . "\n\n" . $parentDoc->getDescription(),
                        $parentDoc->getContext()
                    );
                    $tagContent[] = $this->buildDescriptionContent(
                        $description,
                        null,
                        $parentElement
                    );
                } else {
                    $tagContent[] = (string) $tag;
                }
            }

            $content = vsprintf($content, $tagContent);
        }

        // @TODO: Hack to fix the tokenization of "%"
        // @see https://github.com/phpDocumentor/ReflectionDocBlock/issues/274
        $content = str_replace('%%', '%', $content);

        return str_ireplace('[optional]', '', $content);
    }

    private function buildMethods(
        array $methods,
        string $className,
        bool $isProto = false
    ): array {
        $methodArray = [];
        foreach ($methods as $name => $methodInfo) {
            $method = $methodInfo['method'];

            if ((string) $method->getVisibility() !== Visibility::PUBLIC_) {
                continue;
            }

            $docBlock = $method->getDocBlock();
            if (is_null($docBlock)) {
                if (!$isProto && $name === '__construct') {
                    $this->output->writeln(sprintf('%s::%s has no description', $className, $name));
                }
                continue;
            }

            $access = $docBlock->getTagsByName('access');

            if (!empty($access)) {
                if ((string) $access[0]->getDescription() === 'private') {
                    continue;
                }
            }

            $methodArray[] = $this->buildMethod($method, $methodInfo, $className, $isProto);
        }

        return $methodArray;
    }

    private function buildMethod(
        Method $method,
        array $methodInfo,
        string $className,
        bool $isProto = false
    ): array {
        $docBlock = $method->getDocBlock();
        $resources = $docBlock->getTagsByName('see');
        $params = $docBlock->getTagsByName('param');
        $exceptions = $docBlock->getTagsByName('throws');
        $returns = $docBlock->getTagsByName('return');

        // Combine summary and description so first line tags can be parsed.
        $description = $this->descriptionFactory->create(
            $docBlock->getSummary() . "\n\n" . $docBlock->getDescription(),
            $docBlock->getContext()
        );
        $split = $this->splitDescription($description);

        $descriptionString = $this->buildDescription(
            $description,
            $split['description'],
            $method
        );

        if ($methodInfo['container'] !== $className) {
            $descriptionString .= sprintf(
                "\n\nImplemented in %s",
                $this->buildReference($methodInfo['container'])
            );
        }

        $source = sprintf(
            '%s#L%d',
            $this->getSource($methodInfo['source']),
            $method->getLocation()->getLineNumber()
        );

        return [
            'id' => $method->getName(),
            'type' => $method->getName() === '__construct' ? 'constructor' : 'instance',
            'name' => $method->getName(),
            'source' => $source,
            'description' => $descriptionString,
            'examples' => $this->buildExamples($split['examples'], $description, $method),
            'resources' => $this->buildResources($resources),
            'params' => $this->buildParams($params, $descriptionString, $isProto, $method),
            'exceptions' => $this->buildExceptions($exceptions),
            'returns' => $this->buildReturns($returns, $className)
        ];
    }

    private function buildMagicMethods(
        array $magicMethods,
        string $className
    ): array {
        $methodArray = [];
        foreach ($magicMethods as $method) {
            if (!$description = $method->getDescription()) {
                throw new \Exception(sprintf(
                    '%s::%s (magic method) has no description',
                    $className,
                    $method->getMethodName()
                ));
            }

            $methodArray[] = $this->buildMagicMethod($method, $className);
        }

        return $methodArray;
    }

    private function buildMagicMethod(Tags\Method $magicMethod): array
    {
        $desc = trim((string) $magicMethod->getDescription(), '{}');
        $docBlock = DocBlockFactory::createInstance()->create($desc);
        $resources = $docBlock->getTagsByName('see');
        $params = $docBlock->getTagsByName('param');
        $exceptions = $docBlock->getTagsByName('throws');
        $returns = $docBlock->getTagsByName('return');

        // Combine summary and description so first line tags can be parsed.
        $description = $this->descriptionFactory->create(
            $docBlock->getSummary() . "\n\n" . $docBlock->getDescription(),
            $docBlock->getContext()
        );
        $split = $this->splitDescription($description);
        $examples = $this->fixMagicMethodExamplesWhitespace($split['examples'], $desc);

        return [
            'id' => $magicMethod->getMethodName(),
            'type' => $magicMethod->getMethodName() === '__construct' ? 'constructor' : 'instance',
            'name' => $magicMethod->getMethodName(),
            'source' => $this->getSource($this->file->getPath()),
            'description' => $this->buildDescription($docBlock->getDescription(), $split['description']),
            'examples' => $this->buildExamples($examples, $description),
            'resources' => $this->buildResources($resources),
            'params' => $this->buildParams($params),
            'exceptions' => $this->buildExceptions($exceptions),
            'returns' => $this->buildReturns($returns),
        ];
    }

    /**
     * Function to fix whitespace in the code samples for magic methods, which
     * gets trimmed from the snippets by phpdocumentor.
     */
    private function fixMagicMethodExamplesWhitespace(string $examples, string $rawDesc)
    {
        $rawDescTrimmed = join("\n", array_map(function (string $s) {
            if (0 === strpos($s, '    ')) {
                return substr($s, 4);
            }
            return ltrim('    ', $s);
        }, explode("\n", $rawDesc)));

        $codeSnipFunc = function ($description) {
            if ($false === $start = strpos($description, '```')) {
                throw new \LogicException('No snippet found');
            }
            $end = strpos($description, '```', $start + 3);
            return substr($description, $start, $end - $start + 3);
        };

        return str_replace(
            $codeSnipFunc($examples),
            $codeSnipFunc($rawDescTrimmed),
            $examples
        );
    }

    private function buildExamples(string $examples, Description $description = null, Element $element = null): array
    {
        $examplesArray = [];
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
                'caption' => $this->buildDescriptionContent($description, $caption, $element),
                'code' => trim(implode(PHP_EOL, $lines))
            ];
        }

        return $examplesArray;
    }

    private function buildResources(array $resources): array
    {
        $resourcesArray = [];
        foreach ($resources as $resource) {
            $resourcesArray[] = [
                'title' => (string) $resource->getDescription(),
                'link' => (string) $resource->getReference()
            ];
        }

        return $resourcesArray;
    }

    private function buildParams(
        array $params,
        string $methodDescription = null,
        bool $isProto = false,
        ?Element $element = null
    ): array {
        if (count($params) === 0) {
            return $params;
        }

        $paramsArray = [];

        foreach ($params as $param) {
            $description = $param->getDescription();
            $descriptionString = $this->buildDescription($description, null, $element);

            $nestedParamsArray = [];

            // To handle generated protobuf files
            if (empty($descriptionString) && $methodDescription) {
                $pos = strpos($methodDescription, '<p>Generated from protobuf field');
                if ($pos) {
                    $descriptionString = substr($methodDescription, 0, $pos);
                }
            }

            if ($param->getType() instanceof Types\Array_
                && $this->hasNestedParams($description)
            ) {
                $nestedParamString = trim(str_replace('[optional]', '', $description->getBodyTemplate()));
                $nestedParamString = substr($nestedParamString, 1, -1);
                $nestedParams = explode('@type', $nestedParamString);

                // Remove the first, since that's the wrapping array param,
                // and use it for the wrapping param description
                $paramContent = trim(array_shift($nestedParams));
                $descriptionString = $this->buildDescription(
                    $param->getDescription(),
                    $paramContent,
                    $element
                );

                // Create an array containing the rest of the parameter options
                $nestedParamsArray = $this->buildNestedParams(
                    $nestedParams,
                    $param,
                    $isProto,
                    $element
                );
            }

            if (!$varName = $param->getVariableName()) {
                throw new \Exception(sprintf(
                    'invalid or missing parameter name in "%s"',
                    $param->getDocBlock()->getShortDescription()
                ));
            }
            $type = $param->getType();
            $paramsArray[] = [
                'name' => $varName,
                'description' => $descriptionString,
                'types' => $type ? $this->handleTypes($type) : [],
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
    private function buildNestedParams(
        array $nestedParams,
        Tag $origParam,
        bool $isProto = false,
        ?Element $element = null
    ): array {
        $paramsArray = [];

        foreach ($nestedParams as $param) {
            $nestedParam = explode(' ', trim($param), 3);

            // START proto nested arg missing description workaround
            if (count($nestedParam) < 3 && !$isProto) {
                $this->output->writeln('nested param is in an invalid format: '. $param);
            }
            // END proto nested arg missing description workaround

            list($type, $name, $content) = $nestedParam;
            $name = substr($name, 1); // remove "$" from parameter name
            $content = preg_replace('/\s+/', ' ', $content);
            $description = $origParam->getDescription();

            // @TODO: Types are lost in some cases where the parameter names for
            // nested params are not fully-qualified. This code tries to manually
            // regain the context to resolve the type names
            $context = $element
                ? $this->register->getContextFromFqsen($element->getFqsen())
                : null;

            $paramsArray[] = [
                'name' => $origParam->getVariableName() . '.' . $name,
                'description' => $this->buildDescription($description, $content, $element),
                'types' => $this->handleTypes($this->typeResolver->resolve($type, $context)),
                'optional' => null, // @todo
                'nullable' => null //@todo
            ];
        }

        return $paramsArray;
    }

    private function hasNestedParams(string $description): bool
    {
        $description = trim(str_replace('[optional]', '', $description));

        if (strlen($description) === 0) {
            return false;
        }

        return $description[0] === '{';
    }

    private function buildExceptions(array $exceptions): array
    {
        $exceptionsArray = [];
        foreach ($exceptions as $exception) {
            $exceptionsArray[] = [
                'type' => (string) $exception->getType(),
                'description' => $this->buildDescriptionContent($exception->getDescription())
            ];
        }

        return $exceptionsArray;
    }

    private function buildReturns(array $returns, string $className = null): array
    {
        if (count($returns) === 0) {
            return $returns;
        }

        $returnsArray = [];

        foreach ($returns as $return) {
            $returnsArray[] = [
                'types' => $this->handleTypes(
                    $return->getType(),
                    $className
                ),
                'description' => $this->buildDescription($return->getDescription(), null)
            ];
        }

        return $returnsArray;
    }

    private function handleTypes(
        Type $type,
        string $className = null
    ): array {

        if ($type instanceof Types\Collection) {
            $typeRef = sprintf(
                htmlentities('%s<%s>'),
                $this->buildReference((string) $type->getFqsen()),
                $this->buildReference((string) $type->getValueType())
            );
            return [$typeRef];
        }

        if ($type instanceof Types\This) {
            $typeRef = $this->buildReference($className);
            return [$typeRef];
        }

        if ($type instanceof Types\AggregatedType) {
            $typeRefs = [];
            foreach ($type as $aggregatedType) {
                $typeRefs[] = $this->buildReference((string) $aggregatedType);
            }
            return $typeRefs;
        }

        $typeRef = $this->buildReference((string) $type);

        return [$typeRef];
    }

    private function buildReference(string $type): string
    {
        if ($this->hasInternalType($type)) {
            return $this->buildInternalLink($type);
        }

        if ($this->hasExternalType($type)) {
            return $this->buildExternalLink($type);
        }

        return $type;
    }

    private function hasInternalType(string $fqsen): bool
    {
        if (substr_compare($fqsen, '\\Google\\Cloud', 0, 12) === 0) {
            $file = $this->register->getFileFromFqsen(new Fqsen(rtrim($fqsen, '[]')));

            $vendorPath = $this->projectRoot . 'vendor';
            if (substr($file->getPath(), 0, strlen($vendorPath)) === $vendorPath) {
                return false;
            }

            return true;
        }

        return false;
    }

    private function buildInternalLink(string $typeName): string
    {
        $fqsen = new Fqsen(rtrim($typeName, '[]'));
        $componentId = null;
        $file = $this->register->getFileFromFqsen($fqsen);
        $fileName = $file->getPath();

        if ($this->isComponent) {
            $composer = $this->getComponentComposerFile($fileName);
            $componentId = $composer['extra']['component']['id'];
        }

        $type = $this->fileNameToType($fileName);

        if ($componentId) {
            $version = ($this->release)
                ? $this->getComponentVersion($this->manifestPath, $componentId)
                : 'master';

            $type = $componentId .'/'. $version .'/'. $type;
        }

        $openTag = "<a data-custom-type=\"$type\"";

        $parts = explode('::', $typeName);
        if (isset($parts[1])) {
            $method = str_replace('()', '', $parts[1]);
            $openTag .= " data-method=\"$method\">";
        } else {
            $openTag .= '>';
        }

        return sprintf('%s%s</a>', $openTag, trim($typeName, '\\'));
    }

    private function hasExternalType(string $fqsen): bool
    {
        $type = trim($fqsen, '\\');
        $types = array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        });

        return count($types) !== 0;
    }

    private function buildExternalLink(string $type): string
    {
        $type = trim($type, '\\');
        $types = array_values(array_filter($this->externalTypes, function ($external) use ($type) {
            return (strpos($type, $external['name']) !== false);
        }));

        $external = $types[0];

        $name = $type;
        if (strpos('\\', $type) !== false) {
            $type = str_replace(
                $external['name'],
                '',
                str_replace('[]', '', $type)
            );
        }

        $type = str_replace('\\', '/', $type);

        $placeholders = [];

        if (isset($external['depName'])) {
            list (
                $type,
                $placeholders['depVersion']
             ) = $this->getExternalDepVersion($type, $external);
        }

        // strip method reference from external type, since we can't predict
        // with certainty how method anchors work.
        $type = explode('::', $type)[0];

        $placeholders['type'] = explode('/', $type);

        $uri = new UriTemplate;
        $href = $uri->expand($external['uri'], $placeholders);

        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $href,
            $name
        );
    }

    private function getExternalDepVersion(string $type, array $external): array
    {
        $depName = $external['depName'];

        $lockFilePath = $this->projectRoot . '/composer.lock';
        if (!self::$lockFile && file_exists($lockFilePath)) {
            self::$lockFile = json_decode(file_get_contents($lockFilePath), true)['packages'];
        } elseif (!file_exists($lockFilePath)) {
            throw new \RuntimeException('composer.lock file does not exist. Run `composer install` first.');
        }

        $dep = array_values(array_filter(self::$lockFile, function ($package) use ($depName) {
            return $package['name'] === $depName;
        }));

        if (!$dep) {
            throw new \RuntimeException(sprintf(
                'Could not find installed package %s. Check `docs/external-classes.json` to verify.',
                $depName
            ));
        }

        if (isset($external['strip']) && $external['strip']) {
            $type = str_replace(
                str_replace('\\', '/', $external['name']),
                '',
                $type
            );
        }

        return [
            $type,
            $dep[0]['version']
        ];
    }

    private function buildInheritDoc($classInfo): string
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

    private function buildInterfaceInheritDoc(array $classInfo): string
    {
        $content = '';
        if (count($classInfo['interfaces']) > 0) {
            $content .= $this->implodeInheritDocLinks(", ", $classInfo['interfaces'], "Extends");
        }

        return $content;
    }

    private function implodeInheritDocLinks(
        string $glue,
        array $pieces,
        string $prefix
    ): string {
        return "\n\n$prefix " . implode($glue, array_map([$this, 'buildReference'], $pieces));
    }

    private function getComponentComposerFile(string $fileName): array
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
        } while ($recurse);

        throw new \Exception(sprintf(
            'Unable to find composer file for %s',
            $originalFileName
        ));
    }

    private function fileNameToType(string $fileName): string
    {
        return str_replace('src/', '', substr(
            strtolower($fileName),
            strlen($this->projectRoot),
            -4
        ));
    }

    private function splitDescription(Description $description): array
    {
        $body = (string) $description->getBodyTemplate();

        if (strpos($body, 'Example:' . PHP_EOL . '```') !== false) {
            $parts = explode('Example:' . PHP_EOL, $body);
            return [
                'description' => $parts[0],
                'examples' => $parts[1],
            ];
        }

        return [
            'description' => $body,
            'examples' => '',
        ];
    }

    private function getSource(string $path): string
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
}
