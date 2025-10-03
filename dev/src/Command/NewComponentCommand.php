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
use Google\Cloud\Dev\NewComponent;
use Google\Cloud\Dev\RunProcess;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use RuntimeException;
use Exception;
use Google\Cloud\Dev\Component;

/**
 * Add a Component
 * @internal
 */
class NewComponentCommand extends Command
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

    private $rootPath;
    private $httpClient;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param Client $httpClient specify the HTTP client, useful for tests.
     */
    public function __construct($rootPath, ?Client $httpClient = null)
    {
        $this->rootPath = realpath($rootPath);
        $this->httpClient = $httpClient ?: new Client();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('new-component')
            ->setDescription('Add a new Component')
            ->addArgument('proto', InputArgument::REQUIRED, 'Path to service proto.')
            ->addOption(
                'no-update-component',
                null,
                InputOption::VALUE_NONE,
                'Do not run the update-component command after adding the component skeleton'
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_REQUIRED,
                'The timeout limit for executing commands in seconds. Defaults to 60.',
                120
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $proto = $input->getArgument('proto');
        $protoFile = file_exists($proto) ? substr($proto, strpos($proto, 'google/')) : $proto;
        $new = NewComponent::fromProto($this->loadProtoContent($proto), $protoFile);
        $new->componentPath = $this->rootPath;

        if (is_dir($this->rootPath . '/' . $new->componentName)) {
            // component already exists
            $output->writeln(''); // blank line
            if (!$this->getHelper('question')->ask($input, $output, new ConfirmationQuestion(
                sprintf('Component %s already exists. Overwrite it? [Y/n]', $new->componentName),
                'Y'
            ))) {
                return 0;
            }
        }

        $unsafeTimeout = $input->getOption('timeout');
        if (!is_numeric($unsafeTimeout)) {
            throw new RuntimeException(
                'Error: The timeout option must be a positive integer'
            );
        }
        $timeout = (int) $unsafeTimeout;

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
        $output->writeln('<info<Repo Metadata</info> Writing to .repo-metadata-full.json');
        $repoMetadata = [
            'language' => 'php',
            'distribution_name' => $new->composerPackage,
            'release_level' => 'preview',
            'client_documentation' => $documentationUrl,
            'library_type' => 'GAPIC_AUTO',
            'api_shortname' => $new->shortName
        ];
        $repoMetadataFullPath = $this->rootPath . '/.repo-metadata-full.json';
        $repoMetadataFull = json_decode(file_get_contents($repoMetadataFullPath), true);
        $repoMetadataFull[$new->componentName] = $repoMetadata;
        ksort($repoMetadataFull);
        file_put_contents(
            $repoMetadataFullPath,
            json_encode($repoMetadataFull, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
        );

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

        if (!$input->getOption('no-update-component')) {
            $args = [
                'component' => $new->componentName,
                '--timeout' => $timeout,
            ];
            if (!$this->getApplication()->has('update-component')) {
                throw new \RuntimeException(
                    'Application does not have an update-component command. '
                    . 'Run with --no-update-component to skip this.'
                );
            }
            $updateCommand = $this->getApplication()->find('update-component');
            $returnCode = $updateCommand->run(new ArrayInput($args), $output);
            if ($returnCode !== Command::SUCCESS) {
                return $returnCode;
            }
            $addSamplesArgs = ['--component' => [$new->componentName]];
            $addSampleCommand = $this->getApplication()->find('add-sample-to-readme');
            $returnCode = $addSampleCommand->run(new ArrayInput($addSamplesArgs), $output);
            if ($returnCode !== Command::SUCCESS) {
                return $returnCode;
            }
        }

        $output->writeln('');
        $output->writeln('');
        $output->writeln('Success!');

        return 0;
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

    private function getHomePageFromDocsUrl(?string $url): ?string
    {
        $productHomePage = !empty($url) ? explode('/docs', $url)[0] : null;
        $response = $this->httpClient->get($productHomePage, ['http_errors' => false]);
        return $response->getStatusCode() >= 400 ? null : $productHomePage;
    }

    private function getUserAndGroupId(): array
    {
        // Get the user ID and group ID
        $userId = posix_getuid();
        $groupId = posix_getgid();
        return [$userId, $groupId];
    }
}
