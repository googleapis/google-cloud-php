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

            // Manually skip protobuf enums in favor of Gapic enums.
            // @TODO: Do not generate them in V2, eventually mark them as deprecated
            $isDiregapic = $isDiregapic || $classNode->isGapicEnumClass();

            $fullName = $classNode->getFullname();

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

        // Sort pages alphabetically by full class name
        ksort($pages);

        // Combine Client classes with internal Gapic\Client
        $this->pages = array_values($this->combineGapicClients($pages));

        return $this->pages;
    }

    private function combineGapicClients(array $pages): array
    {
        // Combine Client with internal Gapic\Client
        foreach ($pages as $className => $page) {
            if ('Client' == substr($className, -6) && 'GapicClient' != substr($className, -11)) {
                // Find Gapic Classname
                $parts = explode('\\', $className);
                $clientName = substr(array_pop($parts), 0, -6) . 'GapicClient';
                $parts[] = 'Gapic';
                $parts[] = $clientName;
                $gapicClientName = implode('\\', $parts);
                if (isset($pages[$gapicClientName])) {
                    $page->getClassNode()->setChildNode($pages[$gapicClientName]->getClassNode());
                    unset($pages[$gapicClientName]);
                }
            }
        }

        return $pages;
    }

    public function getProtoPackages(): array
    {
        $protoPackages = [];
        foreach ($this->pages as $page) {
            $classNode = $page->getClassNode();
            if ($classNode->isServiceClass()) {
                $protoPackages[$classNode->getProtoPackage()] = ltrim($classNode->getNamespace(), '\\');
            }
        }
        return $protoPackages;
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
