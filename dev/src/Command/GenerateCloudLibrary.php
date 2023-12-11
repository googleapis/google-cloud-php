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
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use GuzzleHttp\Client;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use RuntimeException;

/**
 * Generate a Cloud Library
 * @internal
 */
class GenerateCloudLibrary extends Command
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
        $this->setName('generate-library')
            ->setDescription('Generate a Cloud Library')
            ->addArgument('proto', InputArgument::REQUIRED, 'Path to service proto.');
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

        $version = basename(dirname($proto));
        // yaml file contains documentation_uri and
        // it is available at the same location as proto file
        $libraryName = strtolower($new->componentName);
        $yamlFileName = $libraryName . '_' . $version . '.yaml';
        $yamlFilePath = dirname($proto) . '/' . $yamlFileName;
        $googleApisDir = explode('/google/', $yamlFilePath)[0];
        if (file_exists($yamlFilePath)) {
            $yamlFileContent = file_get_contents($yamlFilePath);
            preg_match('/(?i)^.*\bdocumentation_uri\b.*$/m', $yamlFileContent, $matches);
            $productDocumentation = explode('documentation_uri: ', $matches[0])[1];
            $productHomepage = explode('/docs', $productDocumentation)[0];
        } else {
            exit("Something went wrong, Please use the add-component command instead.\n");
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

        $this->bazelBuildLibrary($libraryName, $googleApisDir);
        $output->writeln('');
        $this->copyBazelOutToGoogleCloudPhp($new->componentName, $googleApisDir, $output);
        $output->writeln('');
        $this->postProcess();

        $output->writeln('');
        $output->writeln('');
        $output->writeln('Success!');

        return 0;
    }

    private function loadProtoContent(string $proto): string
    {
        if (file_exists($proto)) {
            return file_get_contents($proto);
        }
        $protoUrl = 'https://raw.githubusercontent.com/googleapis/googleapis/master/' . $proto;
        $client = new Client();
        $response = $client->get($protoUrl);
        return (string) $response->getBody();
    }

    private function extractDocumentationUriFromYamlContents(string $protoContents): ?string
    {
        if (!preg_match('/option php_namespace = "(.*)";/', $protoContents, $matches)) {
            return null;
        }
        // Remove version from namespace
        $parts = explode('\\\\', $matches[1]);
        $version = array_pop($parts);
        if ('v' !== strtolower($version[0])) {
            $parts[] = $version;
        }

        return implode('\\', $parts);
    }

    private function bazelBuildLibrary(string $libraryName, string $googleApisDir): bool
    {
        $command = 'which bazel';
        $output = exec($command, $output, $return);
        if (strlen($output) == 0) {
            exit("Error: Bazel is not installed. Please install Bazel before running this script.\n");
        }
        chdir($googleApisDir);
        $command = "bazel query 'filter(\"-(php)$\", kind(\"rule\", //google/cloud/" . $libraryName .
            "/...:*))' | grep -v -E \":(proto|grpc|gapic)-.*-php$\"";
        exec($command, $output, $return);
        if ($return === 0 && !empty($output)) {
            $command = "bazel build " . $output[0];
            exec($command, $output, $return);
            if ($return === 0) {
                chdir($this->rootPath);
                return true;
            }
        }
        chdir($this->rootPath);
        exit("Something went wrong at bazelBuildLibrary, Please use the add-component command instead.\n");
    }

    private function copyBazelOutToGoogleCloudPhp(string $componentName, string $googleApisDir): bool
    {
        $command = 'which docker';
        $output = exec($command, $output, $return);
        if (strlen($output) == 0) {
            exit("Error: Docker is not installed. Please install Docker before running this script.\n");
        }
        $googleApisDir = realpath($googleApisDir);
        $owlbotImage = "gcr.io/cloud-devrel-public-resources/owlbot-cli:latest";
        $command = "docker run --rm --user $(id -u):$(id -g) -v " . $this->rootPath .
        ":/repo -v " . $googleApisDir . "/bazel-bin:/bazel-bin " . $owlbotImage .
        " copy-bazel-bin --config-file=" . $componentName . "/.OwlBot.yaml --source-dir /bazel-bin --dest /repo >&2";
        exec($command, $output, $return);
        if ($return === 0) {
            return true;
        }
        exit("Something went wrong at copyBazelOutToGoogleCloudPhp, Please use the add-component command instead.\n");
    }

    private function postProcess()
    {
        $command = "docker run --user $(id -u):$(id -g) --rm " .
        "-v " . $this->rootPath .":/repo " .
        "-w /repo gcr.io/cloud-devrel-public-resources/owlbot-php >&2";
        exec($command, $output, $return);
        if ($return === 0) {
            return true;
        }
        exit("Something went wrong at postProcess, Please use the add-component command instead.\n");
    }
}
