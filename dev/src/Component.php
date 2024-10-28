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

    public function __construct(private string $name, string $path = null)
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
        return str_replace(['google/', 'googleads'], '', $this->getPackageName());
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
        if (empty($composerJson['extra']['component']['target'])) {
            throw new RuntimeException('composer does not contain extra.component.target');
        }
        if (empty($composerJson['description'])) {
            throw new RuntimeException('composer.json does not contain "description"');
        }
        if (empty($composerJson['autoload']['psr-4'])) {
            throw new RuntimeException('composer does not contain autoload.psr-4');
        }

        $this->packageName = $composerJson['name'];
        $repoName = $composerJson['extra']['component']['target'];
        $this->repoName = preg_replace('/\.git$/', '', $repoName); // Strip trailing ".git"
        $this->description = $composerJson['description'];

        $repoMetadataPath = self::ROOT_DIR . '/.repo-metadata-full.json';
        $repoMetadataFullJson = json_decode(file_get_contents($repoMetadataPath), true);
        if (!$repoMetadataFullJson) {
            throw new RuntimeException('Invalid .repo-metadata-full.json');
        }
        if (!isset($repoMetadataFullJson[$this->name])) {
            throw new RuntimeException(sprintf(
                'repo metadata for component "%s" not found in .repo-metadata-full.json',
                $this->name
            ));
        }
        $repoMetadataJson = $repoMetadataFullJson[$this->name];
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

        foreach ($composerJson['autoload']['psr-4'] as $namespace => $dir) {
            if (0 === strpos($dir, 'src')) {
                $namespaces[rtrim($namespace, '\\')] = $dir;
            }
        }
        if (empty($namespaces)) {
            throw new RuntimeException('composer autoload.psr-4 does not contain a namespace');
        }
        $this->namespaces = $namespaces;
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

    public function getProtoPackages(): array
    {
        return array_map(fn($v) => $v->getProtoPackage(), $this->getComponentPackages());
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
}
