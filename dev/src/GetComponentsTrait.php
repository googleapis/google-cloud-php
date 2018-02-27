<?php
/**
 * Copyright 2016 Google Inc.
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

trait GetComponentsTrait
{
    private static $__manifest;

    /**
     * If $defaultComposerPath is set, it will parse that path as a composer
     * file and add it to the components.
     *
     * @param string $libraryRootPath The root path of the library.
     * @param string $componentsPath The base path, under which composer.json files will be discovered.
     * @param string|null $defaultComposerPath If set, this path will be included as a component.
     * @return array Component data.
     */
    private function getComponents($libraryRootPath, $componentsPath, $defaultComposerPath = null)
    {
        $files = glob($componentsPath .'/*/composer.json');

        if (!is_null($defaultComposerPath)) {
            $files[] = $defaultComposerPath;
        }

        $components = [];
        foreach ($files as $file) {
            $file = realpath($file);
            $json = json_decode(file_get_contents($file), true);

            $path = trim(str_replace($libraryRootPath, '', $file), '/');

            $component = $json['extra']['component'];
            $component['name'] = $json['name'];
            if (!isset($component['displayName'])) {
                $component['displayName'] = $json['name'];
            }

            $component['prefix'] = dirname($path);

            $components[] = $component;
        }

        return $components;
    }

    /**
     * Get the latest version for a given component.
     *
     * @param string $manifestPath The path to the manifest.
     * @param string $componentId The component ID to fetch a version from.
     * @return string
     */
    private function getComponentVersion($manifestPath, $componentId)
    {
        $manifest = $this->getComponentManifest($manifestPath, $componentId);
        return $manifest['versions'][0];
    }

    /**
     * Return manifest data for the given component.
     *
     * @param string $manifestPath The path to the manifest.
     * @param string $componentId The component ID to fetch.
     * @return array
     */
    private function getComponentManifest($manifestPath, $componentId)
    {
        $manifest = $this->getManifest($manifestPath);
        $index = $this->getManifestComponentModuleIndex($manifest, $componentId);

        return $manifest['modules'][$index];
    }

    /**
     * Get the manifest component index.
     *
     * @param string|array $manifest If a string, the path to the manifest. If
     *        an array, the manifest contents.
     * @param string $componentId The component ID to fetch
     * @return int
     */
    private function getManifestComponentModuleIndex($manifest, $componentId)
    {
        $manifest = is_array($manifest)
            ? $manifest
            : $this->getManifest($manifest);

        $modules = array_filter($manifest['modules'], function ($module) use ($componentId) {
            return ($module['id'] === $componentId);
        });

        return array_keys($modules)[0];
    }

    /**
     * Read the given file as a package manifest.
     *
     * @param string $manifestPath
     * @return array
     */
    private function getManifest($manifestPath)
    {
        if (self::$__manifest) {
            $manifest = self::$__manifest;
        } else {
            $manifest = json_decode(file_get_contents($manifestPath), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Could not decode manifest json');
            }

            self::$__manifest = $manifest;
        }

        return $manifest;
    }

    /**
     * Get the composer.json data for a given component.
     *
     * @param string $componentId
     * @return array
     */
    private function getComponentComposer($libraryRootPath, $componentId)
    {
        $components = $this->getComponents($libraryRootPath, $this->components, $this->defaultComponentComposer);

        $components = array_values(array_filter($components, function ($component) use ($componentId) {
            return ($component['id'] === $componentId);
        }));

        if (count($components) === 0) {
            throw new \InvalidArgumentException(sprintf(
                'Given component id %s is not a valid component.',
                $componentId
            ));
        }

        return $components[0];
    }
}
