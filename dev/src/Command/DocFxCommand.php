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

namespace Google\Cloud\Dev\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;
use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\DocFx\Node\ClassNode;
use Google\Cloud\Dev\DocFx\Page\PageTree;
use Google\Cloud\Dev\DocFx\Page\OverviewPage;
use Google\Cloud\Dev\DocFx\XrefValidationTrait;

/**
 * @internal
 */
class DocFxCommand extends Command
{
    use XrefValidationTrait;

    private array $composerJson;
    private array $repoMetadataJson;

    // these links are inexplicably broken in phpdoc generation, and will require more investigation
    private static array $allowedReferenceFailures = [
        '\Google\Cloud\ResourceManager\V3\Client\ProjectsClient::testIamPermissions()'
            => 'ProjectsClient::testIamPermissionsAsync()',
        '\Google\Cloud\Logging\V2\Client\ConfigServiceV2Client::getView()'
            => 'ConfigServiceV2Client::getViewAsync()'
    ];

    protected function configure()
    {
        $this->setName('docfx')
            ->setDescription('Generate DocFX yaml from a phpdoc strucutre.xml')
            ->addOption('xml', '', InputOption::VALUE_REQUIRED, 'Path to phpdoc structure.xml')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'Generate docs only for a single component.', '')
            ->addOption('out', '', InputOption::VALUE_REQUIRED, 'Path where to store the generated output.', 'out')
            ->addOption('metadata-version', '', InputOption::VALUE_REQUIRED, 'version to write to docs.metadata using docuploader')
            ->addOption('staging-bucket', '', InputOption::VALUE_REQUIRED, 'Upload to the specified staging bucket using docuploader.')
            ->addOption(
                'component-path',
                '',
                InputOption::VALUE_OPTIONAL,
                'Specify the path of the desired component. Please note, this option is only intended for testing purposes.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (PHP_VERSION_ID < 80000) {
            throw new RuntimeException('This command must be run on PHP 8.0 or above');
        }

        $componentName = rtrim($input->getOption('component'), '/') ?: basename(getcwd());
        $component = new Component($componentName, $input->getOption('component-path'));
        $output->writeln(sprintf('Generating documentation for <options=bold;fg=white>%s</>', $componentName));
        $xml = $input->getOption('xml');
        $outDir = $input->getOption('out');
        if (empty($xml)) {
            $output->write('Running phpdoc to generate structure.xml... ');
            // Run "phpdoc"
            $process = self::getPhpDocCommand($component->getPath(), $outDir);
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

        $valid = true;
        $tocItems = [];
        $packageDescription = $component->getDescription();
        $isBeta = 'stable' !== $component->getReleaseLevel();
        foreach ($component->getNamespaces() as $namespace => $dir) {
            $pageTree = new PageTree(
                $xml,
                $namespace,
                $packageDescription,
                $component->getPath()
            );

            foreach ($pageTree->getPages() as $page) {
                // validate the docs page. this will fail the job if it's false
                $valid = $this->validate($page->getClassNode(), $output) && $valid;
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

        // exit early if the docs aren't valid
        if (!$valid) {
            return 1;
        }

        if (file_exists($overviewFile = sprintf('%s/README.md', $component->getPath()))) {
            // Add Migrating Doc if we are in a V2 component
            if (str_starts_with($component->getPackageVersion(), '2.')) {
                if (!file_exists($migratingFile = sprintf($component->getPath() . '/MIGRATING.md'))) {
                    $migratingFile = Component::ROOT_DIR . '/MIGRATING.md';
                }
                file_put_contents($outDir . '/migrating.md', file_get_contents($migratingFile));
                // Add "migrating" as the second item on the TOC (after "overview")
                array_unshift($tocItems, ['name' => 'Migrating', 'href' => 'migrating.md']);
            }

            $overview = new OverviewPage(
                file_get_contents($overviewFile),
                $isBeta
            );
            $outFile = sprintf('%s/%s', $outDir, $overview->getFilename());
            file_put_contents($outFile, $overview->getContents());
            // Add "overview" as the first item on the TOC
            array_unshift($tocItems, $overview->getTocItem());
        }

        // Write the TOC to a file
        $componentToc = array_filter([
            'uid' => $component->getReferenceDocumentationUid(),
            'name' => $component->getPackageName(),
            'status' => $isBeta ? 'beta' : '',
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
                '--name', str_replace('google/', '', $component->getPackageName()),
                '--version', $metadataVersion,
                '--language', 'php',
                '--distribution-name', $component->getPackageName(),
                '--product-page', $component->getProductDocumentation(),
                '--github-repository', $component->getRepoName(),
                '--issue-tracker', $component->getIssueTracker(),
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

        return 0;
    }

    public static function getPhpDocCommand(string $componentPath, string $outDir): Process
    {
        $process = new Process([
            'phpdoc',
            '--visibility',
            'public,protected,private,internal',
            '-d',
            sprintf('%s/src', $componentPath),
            '--template',
            'xml',
            '--target',
            $outDir
        ]);

        // The Compute component can exceed the default timeout of 60 seconds.
        $process->setTimeout(120);

        return $process;
    }

    private function validate(ClassNode $class, OutputInterface $output): bool
    {
        $valid = true;
        $emptyRef = '<options=bold>empty</>';
        $isGenerated = $class->isProtobufMessageClass() || $class->isProtobufEnumClass() || $class->isServiceClass();
        foreach (array_merge([$class], $class->getMethods(), $class->getConstants()) as $node) {
            foreach ($this->getInvalidXrefs($node->getContent()) as $invalidRef) {
                if (isset(self::$allowedReferenceFailures[$node->getFullname()])
                    && self::$allowedReferenceFailures[$node->getFullname()] == $invalidRef) {
                    // these links are inexplicably broken in phpdoc generation, and will require more investigation
                    continue;
                }
                $output->write(sprintf("\n<error>Invalid xref in %s: %s</>", $node->getFullname(), $invalidRef));
                $valid = false;
            }
            foreach ($this->getBrokenXrefs($node->getContent()) as $brokenRef) {
                $output->writeln(
                    sprintf('<comment>Broken xref in %s: %s</>', $node->getFullname(), $brokenRef ?: $emptyRef),
                    $isGenerated ? OutputInterface::VERBOSITY_VERBOSE : OutputInterface::VERBOSITY_NORMAL
                );
                // generated classes are allowed to have broken xrefs
                if ($isGenerated) {
                    continue;
                }
                $valid = false;
            }
        }
        if (!$valid) {
            $output->writeln('');
        }
        return $valid;
    }
}
