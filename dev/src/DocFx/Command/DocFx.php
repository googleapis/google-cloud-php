<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Dev\DocFx\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;
use Google\Cloud\Dev\DocFx\Page\PageTree;
use Google\Cloud\Dev\DocFx\Page\OverviewPage;

class DocFx extends Command
{
    private array $composerJson;
    private array $repoMetadataJson;

    protected function configure()
    {
        $this->setName('docfx')
            ->setDescription('Generate DocFX yaml from a phpdoc strucutre.xml')
            ->addOption('xml', '', InputOption::VALUE_REQUIRED, 'Path to phpdoc structure.xml')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'Generate docs only for a single component.', '')
            ->addOption('out', '', InputOption::VALUE_REQUIRED, 'Path where to store the generated output.', 'out')
            ->addOption('metadata-version', '', InputOption::VALUE_REQUIRED, 'version to write to docs.metadata using docuploader')
            ->addOption('staging-bucket', '', InputOption::VALUE_REQUIRED, 'Upload to the specified staging bucket using docuploader.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (PHP_VERSION_ID < 80000) {
            throw new RuntimeException('This command must be run on PHP 8.0 or above');
        }

        $component = $input->getOption('component') ?: basename(getcwd());
        $componentPath = $this->checkComponent($component);
        $output->writeln(sprintf('Generating documentation for <options=bold;fg=white>%s</>', $component));
        $xml = $input->getOption('xml');
        $outDir = $input->getOption('out');
        if (empty($xml)) {
            $output->write('Running phpdoc to generate structure.xml... ');
            // Run "phpdoc"
            $process = new Process([
                'phpdoc',
                '-d',
                sprintf('%s/src', $componentPath),
                '--template',
                'xml',
                '--target',
                $outDir
            ]);
            $process->mustRun();
            $output->writeln('Done.');
            $xml = $outDir . '/structure.xml';
        }
        if (!file_exists($xml)) {
            throw new \Exception($input->getOption('xml') ? 'Unable to load provided structure.xml'
                : sprintf('Default structure.xml file "%s" not found.', $xml));
        }

        if (!is_dir($outDir)) {
            if (!mkdir($outDir)) {
                throw new RuntimeException('out directory doesn\'t exist and cannot be created');
            }
        }

        $output->write(sprintf('Writing output to <fg=white>%s</>... ', $outDir));

        // YAML dump configuration
        $inline = 11; // The level where you switch to inline YAML
        $indent = 2; // The amount of spaces to use for indentation of nested nodes
        $flags = Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK;

        $tocItems = [];
        $packageDescription = $this->getPackageDescription();
        foreach ($this->getNamespaces() as $namespace) {
            $pageTree = new PageTree($xml, $namespace, $packageDescription);

            foreach ($pageTree->getPages() as $page) {
                $docFxArray = ['items' => $page->getItems()];

                // Dump the YAML for the class node
                $yaml = '### YamlMime:UniversalReference' . PHP_EOL;
                $yaml .= Yaml::dump($docFxArray, $inline, $indent, $flags);

                // Write the YAML to a file
                $outFile = sprintf('%s/%s.yml', $outDir, $page->getFilename());
                file_put_contents($outFile, $yaml);
            }

            $tocItems = array_merge($tocItems, $pageTree->getTocItems());
        }

        $releaseLevel = $this->getReleaseLevel();
        if (file_exists($overviewFile = sprintf('%s/README.md', $componentPath))) {
            $overview = new OverviewPage(
                file_get_contents($overviewFile),
                $releaseLevel === 'beta'
            );
            $outFile = sprintf('%s/%s', $outDir, $overview->getFilename());
            file_put_contents($outFile, $overview->getContents());
            // Add "overview" as the first item on the TOC
            array_unshift($tocItems, $overview->getTocItem());
        }

        // Write the TOC to a file
        $componentToc = array_filter([
            'uid' => $this->getComponentUid(),
            'name' => $this->getDistributionName(),
            'status' => $releaseLevel === 'beta' ? 'beta' : '',
            'items' => $tocItems,
        ]);
        $tocYaml = Yaml::dump([$componentToc], $inline, $indent, $flags);
        $outFile = sprintf('%s/toc.yml', $outDir);
        file_put_contents($outFile, $tocYaml);

        $output->writeln('Done.');

        if ($metadataVersion = $input->getOption('metadata-version')) {
            $output->write(sprintf('Writing docs.metadata with version <fg=white>%s</>... ', $metadataVersion));
            $process = new Process([
                'docuploader', 'create-metadata',
                '--name', str_replace('google/', '', $this->getDistributionName()),
                '--version', $metadataVersion,
                '--language', 'php',
                '--distribution-name', $this->getDistributionName(),
                '--product-page', $this->getProductDocumentation(),
                '--github-repository', $this->getRepo(),
                '--issue-tracker', $this->getIssueTracker(),
                $outDir . '/docs.metadata'
            ]);
            $process->mustRun();
            $output->writeln('Done.');
        }

