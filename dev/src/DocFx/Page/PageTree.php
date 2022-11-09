<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Dev\DocFx\Page;

use Google\Cloud\Dev\DocFx\Node\ClassNode;
use Google\Cloud\Dev\DocFx\Toc\NamespaceToc;
use SimpleXMLElement;

/**
 * Class to determine the tree for DocFX rendering
 */
class PageTree
{
    private array $pages;
    private string $filePath;

    public function __construct(
        private string $xmlPath,
        private string $namespace,
        private string $friendlyApiName
    ) {}

    public function getPages(): array
    {
        $structure = new SimpleXMLElement(file_get_contents($this->xmlPath));

        // List of pages, to sort alphabetically by key
        $pages = [];

        $isDiregapic = false;

        $gapicClients = [];

        // Build the list of pages we are going to generate documentation for
        foreach ($structure->file as $file) {
            // only document classes for now
            if (!isset($file->class[0])) {
                continue;
            }

            $classNode = new ClassNode($file->class[0]);

            // Skip the protobuf classes with underscores, they're all deprecated
            // @TODO: Do not generate them in V2
            if (false !== strpos($classNode->getName(), '_')) {
                continue;
            }

            // Skip deprecated classes
            if ('deprecated' === $classNode->getStatus()) {
                continue;
            }

            // Skip internal classes
            if ($classNode->isInternal()) {
                continue;
            }

            // Manually skip protobuf enums in favor of Gapic enums (see below).
            // @TODO: Do not generate them in V2, eventually mark them as deprecated
            $isDiregapic = $isDiregapic || $classNode->isGapicEnumClass();

            $fullName = $classNode->getFullname();
            // Manually skip GAPIC clients
            if ('GapicClient' === substr($classNode->getClassName(), -11)) {
                $gapicClients[] = $classNode;
                continue;
            }

            // Manually skip Grpc classes
            // @TODO: Do not generate Grpc classes in V2, eventually mark these as deprecated
            if (
                'GrpcClient' === substr($fullName, -10)
                && '\Grpc\BaseStub' === $classNode->getExtends()
            ) {
                continue;
            }

            // Skip classes that are in the structure.xml but not a part of this namespace
            if (0 !== strpos($fullName, '\\' . $this->namespace)) {
                continue;
            }

            $pages[$fullName] = new Page($classNode, $file['path'], $this->friendlyApiName);
        }

        /**
         * Remove protobuf enums in favor of Gapic enums.
         * @TODO: Do not generate them in V2, eventually mark them as deprecated
         */
        if ($isDiregapic) {
            foreach ($pages as $className => $page) {
                if ($page->getClassNode()->isProtobufEnumClass()) {
                    unset($pages[$className]);
                }
            }
        }

        // Combine Client classes with internal Gapic\Client
        $pages = $this->combineGapicClients($gapicClients,$pages);

        // We don't need the array keys anymore
        $pages = array_values($pages);

        /**
         * Set a map of protobuf package names to PHP namespaces for Xrefs.
         * This has to be done after we combine GAPIC clients.
         */
        $protoPackages = [];
        foreach ($pages as $page) {
            if ($protoPackage = $classNode->getProtoPackage()) {
                $protoPackages[$protoPackage] = ltrim($classNode->getNamespace(), '\\');
            }
        }

        foreach ($pages as $page) {
            $page->getClassNode()->setProtoPackages($protoPackages);
        }

        // Sort pages alphabetically by full class name
        ksort($pages);

        return $this->pages = $pages;
    }

    private function combineGapicClients(array $gapicClients, array $pages): array
    {
        // Combine Client with internal Gapic\Client
        foreach ($gapicClients as $gapicClient) {
            // Find  Classname
            $parts = explode('\\', $className);
            $clientClassName = substr(array_pop($parts), 0, -11) . 'Client';
            array_pop($parts); // remove "Gapic" namespace
            $parts[] = $clientClassName;
            $clientFullName = implode('\\', $parts);
            if (isset($pages[$clientFullName])) {
                $page->getClassNode()->setChildNode($gapicClient);
                unset($pages[$clientFullName]);
            }
        }

        return $pages;
    }

    public function getTocItems(): array
    {
        $toc = new NamespaceToc($this->namespace, $this->namespace);
        foreach ($this->pages as $page) {
            $toc->addNode($page->getClassNode());
        }
        return $toc->toToc()['items'];
    }
}
