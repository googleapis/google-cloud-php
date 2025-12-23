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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;
use Google\Auth\Cache\FileSystemCacheItemPool;
use Google\Cloud\Core\Logger\AppEngineFlexFormatter;
use Google\Cloud\Core\Logger\AppEngineFlexFormatterV2;
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

    private string $componentName;
    private array $composerJson;
    private array $repoMetadataJson;

    // these links are inexplicably broken in phpdoc generation, and will require more investigation
    private static array $allowedReferenceFailures = [
        '\Google\Cloud\ResourceManager\V3\Client\ProjectsClient::testIamPermissions()'
            => 'ProjectsClient::testIamPermissionsAsync()',
        '\Google\Cloud\Logging\V2\Client\ConfigServiceV2Client::getView()'
            => 'ConfigServiceV2Client::getViewAsync()'
    ];

    private static array $productNeutralGuides = [
        'README.md' => 'Getting Started',
        'AUTHENTICATION.md' => 'Authentication',
        'CORE_CONCEPTS.md' => 'Core Concepts',
        'CLIENT_CONFIGURATION.md' => 'Client Configuration',
        'OCC_FOR_IAM.md' => 'OCC for IAM',
        'MIGRATING.md' => 'Migrating to V2',
        'GRPC.md' => 'Installing gRPC and Protobuf',
        'DEBUG.md' => 'Troubleshooting',
    ];

    protected function configure()
    {
        $this->setName('docfx')
            ->setDescription('Generate DocFX yaml from a phpdoc strucutre.xml')
            ->addOption('xml', '', InputOption::VALUE_REQUIRED, 'Path to phpdoc structure.xml')
            ->addOption('component', 'c', InputOption::VALUE_REQUIRED, 'Generate docs for a specific component.', '')
            ->addOption('out', '', InputOption::VALUE_REQUIRED, 'Path where to store the generated output.', 'out')
            ->addOption('metadata-version', '', InputOption::VALUE_REQUIRED, 'version to write to docs.metadata using docuploader')
            ->addOption('staging-bucket', '', InputOption::VALUE_REQUIRED, 'Upload to the specified staging bucket using docuploader.')
            ->addOption('path', '', InputOption::VALUE_OPTIONAL, 'Specify the path to the composer package to generate.')
            ->addOption('--with-cache', '', InputOption::VALUE_NONE, 'Cache expensive proto namespace lookups to a file')
            ->addOption('--generate-product-neutral-guides', '', InputOption::VALUE_NONE, 'Instead of a component, generate product-neutral guides.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // YAML dump configuration
        $inline = 11; // The level where you switch to inline YAML
        $indent = 2; // The amount of spaces to use for indentation of nested nodes
        $flags = Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK;

        $outDir = $input->getOption('out');
        if (!is_dir($outDir)) {
            if (!mkdir($outDir)) {
                throw new RuntimeException('out directory doesn\'t exist and cannot be created');
            }
        }

        if ($input->getOption('generate-product-neutral-guides')) {
            $output->writeln('Generating <options=bold;fg=white>product neutral guides</>');
            $tocItems = [];
            foreach (self::$productNeutralGuides as $file => $name) {
                $href = $file === 'README.md' ? 'getting-started.md' : strtolower(basename($file));
                file_put_contents(
                    $outDir . '/' . $href,
                    file_get_contents(Component::ROOT_DIR . '/' . $file)
                );
                $tocItems[] = ['name' => $name, 'href' => $href];
            }
            // Write the TOC to a file
            $guideToc = array_filter([
                'uid' => 'product-neutral-guides',
                'name' => 'Client library help',
                'items' => $tocItems,
            ]);
            $tocYaml = Yaml::dump([$guideToc], $inline, $indent, $flags);
            $outFile = sprintf('%s/toc.yml', $outDir);
            file_put_contents($outFile, $tocYaml);

            $output->writeln('Done.');

            if ($metadataVersion = $input->getOption('metadata-version')) {
                $output->write(sprintf('Writing docs.metadata with version <fg=white>%s</>... ', $metadataVersion));
                $process = new Process([
                    'docuploader', 'create-metadata',
                    '--name', 'help',
                    '--version', $metadataVersion,
                    '--language', 'php',
                    $outDir . '/docs.metadata'
                ]);
                $process->mustRun();
                $output->writeln('Done.');
            }

            if ($stagingBucket = $input->getOption('staging-bucket')) {
                $output->write(sprintf('Running docuploader to upload to staging bucket <fg=white>%s</>... ', $stagingBucket));
                $this->uploadToStagingBucket($outDir, $stagingBucket);
                $output->writeln('Done.');
            }

            return 0;
        }

        $componentPath = $input->getOption('path');
        $this->componentName = rtrim($input->getOption('component'), '/') ?: basename(getcwd());
        $component = new Component($this->componentName, $componentPath);
        $output->writeln(sprintf('Generating documentation for <options=bold;fg=white>%s</>', $this->componentName));

        $xml = $input->getOption('xml');
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

        $output->writeln(sprintf('Writing output to <fg=white>%s</>... ', $outDir));

        $valid = true;
        $tocItems = [];
        $packageDescription = $component->getDescription();
        $isBeta = 'stable' !== $component->getReleaseLevel();
        $packageNamespaces = $this->getProtoPackageToNamespaceMap($input->getOption('with-cache'));
        foreach ($component->getNamespaces() as $namespace => $dir) {
            $pageTree = new PageTree(
                $xml,
                $namespace,
                $packageDescription,
                $component->getPath(),
                $packageNamespaces
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
            $output->writeln('<error>Docs validation failed - invalid reference</>');
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
            $xrefs = array_merge(...array_map(
                fn ($c) => ['--xrefs', sprintf('devsite://php/%s', $c->getId())],
                $component->getComponentDependencies(),
            ));
            $process = new Process([
                'docuploader', 'create-metadata',
                '--name', $component->getId(),
                '--version', $metadataVersion,
                '--language', 'php',
                '--distribution-name', $component->getPackageName(),
                '--product-page', $component->getProductDocumentation(),
                '--github-repository', $component->getRepoName(),
                '--issue-tracker', $component->getIssueTracker(),
                ...$xrefs,
                $outDir . '/docs.metadata'
            ]);
            $process->mustRun();
            $output->writeln('Done.');
        }

        if ($stagingBucket = $input->getOption('staging-bucket')) {
            $output->write(sprintf('Running docuploader to upload to staging bucket <fg=white>%s</>... ', $stagingBucket));
            $this->uploadToStagingBucket($outDir, $stagingBucket);
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
        $warnings = [];
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
            foreach ($this->getBrokenXrefs($node->getContent()) as [$brokenRef, $brokenRefText]) {
                $brokenRef = $isGenerated ? $this->classnameToProtobufPath((string) $brokenRef, $brokenRefText) : $brokenRef;
                $nodePath = $isGenerated
                    ? $this->getProtoFileName($class, $brokenRef) . ' (' . $node->getProtoPath($class->getName()) . ')'
                    : $node->getFullname();
                $warnings[] = sprintf(
                    '[%s] Broken xref in <comment>%s</>: <options=bold>%s</>',
                    $this->componentName,
                    $nodePath,
                    str_replace("\n", '', $brokenRef) ?: $emptyRef
                );
                // generated classes are allowed to have broken xrefs
                if ($isGenerated) {
                    continue;
                }
                $valid = false;
            }
        }
        foreach (array_unique($warnings) as $warning) {
            $output->writeln($warning, $isGenerated ? OutputInterface::VERBOSITY_VERBOSE : OutputInterface::VERBOSITY_NORMAL);
        }
        return $valid;
    }

    private function getProtoPackageToNamespaceMap(bool $useFileCache): array
    {
        if (!$useFileCache) {
            return Component::getProtoPackageToNamespaceMap();
        }

        $cache = new FileSystemCacheItemPool('.cache');
        $item = $cache->getItem('phpdoc_proto_package_to_namespace_map');

        if (!$item->isHit()) {
            $item->set(Component::getProtoPackageToNamespaceMap());
            $cache->save($item);
        }

        return $item->get();
    }

    private function uploadToStagingBucket(string $outDir, string $stagingBucket): void
    {
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
    }

    private function classnameToProtobufPath(string $ref, string $text): string
    {
        // remove leading and trailing slashes and parentheses
        $ref = trim(trim($ref, '\\'), '()');
        // convert methods to snake case
        if (strpos($ref, '::set') !== false || strpos($ref, '::get') !== false) {
            $parts = explode('::', $ref);
            $ref = $parts[0] . '.' . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($parts[1], 3)));
        }

        // convert namespace separators and function calls to dots
        $ref = str_replace(['\\', '::'], '.', $ref);

        // lowercase the namespace
        $parts = explode('.', $ref);
        foreach ($parts as $i => $part) {
            if (preg_match(Component::VERSION_REGEX, $part) || $part === 'Master') {
                for ($j = 0; $j <= $i; $j++) {
                    $parts[$j] = strtolower($parts[$j]);
                }
                $ref = implode('.', $parts);
                break;
            }
        }

        // convert namespace to lowercase
        $ref = false === strpos($ref, '.') ? strtolower($ref) : $ref;

        return sprintf('[%s][%s]', $text, $ref);
    }

    public function getProtoFileName(ClassNode $node, string $ref = null): string|null
    {
        if (!$node->isProtobufMessageClass()
            && !$node->isProtobufEnumClass()
            && !$node->isServiceClass()
        ) {
            return null;
        }

        $filename = (new \ReflectionClass($node->getFullName()))->getFileName();

        if ($node->isProtobufMessageClass() || $node->isProtobufEnumClass()) {
            $lines = explode("\n", file_get_contents($filename));
            $proto = str_replace('# source: ', '', $lines[2]);
        } else {
            $lines = explode("\n", file_get_contents($filename));
            $proto = str_replace(' * https://github.com/googleapis/googleapis/blob/master/', '', $lines[20]);
        }

        if (!$ref) {
            return $proto;
        }

        $protoUrl = 'https://github.com/googleapis/googleapis/blob/master/' . $proto;
        if (!$protoContents = file_get_contents($protoUrl)) {
            // gracefully fail to retrieve proto contents
            return $proto;
        }

        $lines = explode("\n", $protoContents);
        $ref1 = $ref2 = null;
        if (false !== strpos($ref, "\n")) {
            [$ref1, $ref2] = explode("\n", $ref);
        }
        foreach ($lines as $i => $line) {
            if ($ref1 && $ref2) {
                if (false !== stripos($line, $ref1)
                    && false !== stripos($lines[$i+1], $ref2)) {
                    return $proto . '#L' . ($i + 1);
                }
            } elseif (false !== stripos($line, $ref)) {
                return $proto . '#L' . ($i + 1);
            }
        }

        return $proto;
    }
}
