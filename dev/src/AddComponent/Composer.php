<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Dev\AddComponent;

use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use vierbergenlars\SemVer\SemVerException;
use vierbergenlars\SemVer\version;

/**
 * Creates and manages composer files.
 */
class Composer
{
    use PathTrait;
    use QuestionTrait;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $info;

    /**
     * @var array
     */
    private $defaultDeps = [
        'google/gax'
    ];

    /**
     * @var array
     */
    private $defaultDevDeps = [
        "phpunit/phpunit" => "^4.8|^5.0",
        "google/cloud-core" => "^1.14",
        "phpdocumentor/reflection" => "^3.0"
    ];

    /**
     * @var array
     */
    private $defaultSuggests = [
        'ext-grpc' => 'Enables use of gRPC, a universal high-performance RPC framework created by Google.',
        'ext-protobuf' => 'Provides a significant increase in throughput over the pure PHP ' .
            'protobuf implementation. See https://cloud.google.com/php/grpc for installation instructions.'
    ];

    public function __construct(
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output,
        $rootPath,
        array $info
    ) {
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
        $this->rootPath = $rootPath;
        $this->path = $info['path'];
        $this->info = $info;
    }

    public function run()
    {
        $this->updateMainComposer();
        $this->createComponentComposer();
    }

    private function updateMainComposer()
    {
        $path = $this->rootPath .'/composer.json';
        $composer = json_decode(file_get_contents($path), true);
        $composer['replace']['google/'. $this->info['name']] = 'master';
        ksort($composer['replace']);

        file_put_contents($path, json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }

    private function createComponentComposer()
    {
        $composer = [];
        $composer['name'] = 'google/'. $this->info['name'];
        $composer['description'] = $this->ask(
            'Enter a description for this component.',
            $this->info['display'] .' Client for PHP'
        );
        $composer['license'] = 'Apache-2.0';
        $composer['minimum-stability'] = 'stable';

        $parts = explode('/', $this->path);
        $last = array_pop($parts);
        $namespace = $this->ask(
            'Enter the component base namespace, relative to `Google\\Cloud\\`.',
            $last
        );
        $composer['autoload']['psr-4'] = [
            'Google\\Cloud\\' . $namespace .'\\' => 'src',
            // This will need manual fixing in many cases
            // TODO: derive the correct value somehow
            'GPBMetadata\\Google\\Cloud\\' . $namespace .'\\' => 'metadata'
        ];
        $composer['autoload-dev']['psr-4'] = [
            'Google\\Cloud\\' . $namespace .'\\Tests\\' => 'tests'
        ];

        $target = $this->ask(
            'Enter the remote repository target, relative to the hostname. ' .
            'For `git@github.com:foo/bar.git`, enter `foo/bar.git`.',
            'GoogleCloudPlatform/google-cloud-php-'. str_replace('cloud-', '', $this->info['name']) .'.git'
        );

        $entry = $this->ask(
            'Enter the entry service for the component, relative to the folder. ' .
            'For instance, for path `Foo/src/FooClient.php`, enter `src/FooClient.php`. ' .
            'Gapic-only clients should leave this blank.'
        );

        $composer['extra']['component'] = [
            'id' => $this->info['name'],
            'path' => $last,
            'entry' => $entry ?: null,
            'target' => $target
        ];

        foreach ($this->defaultDeps as $dep) {
            $confirm = $this->confirm(sprintf('Should `%s` be required?', $dep));
            if (!$this->askQuestion($confirm)) {
                continue;
            }

            $version = $this->askForVersion($dep);

            $composer['require'][$dep] = $version;
        }

        $hasMoreDependencies = true;
        do {
            $dep = $this->ask('Enter the next dependency name, or leave blank if done.');
            if (!$dep) {
                $hasMoreDependencies = false;
            } else {
                $version = $this->askForVersion($dep);

                $composer['require'][$dep] = $version;
            }
        } while ($hasMoreDependencies);

        foreach ($this->defaultDevDeps as $dep => $ver) {
            if (array_key_exists('require', $composer) && array_key_exists($dep, $composer['require'])) {
                continue;
            }

            $confirm = $this->confirm(sprintf('Should `%s` be included in require-dev?', $dep));
            if (!$this->askQuestion($confirm)) {
                continue;
            }

            if (!isset($composer['require-dev'])) {
                $composer['require-dev'] = [];
            }

            $composer['require-dev'][$dep] = $ver;
        }

        foreach ($this->defaultSuggests as $dep => $val) {
            if (array_key_exists('require', $composer) && array_key_exists($dep, $composer['require'])) {
                continue;
            }

            $confirm = $this->confirm(sprintf('Should `%s` be suggested?', $dep));
            if (!$this->askQuestion($confirm)) {
                continue;
            }

            if (!isset($composer['suggest'])) {
                $composer['suggest'] = [];
            }

            $composer['suggest'][$dep] = $val;
        }

        file_put_contents(
            $this->path .'/composer.json',
            json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL
        );
    }

    private function askForVersion($dep)
    {
        if (strpos($dep, 'ext-') !== false) {
            $defaultVersion = '*';
        } else {
            $defaultVersion = $this->getLatestVersion($dep);
        }

        return $this->ask('Enter the version to require', $defaultVersion);
    }

    private function getLatestVersion($dep)
    {
        $client = new Client;
        $uri = 'https://packagist.org/packages/'. $dep .'.json';
        $pkg = $client->request('GET', $uri);

        $versions = json_decode($pkg->getBody(), true)['package']['versions'];
        $def = null;
        foreach (array_keys($versions) as $v) {
            if (strpos($v, 'dev-') !== false) {
                continue;
            }

            try {
                $version = new version($v);
            } catch (SemVerException $e) {
                continue;
            }

            $def = sprintf(
                '^%d.%d.0',
                $version->getMajor(),
                $version->getMinor()
            );

            break;
        }

        return $def;
    }

    protected function questionHelper()
    {
        return $this->questionHelper;
    }

    protected function input()
    {
        return $this->input;
    }

    protected function output()
    {
        return $this->output;
    }
}
