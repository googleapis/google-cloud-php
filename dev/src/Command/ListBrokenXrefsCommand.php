<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Dev\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Google\Cloud\Dev\Component;

/**
 * @internal
 */
class ListBrokenXrefsCommand extends Command
{
    const BROKEN_REFS_REGEX = '/\[(\w+)\] Broken xref in (.*): (.*)/';
    const MIN_REFS_PER_BUG = 5;
    const BUG_TEMPLATE=<<<EOF
    *** Bugspec go/bugged#bugspec
    *** Three asterisks at the beginning of a line indicate a comment.
    *** The first non-comment line is the bug title. The Bugspec parser requires a
    *** non-empty title, even for bug templates, which do not require titles.
    Fix broken proto references in %s
    *** Issue body

    The following proto files contain broken documentation references, and need to be fixed. Changes
    should be made in the `google3/` source protos. See the parent bug (b/360878680) for guidance.

    %s

    *** Metadata
    COMPONENT=1634818
    PARENT+=360878680
    TYPE=BUG
    STATUS=NEW
    PRIORITY=P2
    SEVERITY=S2
    HOTLIST+=6168811
    EOF;
    const BROKEN_REF_TEMPLATE=' - [%s](https://github.com/googleapis/googleapis/blob/%s/%s): `%s`';
    private $sha;
    private $refCount = 0;

    protected function configure()
    {
        $this->setName('list-broken-xrefs')
            ->setDescription('List all the broken xrefs in the documentation using ".kokoro/docs/publish.sh"')
            ->addOption('write-bugs', null, InputOption::VALUE_REQUIRED, 'write the bug to the given directory')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'List broken xrefs for a single component', [])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($bugDir = $input->getOption('write-bugs')) {
            $this->sha = $this->determineGoogleapisSha();
            if (!is_dir($bugDir)) {
                if (!mkdir($bugDir)) {
                    throw new RuntimeException('bug directory doesn\'t exist and cannot be created');
                }
            }
        }
        $brokenReferences = [];
        $fileCount = 0;
        foreach (Component::getComponents($input->getOption('component')) as $component) {
            $input = new ArrayInput($f = [
                'command' => 'docfx',
                '--component' => $component->getName(),
            ]);

            $buffer = new BufferedOutput(OutputInterface::VERBOSITY_DEBUG);
            $this->getApplication()->doRun($input, $buffer);
            $componentBrokenRefs = [];
            foreach (explode("\n", $buffer->fetch()) as $line) {
                if (preg_match(self::BROKEN_REFS_REGEX, $line, $matches)) {
                    list(, $componentName, $file, $brokenText) = $matches;
                    if (false === strpos($file, '#L')) {
                        // If there are no line numbers, assume this is a PHP bug, and skip it
                        continue;
                    }
                    if ($bugDir) {
                        $componentBrokenRefs[$file] = $brokenText;
                    } else {
                        $link = sprintf(
                            '"=HYPERLINK(""https://github.com/googleapis/googleapis/blob/master/%s"", ""%s"")"',
                            $file,
                            $file
                        );
                        $output->writeln(implode(',', [$componentName, $link, $brokenText]));
                    }
                }
            }
            if ($bugDir) {
                if (count($componentBrokenRefs) >= self::MIN_REFS_PER_BUG) {
                    $fileCount++;
                    $this->writeBuggerFile([$component->getName() => $componentBrokenRefs], $bugDir, $output);
                } else {
                    if (count($componentBrokenRefs) > 0) {
                        $brokenReferences[$component->getName()] = $componentBrokenRefs;
                    }
                    if (array_sum(array_map('count', $brokenReferences)) >= self::MIN_REFS_PER_BUG) {
                        $fileCount++;
                        $this->writeBuggerFile($brokenReferences, $bugDir, $output);
                        // reset broken references
                        $brokenReferences = [];
                    }
                }
            }
        }
        if ($bugDir && count($brokenReferences) > 0) {
            $fileCount++;
            $this->writeBuggerFile($brokenReferences, $bugDir, $output);
        }

        if ($bugDir) {
            $output->writeln(sprintf('Wrote %s files and found %s broken references', $fileCount, $this->refCount));
        }

        return 0;
    }

    private function writeBuggerFile(array $brokenReferences, string $bugDir, OutputInterface $output)
    {
        $components = array_keys($brokenReferences);
        if (strlen($componentNames = implode(', ', $components)) > 75) {
            $componentNames = trim(substr($componentNames, 0, 70)) . '...';
        }
        $references = array_merge(...array_values($brokenReferences));
        uksort($references, function ($a, $b) {
            [$fileA, $lineNumberA] = explode('#L', $a);
            [$fileB, $lineNumberB] = explode('#L', $b);
            if ($fileA === $fileB) {
                return (int) $lineNumberA <=> (int) $lineNumberB;
            }
            return $fileA <=> $fileB;
        });
        $lines = array_unique(array_map(
            fn ($file, $text) =>  sprintf(self::BROKEN_REF_TEMPLATE, $file, $this->sha, $file, $text),
            array_keys($references),
            $references
        ));

        $bugFile = sprintf('%s/broken-refs-%s.txt', $bugDir, implode('-', $components));
        $bugText = sprintf(self::BUG_TEMPLATE, $componentNames, implode("\n", $lines));
        file_put_contents($bugFile, $bugText);

        $output->writeln(sprintf('Wrote %s references to %s', count($lines), $bugFile));
        $this->refCount += count($lines);
    }

    private function determineGoogleapisSha(): string
    {
        $process = new Process(['git', 'rev-parse', 'HEAD'], realpath(__DIR__ . '/../../vendor/googleapis/googleapis'));
        $process->run();
        return trim($process->getOutput());
    }
}
