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

namespace Google\Cloud\Dev\ComplianceChecker\Command;

use Google\Cloud\Dev\ComplianceChecker\Component;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test component integration.
 */
class CheckCompliance extends Command
{
    private $googleapisDir = __DIR__ . '/../../../../../googleapis';
    protected function configure()
    {
        $this->setName('check-compliance')
            ->setDescription('check the compliance of a component or the whole library')
            ->addOption('component', '', InputOption::VALUE_REQUIRED, 'Component to check compliance for.')
            ->addOption('csv', '', InputOption::VALUE_REQUIRED, 'export findings to csv.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $components = [];
        $components[] = [
            'Protobuf package',
            'Composer package',
            'GitHub repo',
            'PHP namespace',
            'Component',
            'Validation errors'
        ];
        if ($componentName = $input->getOption('component')) {
            $components[] = $this->checkComponent(new Component($componentName));
        } else {
            foreach (Component::getComponents() as $component) {
                $components[] = $this->checkComponent($component);
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
    }

    private function checkComponent(Component $component): array
    {
        $protobufPackage = '';
        $githubRepo = $component->getRepoName();
        $composerPackage = $component->getPackageName();
        $phpNamespace = $component->getNamespaces()[0];
        $componentName = $component->getName();
        $validationErrors = [];
        $expectedNamespaceFromProto = '';
        try {
            $protobufPackage = $component->getProtoPackage($this->googleapisDir);
        } catch (\Exception $e) {
            $validationErrors[] = $e->getMessage();
        }

        if ($protobufPackage) {
            // Output validation errors
            $expectedComposerPackage = 'google/' . str_replace(
                ['google.', 'devtools.cloud', '.'],
                ['', 'cloud-', '-'],
                $protobufPackage
            );
            $expectedGithubRepo = 0 === strpos($composerPackage, 'google/cloud-')
                ? 'googleapis/google-cloud-php-' . substr($composerPackage, 13)
                : 'googleapis/php-' . substr($composerPackage, 7);
            $expectedNamespaceFromProto = implode('\\', array_map('ucfirst', explode('.', $protobufPackage)));
            if ($expectedGithubRepo !== $githubRepo) {
                $validationErrors[] = "Github repo name $githubRepo doesn't match expected $expectedGithubRepo";
            }
            if ($expectedComposerPackage !== $composerPackage) {
                $validationErrors[] = "Composer package name $composerPackage doesn't match expected $expectedComposerPackage";
            }
        }

        $expectedComponentName = str_replace([
            'google/cloud-', 'google/'],
            '',
            $composerPackage
        );
        $expectedComponentName = implode('', array_map('ucfirst', explode('-', $expectedComponentName)));
        if (strtolower($componentName) !== strtolower($expectedComponentName)) {
            $validationErrors[] = "Component $componentName doesn't match expected $expectedComponentName";
        }

        $expectedNamespaceFromComposer = implode('\\', array_map('ucfirst', preg_split('#/|-#', $composerPackage)));
        if (strtolower($expectedNamespaceFromComposer) !== strtolower($phpNamespace)
            && strtolower($expectedNamespaceFromProto) !== strtolower($phpNamespace)
        ) {
            $validationErrors[] = "PHP namespace $phpNamespace doesn't match expected "
                . ($protobufPackage ? $expectedNamespaceFromProto : $expectedNamespaceFromComposer);
        }

        return [
            $protobufPackage,
            $composerPackage,
            $githubRepo,
            $phpNamespace,
            $componentName,
            implode("\n", $validationErrors),
        ];
    }
}