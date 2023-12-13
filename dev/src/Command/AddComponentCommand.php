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

use Google\Cloud\Dev\Composer;
use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\NewComponent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use RuntimeException;

/**
 * Add a Component
 * @internal
 */
class AddComponentCommand extends Command
{
    private const TEMPLATE_DIR = __DIR__ . '/../../templates';
    private const COPY_FILES = [
        '.gitattributes',
        'CONTRIBUTING.md',
        'LICENSE',
        'VERSION'
    ];
    private const TEMPLATE_FILES = [
        '.github/pull_request_template.md.twig',
        '.OwlBot.yaml.twig',
        'owlbot.py.twig',
        'phpunit.xml.dist.twig',
        'README.md.twig',
    ];
    private const BAZEL_VERSION = '6.0.0';
    private const OWLBOT_CLI_IMAGE = 'gcr.io/cloud-devrel-public-resources/owlbot-cli:latest';
    private const OWLBOT_PHP_IMAGE = 'gcr.io/cloud-devrel-public-resources/owlbot-php';

    private $input;
    private $output;
    private $rootPath;

    /**
     * @param string $rootPath The path to the repository root directory.
     */
    public function __construct($rootPath)
    {
        $this->rootPath = realpath($rootPath);
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('add-component')
            ->setDescription('Add a Component')
            ->addArgument('proto', InputArgument::REQUIRED, 'Path to service proto.')
            ->addOption(
                'run-owlbot',
                null,
                InputOption::VALUE_NONE,
                'The command to generate the library using Owlbot'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $proto = $input->getArgument('proto');
        $protoFile = file_exists($proto) ? substr($proto, strpos($proto, 'google/')) : $proto;
        $new = NewComponent::fromProto($this->loadRawFileContent($proto), $protoFile);
        $new->componentPath = $this->rootPath;

        $output->writeln(''); // blank line
        $output->writeln(sprintf('Your package (%s) will have the following info:', $protoFile));

        $f = fn($f, $v) => ["<info>$f</info>", $v];
        $newArray = (array) $new;

        (new Table($output))
            ->setRows(array_map($f, array_keys($newArray), $newArray))
            ->render();

        while (
            !$this->getHelper('question')->ask(
                $input,
                $output,
                new ConfirmationQuestion('Does this information look correct? ("n" to customize) [Y/n] ', 'Y')
            )
        ) {
            foreach ($new as $field => $val) {
                $new->$field = $this->getHelper('question')->ask(
                    $input,
                    $output,
                    new Question(sprintf('What is the %s? (ENTER for "%s") ', $field, $val), $val)
                );
            }
            $newArray = (array) $new;
            (new Table($output))
                ->setRows(array_map($f, array_keys($newArray), $newArray))
                ->render();
        }

        $version = basename(dirname($proto));
        // yaml file contains documentation_uri and
        // it is available at the same location as proto file
        $yamlFilePath = sprintf('%s/%s_%s.yaml',
            dirname($proto),
            strtolower($new->shortName),
            $version
        );
        $googleApisDir = realpath(explode('/google/', $yamlFilePath)[0]);
        $productHomePage = null;
        $yamlFileContent = $this->loadRawFileContent($yamlFilePath);
        if (!empty($yamlFileContent)) {
            $yamlFileContents = $yamlFileContents = Yaml::parse($yamlFileContent);
            $productDocumentation = $yamlFileContents['publishing']['documentation_uri'] ?? null;
            $productHomePage = !empty($productDocumentation) ? explode('/docs', $productDocumentation)[0] : null;
        }
        if ($this->isProductHomePageMissing($productHomePage)) {
            $productHomepage = $this->getHelper('question')->ask(
                $input,
                $output,
                new Question('What is the product homepage? ')
            );
            $productDocumentation = $this->getHelper('question')->ask(
                $input,
                $output,
                new Question('What is the product documentation URL? ')
            );
        }

        $documentationUrl = $new->getDocumentationUrl();

        // Make the component dir if it doesn't exist
        $componentDir = $new->componentPath . '/' . $new->componentName;
        if (!is_dir($componentDir)) {
            if (!mkdir($componentDir, 0777, true)) {
                throw new \Exception('Unable to make Component dir: ' . $componentDir);
            }
        }

        // Copy over static files
        $filesystem = new Filesystem();
        foreach (self::COPY_FILES as $file) {
            $output->writeln(sprintf('<info>%s</info> Creating %s by copying from template dir.', $file, $file));
            $filesystem->copy(self::TEMPLATE_DIR . '/' . $file, $componentDir . '/' . $file);
        }

        // Render twig templates
        $loader = new FilesystemLoader(self::TEMPLATE_DIR);
        $twig = new Environment($loader);
        foreach (self::TEMPLATE_FILES as $template) {
            $file = str_replace('.twig', '', $template);
            $output->writeln(sprintf('<info>%s</info> Creating %s from twig template.', $file, $file));
            $filesystem->dumpFile($componentDir . '/' . $file, $twig->render($template, [
                'name' => $new->displayName,
                'component' => $new->componentName,
                'package' => $new->composerPackage,
                'repo' => $new->githubRepo,
                'proto_path' => $new->protoPath,
                'version' => $new->version,
                'github_repo' => $new->githubRepo,
                'documentation' => $documentationUrl,
                'product_homepage' => $productHomepage,
                'product_documentation' => $productDocumentation,
            ]));
        }

        // Write repo metadata JSON
        $output->writeln('<info<Repo Metadata</info> Writing .repo-metadata.json');
        $repoMetadata = [
            'language' => 'php',
            'distribution_name' => $new->composerPackage,
            'release_level' => 'preview',
            'client_documentation' => $documentationUrl,
            'library_type' => 'GAPIC_AUTO',
            'api_shortname' => $new->shortName
        ];
        $contents = json_encode($repoMetadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $filesystem->dumpFile($componentDir . '/.repo-metadata.json', $contents . PHP_EOL);

        // Write composer file
        $output->writeln('<info>Composer</info> Updating root composer.json and creating component composer.json');
        $composer = new Composer(
            $componentDir,
            $new->composerPackage,
            $new->phpNamespace,
            $new->gpbMetadataNamespace
        );
        $composer->updateMainComposer();
        $composer->createComponentComposer($new->displayName, $new->githubRepo);

        if ($input->getOption('run-owlbot')) {
            $output->write("\n\nBuilding the library using Bazel\n");
            $output->write($this->bazelBuildLibrary($new->shortName, $googleApisDir, $new->protoPath));
            $output->write("\n\nCopying the Bazel output to the Google Cloud PHP directory\n");
            $output->write($this->copyBazelOutToGoogleCloudPhp($new->componentName, $googleApisDir, $output));
            $output->write("\n\nOwlbot post processing\n");
            $output->write($this->postProcess());
        }

        $output->writeln('');
        $output->writeln('');
        $output->writeln('Success!');

        return 0;
    }

    private function loadRawFileContent(string $file): string
    {
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        if (count(explode('googleapis/', $file)) == 1) {
            $fileUrlPath = $file;
        } else {
            $fileUrlPath = explode('googleapis/', $file)[1];
        }
        $fileUrl = 'https://raw.githubusercontent.com/googleapis/googleapis/master/' . $fileUrlPath;
        $client = new Client();
        try {
            $response = $client->get($fileUrl);
        } catch (\Exception $e) {
            // Handle error gracefully
            return '';
        }
        return (string) $response->getBody();
    }

    private function bazelBuildLibrary(string $libraryName, string $googleApisDir, string $protoPath): string
    {
        $command = ['bazel', '--version'];
        $output = $this->runCommand($command);
        $component = explode($libraryName, $protoPath)[0];
        // Extract the version number from the output
        $match = preg_match('/bazel\s+(?P<version>\d+\.\d+\.\d+)/', $output, $matches);
        if (!$match || $matches['version'] !== self::BAZEL_VERSION) {
            throw new RuntimeException('Bazel 6.0.0 is not available');
        }
        $command = [
            'bazel',
            'query',
            'filter("-(php)$", kind("rule", //' . $component . $libraryName .'/...:*))'
        ];
        $output = $this->runCommand($command, $googleApisDir);
        $command = ['grep', '-v', '-E', ':(proto|grpc|gapic)-.*-php$'];
        $output = $this->runCommand($command, $googleApisDir, $output);
        // @TODO: Some non printable characters are included in the output, why!
        $output = preg_replace('/[^[:print:]]/', '', $output);
        $command = ['bazel', 'build', $output];
        return $this->runCommand($command, $googleApisDir, null, 'errorOutput');
    }

    private function copyBazelOutToGoogleCloudPhp(string $componentName, string $googleApisDir): string
    {
        $command = ['which', 'docker'];
        $output = $this->runCommand($command);
        if (strlen($output) == 0) {
            throw new RuntimeException(
                'Error: Docker is not available.'
            );
        }
        list($userId, $groupId) = $this->getUserAndGroupId();
        $command = [
            'docker',
            'run',
            '--rm',
            '--user',
            sprintf('%s::%s', $userId, $groupId),
            '-v',
            $this->rootPath . ':/repo',
            '-v',
            $googleApisDir . '/bazel-bin:/bazel-bin',
            self::OWLBOT_CLI_IMAGE,
            'copy-bazel-bin',
            '--config-file',
            $componentName . '/.OwlBot.yaml',
            '--source-dir',
            '/bazel-bin',
            '--dest',
            '/repo'
        ];
        return $this->runCommand($command, $googleApisDir);
    }

    private function postProcess()
    {
        list($userId, $groupId) = $this->getUserAndGroupId();
        $command = [
            'docker',
            'run',
            '--rm',
            '--user',
            sprintf('%s::%s', $userId, $groupId),
            '-v',
            $this->rootPath . ':/repo',
            '-w',
            '/repo',
            self::OWLBOT_PHP_IMAGE
        ];
        return $this->runCommand($command, null, null, 'errorOutput');
    }

    private function isProductHomePageMissing(?string $productHomePage): bool
    {
        $client = new Client();
        if (!$productHomePage) {
            return true;
        }

        try {
            $response = $client->request('GET', $productHomePage, ['http_errors' => false]);
            return $response->getStatusCode() === 404;
        } catch (\Exception $e) {
            // Handle error gracefully
            return true;
        }
    }

    private function getUserAndGroupId() {
        // Get the user ID and group ID
        $userId = posix_getuid();
        $groupId = posix_getgid();
        return [$userId, $groupId];
    }

    private function runCommand(
        array $command,
        ?string $workDir = null,
        ?string $input = null,
        ?string $outputType = null
    ): string
    {
        $process = new Process($command);
        if (!is_null($workDir)) {
            $process->setWorkingDirectory($workDir);
        }
        if (!is_null($input)) {
            $process->setInput($input);
        }
        // `mustRun` will throw a ProcessFailedException if the process
        // couldn't be executed successfully.
        $process->mustRun();
        if ($outputType == 'errorOutput') {
            return $process->getErrorOutput();
        }
        return $process->getOutput();
    }
}
