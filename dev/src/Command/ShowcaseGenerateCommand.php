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
    private string $rootDirectory;
    private Filesystem $fs;

    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = rtrim($rootDirectory, '/') . '/';
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
                'Output directory relative to root (defaults to Gax)',
                'Gax'
            )
            ->addOption(
                'generator-path',
                'g',
                InputOption::VALUE_REQUIRED,
                'Path to local gapic-generator repository (defaults to installed vendor dependency)'
            )
            ->addOption(
                'showcase-path',
                'p',
                InputOption::VALUE_REQUIRED,
                'Path to local gapic-showcase repository (defaults to installed vendor dependency)'
            )
            ->addOption(
                'googleapis-path',
                'a',
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
        $targetDir = $this->rootDirectory . trim($outDir, '/');
        $conformanceDir = $targetDir . '/tests/Conformance';
        $tmpOutputDir = $conformanceDir . '/tmp_out';
        $descFile = $conformanceDir . '/desc.pb';

        // 1. Resolve Generator Path (Defaults to vendor dependency)
        $generatorPath = $input->getOption('generator-path');
        if ($generatorPath) {
            $generatorPath = rtrim($generatorPath, '/');
            if (file_exists($generatorPath . '/vendor/autoload.php')) {
                require_once $generatorPath . '/vendor/autoload.php';
            }
            $output->writeln("<info>Using custom gapic-generator from:</info> {$generatorPath}");
        } else {
            if (is_dir($this->rootDirectory . 'dev/vendor/google/gapic-generator')) {
                $generatorPath = $this->rootDirectory . 'dev/vendor/google/gapic-generator';
            } else {
                $generatorPath = $this->rootDirectory . 'dev/vendor/google/gapic-generator-php';
            }
            $output->writeln('<info>Using installed gapic-generator dependency.</info>');
        }

        // 2. Resolve Showcase Path (Defaults to vendor dependency)
        $showcasePath = $input->getOption('showcase-path') ?: $this->rootDirectory . 'dev/vendor/google/gapic-showcase';
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

        // 4. Clean up temporary outputs
        $output->writeln('<info>1. Cleaning up existing temporary outputs...</info>');
        $this->fs->remove([$tmpOutputDir, $descFile]);
        $this->fs->mkdir($tmpOutputDir . '/src');

        // 5. Compile Proto Descriptor Set (desc.pb)
        $output->writeln('<info>2. Compiling proto descriptor set (desc.pb)...</info>');
        $allProtoFiles = glob($schemaDir . '/*.proto');
        $generatorProtoFiles = array_values(array_filter(
            $allProtoFiles,
            fn ($file) => !str_ends_with($file, 'messaging.proto')
        ));

        $protocDescCmd = array_merge([
            'protoc',
            '--include_imports',
            '--include_source_info',
            '-I', $showcasePath . '/schema',
            '-I', $googleapisPath,
            '--descriptor_set_out=' . $descFile,
        ], $generatorProtoFiles, [
            $googleapisPath . '/google/cloud/common_resources.proto',
        ]);
        $this->runProcess($protocDescCmd);

        // 6. Generate Showcase PHP Client via CodeGenerator
        $output->writeln('<info>3. Generating Showcase PHP client (NEW_SURFACE_ONLY mode)...</info>');

        $descBytes = file_get_contents($descFile);
        $grpcConfig = file_get_contents($schemaDir . '/showcase_grpc_service_config.json');

        $serviceYaml = file_exists($schemaDir . '/showcase_v1beta1.yaml') ? file_get_contents($schemaDir . '/showcase_v1beta1.yaml') : null;

        $files = CodeGenerator::generateFromDescriptor(
            $descBytes,
            'google.showcase.v1beta1',
            'grpc+rest',
            true,
            $grpcConfig,
            null,
            $serviceYaml,
            false,
            -1,
            false,
            MigrationMode::NEW_SURFACE_ONLY
        );

        foreach ($files as [$relPath, $content]) {
            $fullPath = $tmpOutputDir . '/' . $relPath;
            $this->fs->mkdir(dirname($fullPath));
            file_put_contents($fullPath, $content);
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
        $this->fs->remove([$conformanceDir . '/src/V1beta1', $conformanceDir . '/metadata']);
        $this->fs->mkdir([$conformanceDir . '/src/V1beta1/resources', $conformanceDir . '/metadata']);

        // Copy Client SDK classes
        if (is_dir($tmpOutputDir . '/src/V1beta1')) {
            $this->fs->mirror($tmpOutputDir . '/src/V1beta1', $conformanceDir . '/src/V1beta1');
        }
        // Copy Protobuf Messages
        if (is_dir($tmpOutputDir . '/src/Google/Showcase/V1beta1')) {
            $this->fs->mirror($tmpOutputDir . '/src/Google/Showcase/V1beta1', $conformanceDir . '/src/V1beta1');
        }
        // Copy REST configs
        if (is_dir($tmpOutputDir . '/resources')) {
            $this->fs->mirror($tmpOutputDir . '/resources', $conformanceDir . '/src/V1beta1/resources');
        }
        // Copy Metadata preserving V1Beta1 directory casing
        if (is_dir($tmpOutputDir . '/src/GPBMetadata/Google/Showcase')) {
            $this->fs->mirror($tmpOutputDir . '/src/GPBMetadata/Google/Showcase', $conformanceDir . '/metadata');
        }

        // Exclude deprecated Protobuf flat alias files matching *_* (ignoring resources)
        $deprecatedFinder = (new Finder())->files()->name('*_*.php')->in($conformanceDir . '/src/V1beta1')->notPath('resources');
        $this->fs->remove($deprecatedFinder);

        // 9. Clean up temporary files
        $output->writeln('<info>6. Cleaning up temporary files...</info>');
        $this->fs->remove([$tmpOutputDir, $descFile]);

        $output->writeln("<info>✅ Showcase Client generation complete! Output saved in: {$conformanceDir}</info>");

        return Command::SUCCESS;
    }

    private function runProcess(array $command, ?string $cwd = null): void
    {
        $process = new Process($command, $cwd);
        $process->setTimeout(300);
        $process->mustRun();
    }
}
