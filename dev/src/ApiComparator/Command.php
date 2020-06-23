<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Dev\ApiComparator;

use Gitonomy\Git\Diff\File;
use Gitonomy\Git\Repository;
use Google\Cloud\Dev\Command\GoogleCloudCommand;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitorAbstract;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Detect backwards-incompatible changes in php class signatures.
 */
class Command extends GoogleCloudCommand
{
    private $parser;

    protected function configure()
    {
        $this->setName('comparator')
            ->setDescription('Test the current git ref against master for backwards-compatibility breaks.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->parser = new \PhpParser\Parser(new \PhpParser\Lexer);

        $repo = new Repository($this->rootPath);
        $commit = $repo->getHeadCommit();
        $rev = $commit->getRevision();

        $diff = $repo->getDiff('master..' . $rev);
        $files = array_filter($diff->getFiles(), function ($file) {
            return $file->getOldName() === $file->getNewName() && strpos($file->getNewName(), '.php') !== false;
        });

        if (empty($files)) {
            return;
        }

        $passed = true;
        $results = [];
        foreach ($files as $file) {
            $result = new FileResult($file->getNewName());
            $result->setResults($this->compareFile($file));

            if ($passed) {
                $passed = $result->passed();
            }

            $results[] = $result;
        }

        if (!$passed) {
            $output->writeln("<error>Backwards-incompatible changes found!</error>");
            foreach ($results as $result) {
                if ($result->passed()) {
                    continue;
                }
                $output->writeln($result->toString());
            }

            return 1;
        }

        return 0;
    }

    private function compareFile(File $file)
    {
        $oldContent = $file->getOldBlob()->getContent();
        $newContent = $file->getNewBlob()->getContent();

        $oldContentMethods = $this->getClassMethods($this->parser->parse($oldContent));
        $newContentMethods = $this->getClassMethods($this->parser->parse($newContent));

        $results = [];
        foreach ($oldContentMethods as $method) {
            $result = $this->compareMethod($file->getNewName(), $method, $newContentMethods);
            if ($result) {
                $results[] = $result;
            }
        }

        return $results;
    }

    private function getClassMethods(array $nodes)
    {
        $traverser = new NodeTraverser;
        $methodFindingTraverser = new class extends NodeVisitorAbstract {
            public $methods = [];

            function enterNode(Node $node) {
                if ($node instanceof ClassMethod) {
                    $this->methods[] = $node;
                    return NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
            }
        };
        $traverser->addVisitor($methodFindingTraverser);
        $traverser->addVisitor(new NameResolver());

        $traverser->traverse($nodes);

        return $methodFindingTraverser->methods;
    }

    private function compareMethod($file, ClassMethod $method, array $newMethods)
    {
        $name = $method->name;

        $newMethodMatches = array_filter($newMethods, function (ClassMethod $newMethod) use ($name) {
            return $name === $newMethod->name;
        });

        if (!$newMethodMatches) {
            return sprintf(
                "Method %s was removed from file %s",
                $name,
                $file
            );
        }

        $newMethod = current($newMethodMatches);
        if ($method->isPublic() && !$newMethod->isPublic()) {
            return sprintf(
                "Method %s in file %s is no longer public",
                $name,
                $file
            );
        }

        return $this->compareMethodParams($file, $method, $newMethod);
    }

    private function compareMethodParams($file, ClassMethod $method, ClassMethod $newMethod)
    {
        $methodArgs = $method->getParams();
        $newMethodArgs = $newMethod->getParams();

        if (count($methodArgs) > count($newMethodArgs)) {
            return sprintf(
                "Argument(s) removed from method %s in file %s",
                $method->name,
                $file
            );
        }

        foreach ($methodArgs as $i => $arg) {
            $newMethodArg = $newMethodArgs[$i];

            $oldType = $arg->type;
            $newType = $newMethodArg->type;
            if ($newType !== null) {
                if ($oldType === null) {
                    return sprintf(
                        "Argument %s in method %s in file %s has restricted its type.",
                        $arg->name,
                        $method->name,
                        $file
                    );
                }

                if ($newType instanceof FullyQualified) {
                    if (!($oldType instanceof FullyQualified)) {
                        return sprintf(
                            "Argument %s in method %s in file %s has changed type",
                            $arg->name,
                            $method->name,
                            $file
                        );
                    }

                    if (!is_a($oldType->toString(), $newType->toString())) {
                        return sprintf(
                            "Argument %s in method %s in file %s has restricted its type",
                            $arg->name,
                            $method->name,
                            $file
                        );
                    }
                }

                if (is_string($newType) && $newType !== $oldType) {
                    return sprintf(
                        "Argument %s in method %s in file %s has changed type",
                        $arg->name,
                        $method->name,
                        $file
                    );
                }
            }
        }
    }
}
