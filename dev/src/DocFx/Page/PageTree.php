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
        private string $componentPath
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

            // Manually skip GAPIC base clients
            if ($classNode->isServiceBaseClass()) {
                $gapicClients[] = $classNode;
                continue;
            }

            // Skip internal classes
            if ($classNode->isInternal()) {
                continue;
            }

            $this->hasV1Client |= $classNode->isV1ServiceClass();
            $this->hasV2Client |= $classNode->isV2ServiceClass();

            // Manually skip protobuf enums in favor of Gapic enums (see below).
            // @TODO: Do not generate them in V2, eventually mark them as deprecated
            $isDiregapic = $isDiregapic || $classNode->isGapicEnumClass();

            // Manually skip Grpc classes
            // @TODO: Do not generate Grpc classes in V2, eventually mark these as deprecated
            $fullName = $classNode->getFullname();
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

            $pageMap[$fullName] = new Page(
                $classNode,
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

        // Combine Client classes with internal Gapic\Client
        $pageMap = $this->combineGapicClients($gapicClients, $pageMap);

        // We no longer need the array keys
        $pages = array_values($pageMap);

        // Mark V2 services as "beta" if they have a V1 client
        if ($this->hasV1Client && $this->hasV2Client) {
            foreach ($pages as $page) {
                if ($page->getClassNode()->isV2ServiceClass()) {
                    $page->getClassNode()->setTocName(sprintf(
                        '%s (beta)',
                        $page->getClassNode()->getName()
                    ));
                }
            }
        }

        /**
         * Set a map of protobuf package names to PHP namespaces for Xrefs.
         * This MUST be done after combining GAPIC clients.
         */
        $protoPackages = [
            // shared packages
            'google.longrunning' => 'Google\\LongRunning'
        ];
        foreach ($pages as $page) {
            $classNode = $page->getClassNode();
            if ($protoPackage = $classNode->getProtoPackage()) {
                $package = rtrim(ltrim($classNode->getNamespace(), '\\'), '\\Client');
                $protoPackages[$protoPackage] = $package;
            }
        }

        // Add the proto packages to every class node
        foreach ($pages as $page) {
            $page->getClassNode()->setProtoPackages($protoPackages);
        }

        // Sort pages alphabetically by full class name
        ksort($pages);

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
