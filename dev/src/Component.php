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

namespace Google\Cloud\Dev;

use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use RuntimeException;
use DateTime;

/**
 * @internal
 */
class Component
{
    const VERSION_REGEX = '/^V([0-9])?(p[0-9])?(beta|alpha)?[0-9]?$/';
    public const ROOT_DIR = __DIR__ . '/../../';
    private string $path;
    private string $releaseLevel;
    private string $packageName;
    private string $repoName;
    private string $productDocumentation;
    private string $clientDocumentation;
    private string $description;
    private array $namespaces;
    /** @var array<Component> */
    private array $componentDependencies;

    public function __construct(private string $name, ?string $path = null)
    {
        $this->path = $path ?: $this->getComponentPath($name);
        $this->validateComponentFiles();
    }

    private static function getComponentNames(): array
    {
        $components = scandir(self::ROOT_DIR);
        foreach ($components as $i => $name) {
            if (!is_dir(self::ROOT_DIR . $name) || !preg_match('/^[A-Z]/', $name)) {
                unset($components[$i]);
            }
        }

        return $components;
    }

    public static function getComponents(array $componentNames = []): array
    {
        $components = [];
        foreach ($componentNames ?: self::getComponentNames() as $name) {
            $components[] = new Component($name);
        }

        return $components;
    }

