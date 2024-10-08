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

    protected function configure()
    {
        $this->setName('list-broken-xrefs')
            ->setDescription('List all the broken xrefs in the documentation using ".kokoro/docs/publish.sh"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (Component::getComponents() as $component) {
            $input = new ArrayInput($f = [
                'command' => 'docfx',
                '--component' => $component->getName(),
            ]);

            $buffer = new BufferedOutput(OutputInterface::VERBOSITY_DEBUG);
            $returnCode = $this->getApplication()->doRun($input, $buffer);
            foreach (explode("\n", $buffer->fetch()) as $line) {
                if (preg_match(self::BROKEN_REFS_REGEX, $line, $matches)) {
                    list(, $component, $file, $ref, $brokenText) = $matches;
                    $link = sprintf(
                        '"=HYPERLINK(""https://github.com/googleapis/googleapis/blob/master/%s"", ""%s"")"',
                        $file,
                        $file
                    );
                    $output->writeln(implode(',', [$component, $link, $ref, $brokenText]));
                }
            }
        }

        return 0;
    }
}
