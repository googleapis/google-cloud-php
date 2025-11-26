<?php
/**
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Testing\Reflection;

use Google\Cloud\Core\Testing\Reflection\DescriptionFactory as CoreDescriptionFactory;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\StandardTagFactory;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\File\LocalFile;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\NodeVisitor\ElementNameResolver;
use phpDocumentor\Reflection\Php\Factory;
use phpDocumentor\Reflection\Php\Factory\Noop;
use phpDocumentor\Reflection\Php\Factory\TraitUse;
use phpDocumentor\Reflection\Php\NodesFactory;
use phpDocumentor\Reflection\Php\ProjectFactory;
use phpDocumentor\Reflection\Php\ProjectFactoryStrategies;
use phpDocumentor\Reflection\TypeResolver;
use PhpParser\Lexer;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpParser\PhpVersion;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

/**
 * Class for running snippets using phpdocumentor/reflection:v5.
 *
 * @internal
 */
class ReflectionHandlerV6
{
    private $descriptionFactory;
    private $docBlockFactory;

    public function __construct()
    {
        $this->descriptionFactory = $this->createDescriptionFactory();
        $this->docBlockFactory = $this->createDocBlockFactory($this->descriptionFactory);
    }

    /**
     * @param string $class
     * @return DocBlock
     */
    public function createDocBlock($classOrMethod)
    {
        return $this->docBlockFactory->create($classOrMethod);
    }

    /**
     * @param DocBlock $docBlock
     * @return string
     */
    public function getDocBlockText(DocBlock $docBlock)
    {
        $description = $this->descriptionFactory->create(
            $docBlock->getSummary() . "\n\n" . $docBlock->getDescription(),
            $docBlock->getContext()
        );
        return $description->render();
    }

    /**
     * @param array $files
     * @return string[]
     */
    public function classes(array $files)
    {
        $projectFactory = $this->createProjectFactory();
        $localFiles = [];
        foreach ($files as $file) {
            $localFiles[] = new LocalFile($file);
        }
        $project = $projectFactory->create('My Project', $localFiles);
        $classes = [];
        foreach ($files as $file) {
            $classesInFile = $project->getFiles()[$file]->getClasses();
            foreach ($classesInFile as $class) {
                $classes[] = (string) $class->getFqsen();
            }
        }
        return $classes;
    }

    /**
     * @return ProjectFactory
     */
    public function createProjectFactory()
    {
        $phpVersion = PhpVersion::fromString('8.1');  // PHP 8.1.0
        $parser = (new ParserFactory())->createForVersion($phpVersion);
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new NameResolver());
        $nodeTraverser->addVisitor(new ElementNameResolver());
        $nodesFactory = new NodesFactory($parser, $nodeTraverser);

        $docblockFactory = $this->createDocBlockFactory($this->createDescriptionFactory());

        $methodStrategy =  new Factory\Method($docblockFactory);

        $strategies = new ProjectFactoryStrategies(
            [
                new Factory\Namespace_(),
                new Factory\Class_($docblockFactory),
                new Factory\Enum_($docblockFactory),
                new Factory\EnumCase($docblockFactory, new PrettyPrinter()),
                new Factory\Define($docblockFactory, new PrettyPrinter()),
                new Factory\GlobalConstant($docblockFactory, new PrettyPrinter()),
                new Factory\ClassConstant($docblockFactory, new PrettyPrinter()),
                new Factory\File($docblockFactory, $nodesFactory),
                new Factory\Function_($docblockFactory),
                new Factory\Interface_($docblockFactory),
                $methodStrategy,
                new Factory\Property($docblockFactory, new PrettyPrinter()),
                new Factory\Trait_($docblockFactory),
                new Factory\IfStatement(),
                new TraitUse(),
            ]
        );

        $strategies->addStrategy(
            new Factory\ConstructorPromotion($methodStrategy, $docblockFactory, new PrettyPrinter()),
            1100
        );
        $strategies->addStrategy(new Noop(), -PHP_INT_MAX);

        return new ProjectFactory($strategies);
    }

    /**
     * @return DescriptionFactory
     */
    public function createDescriptionFactory()
    {
        $fqsenResolver      = new FqsenResolver();
        $tagFactory         = new StandardTagFactory($fqsenResolver);
        $descriptionFactory = new CoreDescriptionFactory($tagFactory);

        $tagFactory->addService($descriptionFactory, DescriptionFactory::class);
        $tagFactory->addService(new TypeResolver($fqsenResolver));

        return $descriptionFactory;
    }

    /**
     * @return DocBlockFactory
     */
    private function createDocBlockFactory($descriptionFactory)
    {
        $tagFactory = $descriptionFactory->getTagFactory();
        return new DocBlockFactory($descriptionFactory, $tagFactory);
    }
}
