<?php
/**
 * Copyright 2019 Google LLC
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

/**
 * Read and manage Google Cloud PHP Components.
 *
 * @internal
 */
class ComponentManager
{
    const DEFAULT_MANIFEST_PATH = '/docs/manifest.json';

    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var string
     */
    private $manifestPath;

    /**
     * @var array|null
     */
    private $components;

    /**
     * @var array|null
     */
    private $manifest;

    /**
     * @param string $rootPath The path to the repository root directory.
     * @param string $manifestPath [optional] The path to the manifest.json
     *        file. May be left blank to use default location.
     */
    public function __construct($rootPath, $manifestPath = null)
    {
        $this->rootPath = $rootPath;
        $this->manifestPath = $manifestPath
            ?: $this->rootPath . self::DEFAULT_MANIFEST_PATH;
    }

    /**
     * Return a list of component IDs.
     *
     * @return string[]
     */
    public function components()
    {
        $components = $this->components ?: $this->loadComponents();

        return array_keys($components);
    }

    /**
     * Get all component's composer.json extra data.
     *
     * @param string $componentId [optional] If set, only this component's data
     *        will be returned.
     * @return array[]
     */
    public function componentsExtra($componentId = null)
    {
        $components = $this->components ?: $this->loadComponents();

        array_walk($components, function (&$component) {
            $name = $component['composer']['name'];
            $component = $component['composer']['extra']['component'];
            $component['displayName'] = $name;
        });

        return $componentId
            ? [$componentId => $components[$componentId]]
            : $components;
    }

    /**
     * Get all component's manifest.json data.
     *
     * @param string $componentId [optional] If set, only this component's data
     *        will be returned.
     * @return array[]
     */
    public function componentsManifest($componentId = null)
    {
        $manifest = $this->manifest ?: $this->loadManifest;
        $modules = $manifest['modules'];

        if ($componentId) {
            $modules = array_filter($modules, function ($module) use ($componentId) {
                return $module['id'] === $componentId;
            });
        }

        return $modules;
    }

    /**
     * Get the latest version of each component.
     *
     * @param string $componentId [optional] If set, only this component's data
     *        will be returned.
     * @return string[]
     */
    public function componentsVersion($componentId = null)
    {
        $components = $this->components ?: $this->loadComponents();

        array_walk($components, function (&$component) {
            $component = $component['version'];
        });

        return $componentId
            ? [$componentId => $components[$componentId]]
            : $components;
    }

    private function loadComponents()
    {
        $manifest = $this->manifest ?: $this->loadManifest();

        $modules = $manifest['modules'];
        $components = [];
        foreach ($modules as $module) {
            $components[$module['id']] = [
                'version' => array_shift($module['versions']),
                'name' => $module['name'],
                'defaultService' => $module['defaultService']
            ];
        }

        // List all composer.json files in subdirectories directly below repository root,
        // add root composer.json.
        $composerFiles = array_merge(glob($this->rootPath . '/*/composer.json'), [$this->rootPath .'/composer.json']);
        foreach ($composerFiles as $composerPath) {
            $composer = $this->loadJsonFromFile($composerPath);

            if (!isset($composer['extra']['component'])) {
                continue;
            }

            $component = $composer['extra']['component'];
            $id = $component['id'];

            if (isset($components[$id])) {
                $components[$id]['displayName'] = $composer['name'];
                $components[$id]['composer'] = $composer;
            }
        }

        $this->components = $components;
        return $components;
    }

    private function loadManifest()
    {
        $manifest = $this->loadJsonFromFile($this->manifestPath);

        $this->manifest = $manifest;
        return $manifest;
    }

    protected function loadJsonFromFile($path)
    {
        $json = json_decode(@file_get_contents($path), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(sprintf(
                'Could not load manifest from %s. Check that the file exists and is valid JSON.',
                $path
            ));
        }

        return $json;
    }
}
