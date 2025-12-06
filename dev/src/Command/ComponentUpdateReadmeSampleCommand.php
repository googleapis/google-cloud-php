<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Dev\Component;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Add a Component
 * @internal
 */
class ComponentUpdateReadmeSampleCommand extends Command
{
    private $rootPath;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param Client $httpClient specify the HTTP client, useful for tests.
     */
    public function __construct(string $rootPath)
    {
        $this->rootPath = realpath($rootPath);
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('component:update:readme-sample')
            ->setDescription('Add a sample to a component')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Add to the readme of the specified component', [])
            ->addOption('update', '', InputOption::VALUE_NONE, 'updates the sample in the readme if it exists');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Compile all the component data into rows
        $components = Component::getComponents($input->getOption('component'), $this->rootPath);

        foreach ($components as $component) {
            if (!$sample = $component->getSimplestSample()) {
                $output->writeln('<error>Unable to retrieve sample</error> in <info>' . $component->getName() . '</>');
                continue;
            }
            $readme = file_get_contents($component->getPath() . '/README.md');
            if (strpos($readme, '### Sample') === false) {
                $output->writeln('No "Sample" header found in <info>' . $component->getName() . '</> README.md');
                $output->writeln('Trying to insert above "Debugging" header instead...');
                if (strpos($readme, '### Debugging') === false) {
                    $output->writeln(sprintf(
                        'No "Debugging" header found, <error>unable to add sample</error> to <info>%s</> README.md',
                        $component->getName()
                    ));
                    continue;
                }
            }

            $sample = "```php\n" . $sample . "\n```";
            if (preg_match('/### Sample\n\n(```(.|\n)*```)/', $readme, $matches)) {
                $output->writeln('Sample already exists in <info>' . $component->getName() . '</> README.md');
                if (!$input->getOption('update')) {
                    continue;
                }
                if ($matches[1] === $sample) {
                    $output->writeln('Nothing to update.');
                    continue;
                }
                $readme = str_replace($matches[1], $sample, $readme);
            } else {
                if (strpos($readme, '### Sample') === false) {
                    $readme = str_replace('### Debugging', "### Sample\n\n" . $sample . "\n\n### Debugging", $readme);
                } else {
                    $readme = str_replace('### Sample', "### Sample\n\n" . $sample, $readme);
                }
            }

            file_put_contents($component->getPath() . '/README.md', $readme);
            $output->writeln('Successfull wrote sample to <info>' . $component->getName() . '</> README.md');
        }

        return 0;
    }
}
