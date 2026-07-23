<?php
/**
 * Copyright 2026 Google LLC
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

use Google\Generator\CodeGenerator;
use Google\Generator\Utils\MigrationMode;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Generate Showcase Client SDK for Conformance Tests.
 *
 * @internal
 */
class ShowcaseGenerateCommand extends Command
{
    private string $rootPath;
    private Filesystem $fs;

    public function __construct(string $rootPath)
    {
        $this->rootPath = rtrim($rootPath, '/') . '/';
        $this->fs = new Filesystem();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('showcase:generate')
            ->setDescription('Generates the GAPIC Showcase client SDK for Conformance tests')
            ->addOption(
                'out-dir',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output directory relative to root (defaults to Gax/tests/Conformance)',
                'Gax/tests/Conformance'
            )
            ->addOption(
                'gapic-generator-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to local gapic-generator repository (defaults to installed vendor dependency)',
                $this->rootPath . 'dev/vendor/google/gapic-generator'
            )
            ->addOption(
                'showcase-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to local gapic-showcase repository (defaults to installed vendor dependency)',
                $this->rootPath . 'dev/vendor/google/gapic-showcase'
            )
            ->addOption(
                'googleapis-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to googleapis repository (defaults to submodule in gapic-generator)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $executableFinder = new ExecutableFinder();
        if (!$executableFinder->find('protoc')) {
            $output->writeln('<error>Error: protoc not found. Please install the protobuf compiler.</error>');
            return Command::FAILURE;
        }

        $outDir = $input->getOption('out-dir');
        $targetDir = $this->rootPath . trim($outDir, '/');
        $tmpOutputDir = sys_get_temp_dir() . '/showcase_out_' . uniqid();
        $descFile = $tmpOutputDir . '/desc.pb';

        // 1. Resolve Generator Path (Defaults to vendor dependency)
        $generatorPath = $input->getOption('gapic-generator-path');
        if (file_exists($generatorPath . '/vendor/autoload.php')) {
            require_once $generatorPath . '/vendor/autoload.php';
        }
        $output->writeln("<info>Using gapic-generator from:</info> {$generatorPath}");

        // 2. Resolve Showcase Path (Defaults to vendor dependency)
        $showcasePath = $input->getOption('showcase-path');
        if (!is_dir($showcasePath . '/schema/google/showcase/v1beta1')) {
            $output->writeln("<error>Error: gapic-showcase schema directory not found at {$showcasePath}.</error>");
            return Command::FAILURE;
        }
        $schemaDir = $showcasePath . '/schema/google/showcase/v1beta1';

        // 3. Resolve Googleapis Path (Defaults to submodule in generatorPath)
        $googleapisPath = $input->getOption('googleapis-path');
        if (!$googleapisPath) {
            $submoduleGoogleapis = $generatorPath . '/googleapis';
            if (!file_exists($submoduleGoogleapis . '/google/cloud/common_resources.proto')) {
                $output->writeln('<info>Fetching googleapis definitions for gapic-generator...</info>');
                if (is_dir($generatorPath . '/.git')) {
                    $this->runProcess(['git', 'submodule', 'update', '--init', '--recursive'], $generatorPath);
                } else {
                    $this->runProcess(['git', 'clone', '--depth', '1', 'https://github.com/googleapis/googleapis.git', $submoduleGoogleapis]);
                }
            }
            if (is_dir($submoduleGoogleapis . '/google/cloud')) {
                $googleapisPath = $submoduleGoogleapis;
            }
        }

        if (!$googleapisPath || !is_dir($googleapisPath . '/google/cloud')) {
            $output->writeln('<error>Error: googleapis directory not found.</error>');
            $output->writeln('Please specify the path using <comment>--googleapis-path <dir></comment>');
            return Command::FAILURE;
        }

        $output->writeln("<info>Using output directory:</info> {$targetDir}");
        $output->writeln("<info>Using gapic-showcase schemas from:</info> {$schemaDir}");
        $output->writeln("<info>Using googleapis definitions from:</info> {$googleapisPath}");

        $this->fs->mkdir($tmpOutputDir . '/src');

        // 5. Compile Proto Descriptor Set (desc.pb)
        $output->writeln('<info>2. Compiling proto descriptor set (desc.pb)...</info>');
        $allProtoFiles = glob($schemaDir . '/*.proto');

        $protocDescCmd = array_merge([
            'protoc',
            '--include_imports',
            '--include_source_info',
            '-I', $showcasePath . '/schema',
            '-I', $googleapisPath,
            '--descriptor_set_out=' . $descFile,
            $googleapisPath . '/google/cloud/common_resources.proto'
        ], $allProtoFiles);
        $this->runProcess($protocDescCmd);

        // 6. Generate Showcase PHP Client via CodeGenerator
        $output->writeln('<info>3. Generating Showcase PHP client (NEW_SURFACE_ONLY mode)...</info>');

        $descBytes = file_get_contents($descFile);
        $grpcConfig = file_get_contents($schemaDir . '/showcase_grpc_service_config.json');

        $serviceYaml = file_exists($schemaDir . '/showcase_v1beta1.yaml') ? file_get_contents($schemaDir . '/showcase_v1beta1.yaml') : null;

        $files = CodeGenerator::generateFromDescriptor(
            $descBytes,
            'google.showcase.v1beta1', //package
            'grpc+rest', //transport
            true, //generateGapicMetadata
            $grpcConfig, //grpcServiceConfigJson
            null, //gapicYaml
            $serviceYaml, //serviceYaml
            numericEnums: false,
            licenseYear: -1,
            generateSnippets: false,
            migrationMode: MigrationMode::NEW_SURFACE_ONLY
        );

        foreach ($files as [$relPath, $content]) {
            $fullPath = $tmpOutputDir . '/' . $relPath;
            $this->fs->mkdir(dirname($fullPath));
            $this->fs->dumpFile($fullPath, $content);
        }

        // 7. Generate Protobuf Message Classes via protoc --php_out
        $output->writeln('<info>4. Generating Protobuf message classes...</info>');
        $protocPhpCmd = array_merge([
            'protoc',
            '-I', $showcasePath . '/schema',
            '-I', $googleapisPath,
            '--php_out=' . $tmpOutputDir . '/src',
        ], $allProtoFiles);
        $this->runProcess($protocPhpCmd);

        // 8. Organize output into Conformance directory
        $output->writeln('<info>5. Organizing output into Conformance directory...</info>');
        $this->fs->remove([$targetDir . '/src/V1beta1', $targetDir . '/metadata']);
        $this->fs->mkdir([$targetDir . '/src/V1beta1/resources', $targetDir . '/metadata']);

        $mappings = [
            '/src/V1beta1' => '/src/V1beta1', // GAPIC clients
            '/src/Google/Showcase/V1beta1' => '/src/V1beta1', // protobuf messages
            '/resources' => '/src/V1beta1/resources', // REST and GAPIC configs
            '/src/GPBMetadata/Google/Showcase' => '/metadata', // protobuf metadata
        ];
        foreach ($mappings as $source => $dest) {
            $srcDir = $tmpOutputDir . $source;
            if (is_dir($srcDir)) {
                $this->fs->mirror($srcDir, $outDir . $dest);
            }
        }

        // Exclude deprecated Protobuf flat alias files matching *_* (ignoring resources)
        $deprecatedFinder = (new Finder())->files()->name('*_*.php')->in($targetDir . '/src/V1beta1')->notPath('resources');
        $this->fs->remove($deprecatedFinder);

        // 9. Clean up temporary files
        $output->writeln('<info>6. Cleaning up temporary files...</info>');
        $this->fs->remove([$tmpOutputDir]);

        $output->writeln("<info>✅ Showcase Client generation complete! Output saved in: {$targetDir}</info>");

        return Command::SUCCESS;
    }

    private function runProcess(array $command, ?string $cwd = null): void
    {
        $process = new Process($command, $cwd);
        $process->setTimeout(300);
        $process->mustRun();
    }
}
