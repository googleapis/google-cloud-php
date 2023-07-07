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

/**
 * Helper for getting info about component API versions.
 *
 * @internal
 */
class ComponentPackage
{
    private const PROTO_REGEX = '#\* GENERATED CODE WARNING
 \* Generated by gapic-generator-php from the file
 \* https:\/\/github.com\/googleapis\/googleapis\/blob\/master\/(.*.proto)
 \* Updates to the above are reflected here through a refresh process#';
    private string $path;

    public function __construct(private Component $component, private string $name)
    {
        $this->path = $component->getPath() . '/src/' . $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProtoPackage(): string
    {
        $gapicClientFiles = $this->getV1GapicClientFiles() + $this->getV2BaseClientFiles();

        foreach ($gapicClientFiles as $file) {
            $gapicClientContent = file_get_contents($file);
            if (preg_match(self::PROTO_REGEX, $gapicClientContent, $matches)) {
                return dirname($matches[1]);
            }
        }

        return '';
    }

    public function getMigrationStatus()
    {
        $hasV1Clients = count($this->getV1GapicClientFiles()) > 0;
        $hasV2Clients = count($this->getV2BaseClientFiles()) > 0;
        if ($hasV1Clients) {
            return $hasV2Clients ? 'v1+v2' : 'v1';
        }
        return $hasV2Clients ? 'v2' : 'n/a';
    }

    public function getServiceAddress(): string
    {
        $gapicClientFiles = $this->getV1GapicClientFiles() + $this->getV2BaseClientFiles();
        $gapicClientClasses = array_map(fn ($fp) => $this->getClassFromFile($fp), $gapicClientFiles);

        foreach ($gapicClientClasses as $className) {
            // Access V1-surface public constant
            if (defined($className . '::SERVICE_ADDRESS')) {
                return constant($className . '::SERVICE_ADDRESS');
            }
            // Access V2-surface private constant
            if ($constants = (new \ReflectionClass($className))->getConstants()) {
                if (isset($constants['SERVICE_ADDRESS'])) {
                    return $constants['SERVICE_ADDRESS'];
                }
            }
        }
        return '';
    }

    public function getApiShortname(): string
    {
        $sa = $this->getServiceAddress();
        return substr($sa, 0, strpos($sa, '.'));
    }


    private function getV1GapicClientFiles(): array
    {
        return $this->getFilesInDir('*GapicClient.php');
    }

    private function getV2BaseClientFiles(): array
    {
        return $this->getFilesInDir('*BaseClient.php');
    }

    private function getFilesInDir(string $pattern): array
    {
        $result = (new Finder())->files()->name($pattern)->in($this->path);
        return array_map(fn ($file) => $file->getRealPath(), iterator_to_array($result));
    }

    private function getClassFromFile(string $filePath): string
    {
        foreach ($this->component->getNamespaces() as $namespace => $dir) {
            $gapicClientClass = str_replace($this->component->getPath() . '/' . $dir, $namespace, $filePath);
            $gapicClientClass = str_replace(['/', '.php'], ['\\', ''], $gapicClientClass);
            if (class_exists($gapicClientClass)) {
                return $gapicClientClass;
            }
        }
        throw new \Exception('No GAPIC client found in ' . $filePath);
    }
}