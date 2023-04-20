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

use Google\Cloud\Dev\NewComponent;
use Google\Cloud\Dev\Component;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * List component details
 * @internal
 */
class ComponentInfoCommand extends Command
{
    private $googleapisDir = __DIR__ . '/../../../../../googleapis';
    protected function configure()
    {
        $this->setName('component-info')
            ->setDescription('list info of a component or the whole library')
            ->addArgument('name', InputArgument::OPTIONAL, 'Component to check compliance for.')
            ->addOption('csv', '', InputOption::VALUE_REQUIRED, 'export findings to csv.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $components = [];
        $components[] = [
            'Component',
            'Composer package',
            'GitHub repo',
            'PHP namespace',
            'Protobuf package',
        ];
        $verbose = $input->getOption('verbose');
        if ($verbose) {
            $components[0][] = 'Validation errors';
        }
        if ($componentName = rtrim($input->getArgument('name'), '/')) {
            $components[] = $this->checkComponent(new Component($componentName), $verbose);
        } else {
            foreach (Component::getComponents() as $component) {
                $components[] = $this->checkComponent($component, $verbose);
            }
        }

        if ($csv = $input->getOption('csv')) {
            $fp = fopen($csv, 'wa+');
            foreach ($components as $component) {
                fputcsv($fp, $component);
            }
            fclose($fp);
            $output->writeln('Output written to ' . $csv);
        } else {
            $table = new Table($output);
            $table
                ->setHeaders(array_shift($components))
                ->setRows($components)
            ;
            $table->render();
        }

        return 0;
    }

    private function checkComponent(Component $component, bool $verbose): array
    {
        $protobufPackage = '';
        $githubRepo = $component->getRepoName();
        $composerPackage = $component->getPackageName();
        $phpNamespace = $component->getNamespaces()[0];
        $componentName = $component->getName();
        $validationErrors = [];
        $expectedNamespace = '';
        try {
            $protobufPackage = $component->getProtoPackage($this->googleapisDir);
        } catch (\Exception $e) {
            $validationErrors[] = $e->getMessage();
        }

        if ($verbose && $protobufPackage) {
            $namer = new NewComponent();
            // Output validation errors
            $expectedComposerPackage = $namer->composerPackage;
            $expectedGithubRepo = $namer->githubRepo;
            $expectedNamespace = $namer->phpNamespace;
            if ($expectedGithubRepo !== $githubRepo) {
                $validationErrors[] = "Github repo name $githubRepo doesn't match expected $expectedGithubRepo";
            }
            if ($expectedComposerPackage !== $composerPackage) {
                $validationErrors[] = "Composer package name $composerPackage doesn't match expected $expectedComposerPackage";
            }

            $expectedComponentName = $namer->componentName;
            if (strtolower($componentName) !== strtolower($expectedComponentName)) {
                $validationErrors[] = "Component $componentName doesn't match expected $expectedComponentName";
            }

            $expectedNamespace = $namer->phpNamespace;
            if (strtolower($expectedNamespace) !== strtolower($phpNamespace)) {
                $validationErrors[] = "PHP namespace $phpNamespace doesn't match expected $expectedNamespace";
            }
        }

        $info = [
            $componentName,
            $composerPackage,
            $githubRepo,
            $phpNamespace,
            $protobufPackage,
        ];
        if ($verbose) {
            $info[] = implode("\n", $validationErrors);
        }
        return $info;
    }
}