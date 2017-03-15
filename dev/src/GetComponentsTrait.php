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
     */
    private function getComponents($componentsPath, $defaultComposerPath = null)
    {
        $files = glob($componentsPath .'/*/composer.json');

        if (!is_null($defaultComposerPath)) {
            $files[] = $defaultComposerPath;
        }

        $components = [];
        foreach ($files as $file) {
            $json = json_decode(file_get_contents($file), true);

            $path = explode('src', $file);
            $component = $json['extra']['component'];
            $component['name'] = $json['name'];
            if (!isset($component['displayName'])) {
                $component['displayName'] = $json['name'];
            }

            if (count($path) > 1) {
                $component['prefix'] = dirname('src' . $path[1]);
            } else {
                $component['prefix'] = '';
            }

            $components[] = $component;
        }

        return $components;
    }

    private function getComponentVersion($manifestPath, $componentId)
    {
        $manifest = $this->getComponentManifest($manifestPath, $componentId);
        return $manifest['versions'][0];
    }

    private function getComponentManifest($manifestPath, $componentId)
    {
        $manifest = $this->getManifest($manifestPath);
        $index = $this->getManifestComponentModuleIndex($manifestPath, $manifest, $componentId);

        return $manifest['modules'][$index];
    }

    private function getManifestComponentModuleIndex($manifestPath, array $manifest, $componentId)
    {
        $modules = array_filter($this->getManifest($manifestPath)['modules'], function ($module) use ($componentId) {
            return ($module['id'] === $componentId);
        });

        return array_keys($modules)[0];
    }

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

    private function getComponentComposer($componentId)
    {
        $components = $this->getComponents($this->components, $this->defaultComponentComposer);

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
