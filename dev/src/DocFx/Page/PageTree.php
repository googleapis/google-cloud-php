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
use Google\Cloud\Dev\DocFx\Node\InterfaceNode;
use Google\Cloud\Dev\DocFx\Toc\NamespaceToc;
use SimpleXMLElement;

/**
 * Class to determine the tree for DocFX rendering
 * @internal
 */
class PageTree
{
    private array $pages;
    public bool $hasV1Client = false;
    public bool $hasV2Client = false;

    public function __construct(
        private string $xmlPath,
        private string $namespace,
        private string $packageDescription,
        private string $componentPath,
        private array $componentPackages
    ) {}

    public function getPages(): array
    {
        if (!isset($this->pages)) {
            $this->pages = $this->loadPages();
        }

        return $this->pages;
    }

    private function loadPages(): array
    {
        $structure = new SimpleXMLElement(file_get_contents($this->xmlPath));

        // List of pages, to sort alphabetically by key
        $pageMap = [];
        $isDiregapic = false;
        $gapicClients = [];
        $interfaces = [];

        // Build the list of pages we are going to generate documentation for
        foreach ($structure->file as $file) {
            if (!isset($file->class[0]) && !isset($file->interface[0])) {
                // only document classes and interfaces for now
                continue;
            }
            $filename = $this->componentPath . '/src/' . $file['path'];
            $node = isset($file->class[0])
                ? new ClassNode($file->class[0], $this->componentPackages, $filename)
                : new InterfaceNode($file->interface[0], $this->componentPackages);

            if ($node instanceof InterfaceNode) {
                $interfaces[] = $node;
            }

            if ($node->excludeFromDocs()) {
                // Keep track of base clients
                if ($node->isServiceBaseClass()) {
                    $gapicClients[] = $node;
                }
                continue;
            }

            $this->hasV1Client |= $node->isV1ServiceClass();
            $this->hasV2Client |= $node->isV2ServiceClass();

            // Manually skip protobuf enums in favor of Gapic enums (see below).
            // @TODO: Do not generate them in V2, eventually mark them as deprecated
            $isDiregapic |= $node->isGapicEnumClass();

            $fullName = $node->getFullname();

            // Skip classes that are in the structure.xml but not a part of this namespace
            if (0 !== strpos($fullName, '\\' . $this->namespace)) {
                continue;
            }

            $pageMap[$fullName] = new Page(
                $node,
                $file['path'],
                $this->packageDescription,
                $this->componentPath
            );
        }

        /**
         * Remove protobuf enums in favor of Gapic enums.
         * @TODO: Do not generate them in V2, eventually mark them as deprecated
         */
        if ($isDiregapic) {
            foreach ($pageMap as $className => $page) {
                if ($page->getClassNode()->isProtobufEnumClass()) {
                    unset($pageMap[$className]);
                }
            }
        }

        /**
         * Determine all classes which implement an interface in this library,
         * so that we can list them in the interface's reference documentation.
         */
        foreach ($interfaces as $interface) {
            $interface->determineImplementingClasses($pageMap);
        }

        // Combine Client classes with internal Gapic\Client
        $pageMap = $this->combineGapicClients($gapicClients, $pageMap);

        // Sort pages alphabetically by full class name
        ksort($pageMap);

        // We no longer need the array keys
        $pages = array_values($pageMap);

        return $pages;
    }

    private function combineGapicClients(array $gapicClients, array $pageMap): array
    {
        // Combine Client with internal Gapic\Client
        foreach ($gapicClients as $gapicClient) {
            // Find  Classname
            $parts = explode('\\', $gapicClient->getFullName());
            $clientClassName = str_replace('GapicClient', 'Client', array_pop($parts));
            array_pop($parts); // remove "Gapic" namespace
            $parts[] = $clientClassName;
            $clientFullName = implode('\\', $parts);
            if (isset($pageMap[$clientFullName])) {
                $parentClassNode = $pageMap[$clientFullName]->getClassNode();
                $parentClassNode->setChildNode($gapicClient);
            }
        }

        return $pageMap;
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
