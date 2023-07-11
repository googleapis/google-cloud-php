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

/**
 * @internal
 */
class Component
{
    const VERSION_REGEX = '/^V([0-9])?(p[0-9])?(beta|alpha)?[0-9]?$/';
    private const ROOT_DIR = __DIR__ . '/../../';
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

    public static function getComponents(): array
    {
        $components = [];
        foreach (self::getComponentNames() as $name) {
            $components[] = new Component($name);
        }

        return $components;
    }

    public function getId(): string
    {
        return str_replace('google/', '', $this->getPackageName());
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

        $repoMetadataPath = $this->path . '/.repo-metadata.json';
        if (!file_exists($repoMetadataPath)) {
            throw new RuntimeException(
                sprintf('repo metadata not found for component "%s"', $this->name)
            );
        }
        $repoMetadataJson = json_decode(file_get_contents($repoMetadataPath), true);
        if (!$repoMetadataJson) {
            throw new RuntimeException(
                sprintf('Invalid .repo-metadata.json for component "%s"', $this->name)
            );
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

    private function getPackagePaths(): array
    {
        $result = (new Finder())->directories()->in($this->path . '/src/')->name(self::VERSION_REGEX);
        $paths = array_map(fn ($file) => $file->getRelativePathname(), iterator_to_array($result));
        $paths = array_reverse(array_values($paths));
        usort($paths, [$this, 'versionCompare']);
        return $paths;
    }

    private static function versionCompare(string $v1, string $v2)
    {
        // First, sort by API number (e.g. V1 vs V2)
        $sort = substr($v1, strrpos($v1, 'V')) <=> substr($v2, strrpos($v2, 'V'));
        if ($sort === 0) {
            // If same API version, sort by if one is in a subdirectory
            return strpos($v1, '/') <=> strpos($v2, '/');
        }
        // Else, sort by release level (e.g. beta vs alpha vs GA)
        $v1Sort = strpos($v1, 'beta') ? 0 : (strpos($v1, 'alpha') ? -1 : 1);
        $v2Sort = strpos($v2, 'beta') ? 0 : (strpos($v2, 'alpha') ? -1 : 1);
        return $v2Sort <=> $v1Sort;
    }
}
