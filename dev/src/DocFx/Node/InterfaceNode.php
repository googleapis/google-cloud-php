<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Dev\DocFx\Node;

use Kcs\ClassFinder\Finder\ComposerFinder;
use SimpleXMLElement;

/**
 * @internal
 */
class InterfaceNode extends ClassNode
{
    private array $implementingClasses = [];

    public function __construct(
        private SimpleXMLElement $xmlNode,
        private array $protoPackages = [],
    ) {
        parent::__construct($xmlNode, $protoPackages);
    }

    public function determineImplementingClasses(array $pageNodes): void
    {
        // Project root components
        $componentDirs = array_map('realpath', glob(__DIR__ . '/../../../../*/src', GLOB_ONLYDIR));
        $componentDirs[] = realpath(__DIR__ . '/../../../vendor/google/auth');
        $componentDirs[] = realpath(__DIR__ . '/../../../vendor/google/gax');

        $finder = new ComposerFinder();
        $finder
            ->in($componentDirs)
            ->implementationOf($this->getFullName());

        foreach ($finder as $className => $reflection) {
            // ensure the class is part of our published documentation
            if (isset($pageNodes['\\' . $className])) {
                $this->implementingClasses[] = '\\' . $className;
            }
        }
    }

    public function getLongDescription(): string
    {
        $longDescription = parent::getLongDescription();
        if (empty($this->implementingClasses)) {
            return $longDescription;
        }
        $longDescription .= empty($longDescription) ? '' : "\n";
        $longDescription .= 'Classes which implement this interface in this package:';

        foreach ($this->implementingClasses as $className) {
            $longDescription .= sprintf("\n - {@see %s}", $className);
        }

        return $longDescription;
    }
}
