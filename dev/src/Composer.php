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

namespace Google\Cloud\Dev;

use GuzzleHttp\Client;
use vierbergenlars\SemVer\SemVerException;
use vierbergenlars\SemVer\version;

/**
 * Creates and manages composer files.
 * @internal
 */
class Composer
{
    private const REQUIRE_PHP = '>=7.4';

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
        "phpunit/phpunit" => "^9.0"
    ];

    /**
     * @var array
     */
    private $defaultSuggests = [
        'ext-grpc' => 'Enables use of gRPC, a universal high-performance RPC framework created by Google.',
        'ext-protobuf' => 'Provides a significant increase in throughput over the pure PHP ' .
            'protobuf implementation. See https://cloud.google.com/php/grpc for installation instructions.'
    ];

    private string $relativePath;
    private string $rootPath;

    public function __construct(
        private string $componentPath,
        private string $composerPackage,
        private string $phpNamespace,
        private string $gpbMetadataNamespace,
    ) {
        $parts = explode('/', $this->componentPath);
        $this->relativePath = array_pop($parts);
        $this->rootPath = implode('/', $parts);
    }

    public function updateMainComposer()
    {
        $rootComposer = $this->rootPath . '/composer.json';
        $composer = json_decode(file_get_contents($rootComposer), true);

        // Add `replace` to main composer file.
        $composer['replace'][$this->composerPackage] = '0.0.0';
        ksort($composer['replace']);

        // Add namespaces to main composer file.
        $composer['autoload']['psr-4'][$this->phpNamespace . '\\'] = $this->relativePath . '/src';
        $composer['autoload']['psr-4'][$this->gpbMetadataNamespace . '\\'] = $this->relativePath . '/metadata';
        ksort($composer['autoload']['psr-4']);

        file_put_contents(
            $rootComposer,
            json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL
        );
    }

    public function createComponentComposer(
        string $displayName,
        string $githubRepo
    ) {
        $composer = [
            'name' => $this->composerPackage,
            'description' => $displayName .' Client for PHP',
            'license' => 'Apache-2.0',
            'minimum-stability' => 'stable',
            'autoload' => [
                'psr-4' => [
                    $this->phpNamespace .'\\' => 'src',
                    $this->gpbMetadataNamespace .'\\' => 'metadata',
                ],
            ],
            'extra' => [
                'component' => [
                    'id' => str_replace('google/', '', $this->composerPackage),
                    'path' => $this->relativePath,
                    'target' => $githubRepo,
                ],
            ],
            'require' => [],
            'require-dev' => [],
            'suggest' => [],
        ];

        $composer['require']['php'] = self::REQUIRE_PHP;
        foreach ($this->defaultDeps as $dep) {
            $composer['require'][$dep] = self::getLatestVersion($dep);
        }

        foreach ($this->defaultDevDeps as $dep => $ver) {
            $composer['require-dev'][$dep] = $ver;
        }

        foreach ($this->defaultSuggests as $dep => $val) {
            $composer['suggest'][$dep] = $val;
        }

        file_put_contents(
            $this->componentPath .'/composer.json',
            json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL
        );
    }

    public static function getLatestVersion($dep)
    {
        $client = new Client();
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
}
