<?php

namespace Google\Cloud\Dev;

/**
 * Helper for manipulating component versions.
 */
trait ComponentVersionTrait
{
    use GetComponentsTrait;

    /**
     * Add a new component version to the manifest.
     *
     * @param string $version The new version. (do not prefix with `v`).
     * @param array $component The component data, as an array.
     * @return void
     */
    private function addToComponentManifest($version, array $component)
    {
        $manifest = $this->getManifest($this->manifest());
        $index = $this->getManifestComponentModuleIndex($manifest, $component['id']);

        array_unshift($manifest['modules'][$index]['versions'], 'v'. $version);

        $content = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ."\n";
        $result = file_put_contents($this->manifest(), $content);
        $this->setManifest($manifest);

        if (!$result) {
            throw new \RuntimeException('File write failed');
        }
    }

    /**
     * Update the VERSION constant in a veneer entry file.
     *
     * @param string $version The new version. (do not prefix with `v`).
     * @param string $componentPath The path to the component, relative to the root of the project.
     * @param string $componentEntry The name of the entry file to modify (i.e. FooClient.php).
     * @return bool
     */
    private function updateComponentVersionConstant($version, $componentPath, $componentEntry)
    {
        if (is_null($componentEntry)) {
            return false;
        }

        $path = $this->rootPath() .'/'. $componentPath .'/'. $componentEntry;
        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf(
                'Component entry file %s does not exist',
                $path
            ));
        }

        $entry = file_get_contents($path);

        $replacement = sprintf("const VERSION = '%s';", $version);

        $entry = preg_replace("/const VERSION = [\'\\\"]([0-9.]{0,}|master)[\'\\\"]\;/", $replacement, $entry);

        $result = file_put_contents($path, $entry);

        if (!$result) {
            throw new \RuntimeException('File write failed');
        }

        return true;
    }

    /**
     * Update the VERSION file in a component directory.
     *
     * @param string $version The new version. (do not prefix with `v`).
     * @param array $component The component data as an array.
     * @return bool
     */
    private function updateComponentVersionFile($version, array $component)
    {
        $path = $this->rootPath() .'/'. $component['path'] .'/VERSION';
        $result = file_put_contents($path, $version);

        if (!$result) {
            throw new \RuntimeException('File write failed');
        }

        return true;
    }

    /**
     * Update the `replaces` version in the main composer.json file.
     *
     * @param string $version The new version. (do not prefix with `v`).
     * @param array $component The component data as an array.
     * @return void
     */
    private function updateComposerReplacesVersion($version, array $component)
    {
        $composer = $this->rootPath() .'/composer.json';
        if (!file_exists($composer)) {
            throw new \Exception('Invalid composer.json path');
        }

        $data = json_decode(file_get_contents($composer), true);

        $data['replace'][$component['name']] = $version;

        file_put_contents($composer, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }

    protected abstract function rootPath();
    protected abstract function manifest();
}
