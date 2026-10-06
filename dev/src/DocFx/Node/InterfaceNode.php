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

use Google\Cloud\Core\Logger\AppEngineFlexFormatter;
use Google\Cloud\Core\Logger\AppEngineFlexFormatterV2;
use ReflectionClass;
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

    /**
     * Finds classes in the current package ($pageNodes) that implement this interface.
     *
     * We use ReflectionClass::implementsInterface() rather than reading <implements> tags from
     * phpDocumentor's structure.xml because structure.xml only records interfaces declared
     * directly on a class, omitting interfaces inherited through a parent class (e.g.
     * ServiceAccountCredentials extends CredentialsLoader, which implements FetchAuthTokenInterface).
     */
    public function determineImplementingClasses(array $pageNodes): void
    {
        $interfaceName = ltrim($this->getFullName(), '\\');
        if (!interface_exists($interfaceName)) {
            return;
        }

        foreach (array_keys($pageNodes) as $className) {
            // We cannot run "class_exists" on these classes because they will throw a fatal error.
            if (in_array(
                $className,
                ['\\' . AppEngineFlexFormatter::class, '\\' . AppEngineFlexFormatterV2::class]
            )) {
                continue;
            }
            if (!class_exists($className)) {
                continue;
            }
            $reflection = new ReflectionClass($className);
            if (!$reflection->isEnum() && $reflection->implementsInterface($interfaceName)) {
                $this->implementingClasses[] = $className;
            }
        }

        sort($this->implementingClasses);
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
