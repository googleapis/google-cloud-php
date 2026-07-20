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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Generate Showcase Client SDK for GAX Conformance Tests.
 *
 * @internal
 */
class GaxGenerateShowcaseCommand extends Command
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
        $this->setName('gax:generate-showcase')
            ->setDescription('Generates the GAPIC Showcase client SDK for GAX Conformance tests')
            ->addOption(
                'generator-path',
                'g',
                InputOption::VALUE_REQUIRED,
                'Path to gapic-generator-php repository (or set GAPIC_GENERATOR_PHP_PATH env var)'
            )
            ->addOption(
                'googleapis-path',
                'a',
                InputOption::VALUE_REQUIRED,
                'Path to googleapis repository (or set GOOGLEAPIS_PATH env var)'
            )
            ->addOption(
                'showcase-path',
                'p',
                InputOption::VALUE_REQUIRED,
                'Path to local gapic-showcase repository (or set SHOWCASE_PATH env var)'
            )
            ->addOption(
                'showcase-version',
                's',
                InputOption::VALUE_REQUIRED,
                'Specify a custom gapic-showcase release tag (e.g. v0.41.1)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gaxDir = $this->rootDirectory . 'Gax';
        $conformanceDir = $gaxDir . '/tests/Conformance';
        $tmpShowcaseDir = $conformanceDir . '/tmp_showcase';
        $tmpGoogleapisDir = $conformanceDir . '/tmp_googleapis';
        $tmpOutputDir = $conformanceDir . '/tmp_out';
        $descFile = $conformanceDir . '/desc.pb';

        // 1. Resolve Generator Path
        $generatorPath = $input->getOption('generator-path')
            ?: getenv('GAPIC_GENERATOR_PHP_PATH');

        if (!$generatorPath || !file_exists($generatorPath . '/vendor/autoload.php')) {
            $output->writeln('<error>Error: gapic-generator-php not found.</error>');
            $output->writeln('Please specify the path using <comment>--generator-path <dir></comment> or set the <comment>GAPIC_GENERATOR_PHP_PATH</comment> environment variable.');
            return Command::FAILURE;
        }

        // 2. Resolve Googleapis Path (Auto-fetch if not provided)
        $googleapisPath = $input->getOption('googleapis-path')
            ?: getenv('GOOGLEAPIS_PATH');

        if (!$googleapisPath || !is_dir($googleapisPath . '/google/cloud')) {
            $output->writeln('<info>Fetching googleapis definitions from GitHub...</info>');
            $this->fs->remove($tmpGoogleapisDir);
            $this->runProcess(['git', 'clone', '--depth', '1', 'https://github.com/googleapis/googleapis.git', $tmpGoogleapisDir]);
            if (is_dir($tmpGoogleapisDir . '/google/cloud')) {
                $googleapisPath = $tmpGoogleapisDir;
            }
        }

        if (!$googleapisPath || !is_dir($googleapisPath . '/google/cloud')) {
            $output->writeln('<error>Error: googleapis directory not found.</error>');
            $output->writeln('Please specify the path using <comment>--googleapis-path <dir></comment> or set the <comment>GOOGLEAPIS_PATH</comment> environment variable.');
            return Command::FAILURE;
        }

        // 3. Resolve Showcase Schemas
        $output->writeln('<info>1. Resolving gapic-showcase schemas...</info>');
        $showcasePath = $input->getOption('showcase-path') ?: getenv('SHOWCASE_PATH');
        $showcaseVersion = $input->getOption('showcase-version') ?: getenv('SHOWCASE_VERSION');
        $resolvedTag = null;
        $showcaseDir = null;

        if ($showcasePath && is_dir($showcasePath . '/schema/google/showcase/v1beta1')) {
            $showcaseDir = $showcasePath;
            $output->writeln("Using specified local gapic-showcase path: <comment>{$showcaseDir}</comment>");
        } else {
            if ($showcaseVersion) {
                $resolvedTag = $showcaseVersion;
            } else {
                $output->writeln('Querying GitHub for latest gapic-showcase release tag...');
                $releaseJson = @file_get_contents(
                    'https://api.github.com/repos/googleapis/gapic-showcase/releases/latest',
                    false,
                    stream_context_create(['http' => ['header' => "User-Agent: PHP\r\n"]])
                );
                if ($releaseJson && ($data = json_decode($releaseJson, true)) && isset($data['tag_name'])) {
                    $resolvedTag = $data['tag_name'];
                }
            }

            if ($resolvedTag) {
                $output->writeln("Fetching gapic-showcase schema for tag: <comment>{$resolvedTag}</comment>...");
                $this->fs->remove($tmpShowcaseDir);
                $this->runProcess(['git', 'clone', '--depth', '1', '--branch', $resolvedTag, 'https://github.com/googleapis/gapic-showcase.git', $tmpShowcaseDir]);
                if (is_dir($tmpShowcaseDir . '/schema/google/showcase/v1beta1')) {
                    $showcaseDir = $tmpShowcaseDir;
                }
            }
        }

        if (!$showcaseDir) {
            $output->writeln('<error>Error: Unable to resolve gapic-showcase schemas.</error>');
            $output->writeln('Please specify a local path using <comment>--showcase-path <dir></comment> or ensure internet access to fetch from GitHub.');
            return Command::FAILURE;
        }

        $schemaDir = $showcaseDir . '/schema/google/showcase/v1beta1';

        // 4. Clean up temporary outputs
        $output->writeln('<info>2. Cleaning up existing temporary outputs...</info>');
        $this->fs->remove([$tmpOutputDir, $descFile]);
        $this->fs->mkdir($tmpOutputDir . '/src');

        // 5. Compile Proto Descriptor Set (desc.pb)
        $output->writeln('<info>3. Compiling proto descriptor set (desc.pb)...</info>');
        $protocDescCmd = [
            'protoc',
            '--include_imports',
            '--include_source_info',
            '-I', $showcaseDir . '/schema',
            '-I', $googleapisPath,
            '--descriptor_set_out=' . $descFile,
            $schemaDir . '/echo.proto',
            $schemaDir . '/identity.proto',
            $schemaDir . '/compliance.proto',
            $schemaDir . '/sequence.proto',
            $schemaDir . '/testing.proto',
            $googleapisPath . '/google/cloud/common_resources.proto',
        ];
        $this->runProcess($protocDescCmd);

        // 6. Generate GAPIC PHP Client via CodeGenerator
        $output->writeln('<info>4. Generating GAPIC PHP client for GAX (gRPC + REST, NEW_SURFACE_ONLY mode)...</info>');
        require_once $generatorPath . '/vendor/autoload.php';

        $descBytes = file_get_contents($descFile);
        $grpcConfig = file_get_contents($schemaDir . '/showcase_grpc_service_config.json');

        /** @var class-string $codeGeneratorClass */
        $codeGeneratorClass = 'Google\Generator\CodeGenerator';
        /** @var class-string $migrationModeClass */
        $migrationModeClass = 'Google\Generator\Utils\MigrationMode';

        $files = $codeGeneratorClass::generateFromDescriptor(
            $descBytes,
            'google.showcase.v1beta1',
            'grpc+rest',
            false,
            $grpcConfig,
            null,
            null,
            false,
            -1,
            false,
            $migrationModeClass::NEW_SURFACE_ONLY
        );

        foreach ($files as [$relPath, $content]) {
            $fullPath = $tmpOutputDir . '/' . $relPath;
            $this->fs->mkdir(dirname($fullPath));
            file_put_contents($fullPath, $content);
        }

        // 7. Generate Protobuf Message Classes via protoc --php_out
        $output->writeln('<info>5. Generating Protobuf message classes...</info>');
        $protoFiles = glob($schemaDir . '/*.proto');
        $protocPhpCmd = array_merge([
            'protoc',
            '-I', $showcaseDir . '/schema',
            '-I', $googleapisPath,
            '--php_out=' . $tmpOutputDir . '/src',
        ], $protoFiles);
        $this->runProcess($protocPhpCmd);

        // 8. Organize output into GAX Conformance directory
        $output->writeln('<info>6. Organizing output into GAX Conformance directory...</info>');
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

        // 9. Clean up temporary files
        $output->writeln('<info>7. Cleaning up temporary files...</info>');
        $this->fs->remove([$tmpOutputDir, $descFile, $tmpShowcaseDir, $tmpGoogleapisDir]);

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