        if ($stagingBucket = $input->getOption('staging-bucket')) {
            $output->write(sprintf('Running docuploader to upload to staging bucket <fg=white>%s</>... ', $stagingBucket));
            $process = new Process([
                'docuploader',
                'upload',
                $outDir,
                '--staging-bucket',
                $stagingBucket,
                '--destination-prefix',
                'docfx-',
                '--metadata-file',
                 // use "realdir" until https://github.com/googleapis/docuploader/issues/132 is fixed
                realpath($outDir) . '/docs.metadata'
            ]);
            $process->mustRun();
            $output->writeln('Done.');
        }
    }

    private function checkComponent(string $component): string
    {
        $rootDir = __DIR__ . '/../../../../';

        $components = scandir($rootDir);
        foreach ($components as $i => $c) {
            if (!is_dir($rootDir . $c) || !preg_match('/^[A-Z]/', $c)) {
                unset($components[$i]);
            }
        }
        if (!in_array($component, $components)) {
            throw new \Exception($component ? 'Invalid component provided'
                : 'You are not in a component directory. Run this command from a valid component'
                  . ' directory or provide a valid component using the "component" option.');
        }

        $componentPath = realpath(sprintf(__DIR__ . '/../../../../%s', $component));

        if (!is_dir($componentPath)) {
            throw new RuntimeException(sprintf('component "%s" not found', $component));
        }

        $composerPath = $componentPath . '/composer.json';
        if (!file_exists($composerPath)) {
            throw new RuntimeException(sprintf('composer.json not found for component "%s"', $component));
        }
        if (!$this->composerJson = json_decode(file_get_contents($composerPath), true)) {
            throw new RuntimeException(sprintf('Invalid composer.json for component "%s"', $component));
        }

        $repoMetadataPath = $componentPath . '/.repo-metadata.json';
        if (!file_exists($repoMetadataPath)) {
            throw new RuntimeException(sprintf('repo metadata not found for component "%s"', $component));
        }
        if (!$this->repoMetadataJson = json_decode(file_get_contents($repoMetadataPath), true)) {
            throw new RuntimeException(sprintf('Invalid .repo-metadata.json for component "%s"', $component));
        }

        return $componentPath;
    }

    private function getReleaseLevel(): string
    {
        if (empty($this->repoMetadataJson['release_level'])) {
            throw new RuntimeException(sprintf(
                'repo metadata does not contain "release_level" for component "%s"',
                $component
            ));
        }

        return $this->repoMetadataJson['release_level'];
    }

    private function getProductDocumentation(): string
    {
        return $this->repoMetadataJson['product_documentation'] ?? '';
    }

    private function getDistributionName(): string
    {
        if (empty($this->composerJson['name'])) {
            throw new RuntimeException('composer.json does not contain "name"');
        }
        return $this->composerJson['name'];
    }

    /**
     * Formats distribution name like
     *   - google-cloud-policy-troubleshooter
     *   - google-cloud-vision
     *   - google-grafeas
     *   - google-analytics-data
     */
    private function getComponentUid(): string
    {
        return str_replace('/', '-', $this->getDistributionName());
    }

    private function getPackageDescription(): string
    {
        if (empty($this->composerJson['description'])) {
            throw new RuntimeException('composer.json does not contain "description"');
        }
        return $this->composerJson['description'];
    }

    private function getNamespaces(): array
    {
        if (empty($this->composerJson['autoload']['psr-4'])) {
            throw new RuntimeException('composer does not contain autoload.psr-4');
        }

        $namespaces = [];
        foreach ($this->composerJson['autoload']['psr-4'] as $namespace => $dir) {
            if (0 === strpos($dir, 'src')) {
                $namespaces[] = rtrim($namespace, '\\');
            }
        }

        if (empty($namespaces)) {
            throw new RuntimeException('composer autoload.psr-4 does not contain a namespace');
        }

        return $namespaces;
    }

    private function getRepo(): string
    {
        if (empty($this->composerJson['extra']['component']['target'])) {
            throw new RuntimeException('composer does not contain extra.component.target');
        }

        // Strip trailing ".git"
        return preg_replace('/\.git$/', '', $this->composerJson['extra']['component']['target']);
    }

    private function getIssueTracker(): string
    {
        return sprintf('https://github.com/%s/issues', $this->getRepo());
    }
}
