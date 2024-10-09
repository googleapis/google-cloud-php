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
    const BROKEN_REFS_REGEX = '/\[(\w+)\] Broken xref in (.*) \((.*)\): (.*)/';
    const MIN_REFS_PER_BUG = 10;
    const BUG_TEMPLATE=<<<EOF
    *** Bugspec go/bugged#bugspec
    *** Three asterisks at the beginning of a line indicate a comment.
    *** The first non-comment line is the bug title. The Bugspec parser requires a
    *** non-empty title, even for bug templates, which do not require titles.
    Broken References in Proto Comments for %s
    *** Issue body

    The following references are broken in the protobuf documentation, and need to be fixed:

    %s

    *** Metadata
    COMPONENT=1634818
    TYPE=BUG
    STATUS=NEW
    PRIORITY=P2
    SEVERITY=S2
    HOTLIST+=6168811
    EOF;
    const BROKEN_REF_TEMPLATE=' - [%s](https://github.com/googleapis/googleapis/blob/%s/%s): `%s`';
    private $sha;

    protected function configure()
    {
        $this->setName('list-broken-xrefs')
            ->setDescription('List all the broken xrefs in the documentation using ".kokoro/docs/publish.sh"')
            ->addOption('write-bugs', null, InputOption::VALUE_REQUIRED, 'write the bug to the given directory')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bugDir = $input->getOption('write-bugs');
        if ($bugDir) {
            $this->sha = $this->determineGoogleapisSha();
        }
        $brokenReferences = [];
        foreach (Component::getComponents() as $component) {
            $input = new ArrayInput($f = [
                'command' => 'docfx',
                '--component' => $component->getName(),
            ]);

            $buffer = new BufferedOutput(OutputInterface::VERBOSITY_DEBUG);
            $returnCode = $this->getApplication()->doRun($input, $buffer);
            $componentBrokenRefs = [];
            foreach (explode("\n", $buffer->fetch()) as $line) {
                if (preg_match(self::BROKEN_REFS_REGEX, $line, $matches)) {
                    list(, $componentName, $file, $ref, $brokenText) = $matches;
                    if (false === strpos($file, '#L')) {
                        // If there are no line numbers, assume this is a PHP bug, and skip it
                        continue;
                    }
                    if ($bugDir) {
                        $componentBrokenRefs[] = ['file' => $file, 'text' => $brokenText];
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
                if (count($componentBrokenRefs) > self::MIN_REFS_PER_BUG) {
                    $file = $this->writeBuggerFile([$component->getName() => $componentBrokenRefs], $bugDir);
                    $output->writeln(sprintf('Wrote %s references to %s', count($componentBrokenRefs), $file));
                } else {
                    if (count($componentBrokenRefs) > 0) {
                        $brokenReferences[$component->getName()] = $componentBrokenRefs;
                    }
                    if (self::MIN_REFS_PER_BUG < $count = array_sum(array_map('count', $brokenReferences))) {
                        $file = $this->writeBuggerFile($brokenReferences, $bugDir);
                        $output->writeln(sprintf('Wrote %s references to %s', $count, $file));
                        // reset broken references
                        $brokenReferences = [];
                    }
                }
            }
        }

        return 0;
    }

    private function writeBuggerFile(array $brokenReferences, string $bugDir): string
    {
        $components = array_keys($brokenReferences);
        if (strlen($componentNames = implode(', ', $components)) > 80) {
            $componentNames = substr($componentNames, 0, 78) . '...';
        }
        $references = array_merge(...array_values($brokenReferences));
        $bugFile = sprintf('%s/broken-refs-%s.txt', $bugDir, implode('-', $components));
        $bugText = sprintf(
            self::BUG_TEMPLATE,
            $componentNames,
            implode("\n", array_map(
                fn ($ref) =>  sprintf(
                    self::BROKEN_REF_TEMPLATE,
                    $ref['file'],
                    $this->sha,
                    $ref['file'],
                    $ref['text']
                ),
                $references
            ))
        );
        file_put_contents($bugFile, $bugText);

        return $bugFile;
    }

    private function determineGoogleapisSha(): string
    {
        $process = new Process(['git', 'rev-parse', 'HEAD'], realpath(__DIR__ . '/../../vendor/googleapis/googleapis'));
        $process->run();
        return trim($process->getOutput());
    }
}