    public function getId(): string
    {
        return str_replace(['google/', 'googleads/'], '', $this->getPackageName());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getRepoName(): string
    {
        return $this->repoName;
    }

    public function getIssueTracker(): string
    {
        return sprintf('https://github.com/%s/issues', $this->getRepoName());
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function getReleaseLevel(): string
    {
        return $this->releaseLevel;
    }

    public function getClientDocumentation(): string
    {
        return $this->clientDocumentation;
    }

    public function getProductDocumentation(): string
    {
        return $this->productDocumentation;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * Formats distribution name like
     *   - google-cloud-policy-troubleshooter
     *   - google-cloud-vision
     *   - google-grafeas
     *   - google-analytics-data
     * This is for the reference documentation URLs
     */
    public function getReferenceDocumentationUid(): string
    {
        return str_replace('/', '-', $this->getPackageName());
    }

    private function getComponentPath(string $component): string
    {
        $components = $this->getComponentNames();

        if (!in_array($component, $components)) {
            throw new \Exception('Invalid component name provided: ' . $component);
        }

        $componentPath = realpath(self::ROOT_DIR . '/' . $component);

        if (!is_dir($componentPath)) {
            throw new RuntimeException(sprintf('component "%s" not found', $component));
        }

        return $componentPath;
    }

    private function validateComponentFiles(): void
    {
        $composerPath = $this->path . '/composer.json';
        if (!file_exists($composerPath)) {
            throw new RuntimeException(
                sprintf('composer.json not found for component "%s"', $this->name)
            );
        }
        $composerJson = json_decode(file_get_contents($composerPath), true);
        if (!$composerJson) {
            throw new RuntimeException(
                sprintf('Invalid composer.json for component "%s"', $this->name)
            );
        }
        if (empty($composerJson['name'])) {
            throw new RuntimeException('composer.json does not contain "name"');
        }
        if (empty($composerJson['description'])) {
            throw new RuntimeException('composer.json does not contain "description"');
        }
        if (empty($composerJson['autoload']['psr-4'])) {
            throw new RuntimeException('composer does not contain autoload.psr-4');
        }

        $this->packageName = $composerJson['name'];
        $this->description = $composerJson['description'];

        if (!$repoName = $composerJson['extra']['component']['target'] ?? null) {
            if (!str_starts_with($composerJson['homepage'], 'https://github.com/')) {
                throw new RuntimeException(
                    'composer does not contain extra.component.target, and homepage is not a github URL'
                );
            }
            $repoName = str_replace('https://github.com', '', $composerJson['homepage']);
        }
        $this->repoName = preg_replace('/\.git$/', '', $repoName); // Strip trailing ".git"

        $repoMetadataFullPath = self::ROOT_DIR . '/.repo-metadata-full.json';
        $repoMetadataFullJson = json_decode(file_get_contents($repoMetadataFullPath), true);
        if (isset($repoMetadataFullJson[$this->name])) {
            $repoMetadataJson = $repoMetadataFullJson[$this->name];
        } elseif (file_exists($repoMetadataPath = $this->path . '/.repo-metadata.json')) {
            $repoMetadataJson = json_decode(file_get_contents($repoMetadataPath), true);
        } else {
            throw new RuntimeException(sprintf(
                'repo metadata not found for component "%s" and no .repo-metadata.json file found in %s',
                $this->name,
                $repoMetadataPath
            ));
        }

        if (empty($repoMetadataJson['release_level'])) {
            throw new RuntimeException(sprintf(
                'repo metadata does not contain "release_level" for component "%s"',
                $this->name
            ));
        }
        if (empty($repoMetadataJson['release_level'])) {
            throw new RuntimeException(sprintf(
                'repo metadata does not contain "client_documentation" for component "%s"',
                $this->name
            ));
        }
        $this->releaseLevel = $repoMetadataJson['release_level'];
        $this->clientDocumentation = $repoMetadataJson['client_documentation'];
        $this->productDocumentation = $repoMetadataJson['product_documentation'] ?? '';

        $namespaces = [];
        foreach ($composerJson['autoload']['psr-4'] as $namespace => $dir) {
            if (str_starts_with($dir, 'src')) {
                $namespaces[rtrim($namespace, '\\')] = $dir;
            }
        }
        if (empty($namespaces)) {
            throw new RuntimeException('composer autoload.psr-4 does not contain a namespace');
        }
        $this->namespaces = $namespaces;

        // find dependencies which are google/cloud components
        $this->componentDependencies = [];
        foreach ($composerJson['require'] ?? [] as $name => $version) {
            if ($componentName = key(array_filter(
                $repoMetadataFullJson,
                fn ($metadata) => $metadata['distribution_name'] === $name
            ))) {
                $this->componentDependencies[] = new Component($componentName);
            }
        }
        if (isset($composerJson['require']['google/gax'])) {
            $this->componentDependencies[] = new Component('gax', self::ROOT_DIR . '/dev/vendor/google/gax');
            if (!isset($composerJson['require']['google/common-protos'])) {
                $this->componentDependencies[] = new Component('CommonProtos');
            }
        }
    }

    /**
     * Get the contents of VERSION in the component directory
     */
    public function getPackageVersion(): string
    {
        return trim(file_get_contents(sprintf('%s/VERSION', $this->path)));
    }

    public function getComponentPackages(): array
    {
        return array_map(fn($path) => new ComponentPackage($this, $path), $this->getPackagePaths());
    }

    public function getApiShortnames(): array
    {
        return array_unique(array_map(fn($pkg) => $pkg->getApiShortname(), $this->getComponentPackages()));
    }

    public function getMigrationStatuses(): array
    {
        return array_map(fn($v) => $v->getMigrationStatus(), $this->getComponentPackages());
    }

    public function getProtoNamespaces(): array
    {
        $protoNamespaces = [];
        $componentPackages = $this->getComponentPackages();
        foreach ($this->namespaces as $namespace => $dir) {
            $componentPackages = $dir === 'src'
                ? $this->getComponentPackages()
                : [new ComponentPackage($this, str_replace('src/', '', $dir))];

            $protoNamespaces = array_reduce(
                $componentPackages,
                fn($protoNamespaces, $pkg) => array_merge($protoNamespaces, $pkg->getProtoNamespaces()),
                $protoNamespaces
            );
        }

        return $protoNamespaces;
    }

    public static function getProtoPackageToNamespaceMap(): array
    {
        $protoNamespaces = [];
        foreach (self::getComponents() as $component) {
            $componentProtoNamespaces = $component->getProtoNamespaces();
            if ($commonPackages = array_intersect_key($componentProtoNamespaces, $protoNamespaces)) {
                foreach ($commonPackages as $package => $namespace) {
                    if ($namespace !== $protoNamespaces[$package]) {
                        throw new RuntimeException(sprintf(
                            'Package "%s" has conflicting namespaces: "%s" and "%s"',
                            $package,
                            $namespace,
                            $protoNamespaces[$package]
                        ));
                    }
                }
            }
            $protoNamespaces = array_merge($protoNamespaces, $componentProtoNamespaces);
        }

        return $protoNamespaces;
    }

    public function getProtoPaths(): array
    {
        return array_map(fn($v) => $v->getProtoPath(), $this->getComponentPackages());
    }

    public function getServiceAddresses(): array
    {
        return array_unique(array_map(fn($pkg) => $pkg->getServiceAddress(), $this->getComponentPackages()));
    }

    /**
     * Get the API versions supported by this component
     */
    public function getApiVersions(): array
    {
        return array_map(fn($pkg) => $pkg->getName(), $this->getComponentPackages());
    }

    public function getCreatedAt(): DateTime
    {
        exec(sprintf(
            'git log --reverse --pretty=format:"%%cd" %s/ | head -1',
            $this->name,
        ), $output);

        return new DateTime($output[0]);
    }

    private function getPackagePaths(): array
    {
        $result = (new Finder())->directories()->in($this->path . '/src/')->name(self::VERSION_REGEX);
        $paths = array_map(fn ($file) => $file->getRelativePathname(), iterator_to_array($result));
        $paths = array_reverse(array_values($paths));
        usort($paths, 'version_compare');
        if (empty($paths)) {
            $paths = [''];
        }
        return array_reverse($paths);
    }

    public function getComponentDependencies(): array
    {
        return $this->componentDependencies;
    }
}
