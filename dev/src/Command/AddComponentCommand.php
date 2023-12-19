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
use Google\Cloud\Dev\RunProcess;
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
use Exception;

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
    private const OWLBOT_PHP_IMAGE = 'gcr.io/cloud-devrel-public-resources/owlbot-php:latest';

    private $input;
    private $output;
    private $rootPath;
    private $httpClient;
    private RunProcess $runProcess;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param Client $httpClient specify the HTTP client, useful for tests.
     * @param RunProcess $runProcess Instance to execute Symfony Process commands, useful for tests.
     */
    public function __construct($rootPath, Client $httpClient = null, RunProcess $runProcess = null)
    {
        $this->rootPath = realpath($rootPath);
        $this->httpClient = $httpClient ?: new Client();
        $this->runProcess = $runProcess ?: new RunProcess();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('add-component')
            ->setDescription('Add a Component')
            ->addArgument('proto', InputArgument::REQUIRED, 'Path to service proto.')
            ->addOption(
                'googleapis-gen-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to googleapis-gen repo. Option to generate the library using Owlbot:copy-code'
            )->addOption(
                'bazel-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to bazel (googleapis) workspace. Option to generate the library using Bazel'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $proto = $input->getArgument('proto');
        $protoFile = file_exists($proto) ? substr($proto, strpos($proto, 'google/')) : $proto;
        $new = NewComponent::fromProto($this->loadProtoContent($proto), $protoFile);
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

        $productDocumentation = null;
        $yamlFileContent = $this->loadYamlConfigContent($new, dirname($proto));
        $productDocumentation = $yamlFileContent['publishing']['documentation_uri'] ?? null;
        $productDocumentation = $productDocumentation ?: $this->getHelper('question')->ask(
            $input,
            $output,
            new Question('What is the product documentation URL? ')
        );
        $productHomePage = $this->getHomePageFromDocsUrl($productDocumentation);
        $productHomePage = $productHomePage ?: $this->getHelper('question')->ask(
            $input,
            $output,
            new Question('What is the product homepage? ')
        );

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
                'product_homepage' => $productHomePage,
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

        if ($input->getOption('bazel-path') || $input->getOption('googleapis-gen-path')) {
            $this->validateOptions($input, $output);
            $this->checkDockerAvailable();
            if ($input->getOption('bazel-path')) {
                $googleApisDir = realpath($input->getOption('bazel-path'));
                $output->writeln("\n\nbazel build library");
                $output->writeln($this->bazelQueryAndBuildLibrary(dirname($protoFile), $googleApisDir));
                $output->writeln("\n\nCopying the library code from bazel-bin");
                $output->writeln($this->owlbotCopyBazelBin($new->componentName, $googleApisDir));
            } else {
                $googleApisGenDir = realpath($input->getOption('googleapis-gen-path'));
                $output->writeln("\n\nCopying the library code from googleapis-gen");
                $output->writeln($this->owlbotCopyCode($new->componentName, $googleApisGenDir));
            }
            // run owlbot post-processor if a bazel-path or googleapis-gen-path was supplied
            $output->writeln("\n\nOwlbot post processing");
            $output->writeln($this->owlbotPostProcessor());
        }

        $output->writeln('');
        $output->writeln('');
        $output->writeln('Success!');

        return 0;
    }

    private function validateOptions(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getOption('bazel-path') && $input->getOption('googleapis-gen-path')) {
            throw new \InvalidArgumentException(
                'The options --googleapis-gen-path and --bazel-path cannot be used together.' .
                ' Please provide only one path option.'
            );
        }
    }

    private function loadYamlConfigContent(NewComponent $new, string $protoDir): ?array
    {
        $yamlFilePath = sprintf('%s/%s%s%s.yaml',
            $protoDir,
            strtolower($new->shortName),
            $new->version ? '_' : '',
            $new->version ?? ''
        );

        try {
            return Yaml::parse($this->loadProtoContent($yamlFilePath));
        } catch (Exception $e) {
            // Handle error gracefully.
            return null;
        }
    }

    private function loadProtoContent(string $proto): string
    {
        if (file_exists($proto)) {
            return file_get_contents($proto);
        }
        $protoUrl = 'https://raw.githubusercontent.com/googleapis/googleapis/master/' . $proto;
        $response = $this->httpClient->get($protoUrl);
        return (string) $response->getBody();
    }

    private function bazelQueryAndBuildLibrary(string $protoDir, string $googleApisDir): string
    {
        $command = ['bazel', '--version'];
        $output = $this->runProcess->execute($command);
        // Extract the version number from the output
        $match = preg_match('/bazel\s+(?P<version>\d+\.\d+\.\d+)/', $output, $matches);
        if (!$match || $matches['version'] !== self::BAZEL_VERSION) {
            throw new RuntimeException('Bazel 6.0.0 is not available');
        }

        $command = [
            'bazel',
            'query',
            'filter("-(php)$", kind("rule", //' . $protoDir .'/...:*))'
        ];
        $output = $this->runProcess->execute($command, $googleApisDir);
        // Get componenets starting with //google/ and
        // not ending with :(proto|grpc|gapic)-.*-php
        $components = array_filter(
            explode("\n", $output),
            fn ($line) => $line && preg_match('/^\/\/google\/(?!:(proto|grpc|gapic)-.*-php$)/', $line)
        );
        if (count($components) !== 1) {
            throw new Exception(
                'expected only one bazel component, found ' .
                (implode(' ', $components) ?: '0')
            );
        }

        $command = ['bazel', 'build', $components[0]];
        return $this->runProcess->execute($command, $googleApisDir);
    }

    private function owlbotCopyCode(string $componentName, string $googleApisGenDir): string
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
            '-v',
            $googleApisGenDir . ':/googleapis-gen',
            '-w',
            '/repo',
            '--env',
            'HOME=/tmp',
            self::OWLBOT_CLI_IMAGE,
            'copy-code',
            sprintf('--config-file=%s/.OwlBot.yaml', $componentName),
            '--source-repo=/googleapis-gen'
        ];
        return $this->runProcess->execute($command);
    }

    private function owlbotCopyBazelBin(string $componentName, string $googleApisDir): string
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
            '-v',
            $googleApisDir . '/bazel-bin:/bazel-bin',
            self::OWLBOT_CLI_IMAGE,
            'copy-bazel-bin',
            sprintf('--config-file=%s/.OwlBot.yaml', $componentName),
            '--source-dir',
            '/bazel-bin',
            '--dest',
            '/repo'
        ];
        return $this->runProcess->execute($command);
    }

    private function owlbotPostProcessor(): string
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
        return $this->runProcess->execute($command);
    }

    private function getHomePageFromDocsUrl(?string $url): ?string
    {
        $productHomePage = !empty($url) ? explode('/docs', $url)[0] : null;
        $response = $this->httpClient->get($productHomePage, ['http_errors' => false]);
        return $response->getStatusCode() >= 400 ? null : $productHomePage;
    }

    private function checkDockerAvailable(): void
    {
        $command = ['which', 'docker'];
        $output = $this->runProcess->execute($command);
        if (strlen($output) == 0) {
            throw new RuntimeException(
                'Error: Docker is not available.'
            );
        }
    }

    private function getUserAndGroupId(): array
    {
        // Get the user ID and group ID
        $userId = posix_getuid();
        $groupId = posix_getgid();
        return [$userId, $groupId];
    }
}
