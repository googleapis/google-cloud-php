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

namespace Google\Cloud\Dev\DocFx\Node;

use SimpleXMLElement;

class MethodNode
{
    use DocblockTrait;
    use ParentNodeTrait;
    use VisibilityTrait;

    public function __construct(
        private SimpleXMLElement $xmlNode,
        private array $protoPackages = []
    ) {}

    public function getReturnType(): string
    {
        if ($returnType = $this->getReturnTypeTag()) {
            return $this->normalizeTypedVariables($returnType);
        }
        return '';
    }

    public function getReturnDescription(): string
    {
        if ($this->xmlNode->docblock) {
            foreach ($this->xmlNode->docblock->tag as $tag) {
                if ($tag['name'] == 'return') {
                    if ((string) $tag['description']) {
                        return (string) $tag['description'];
                    }
                    break;
                }
            }
        }

        return '';
    }

    private function getReturnTypeTag(): string
    {
        if ($this->xmlNode->docblock) {
            foreach ($this->xmlNode->docblock->tag as $tag) {
                if ($tag['name'] == 'return' && (string) $tag['type']) {
                    return $tag['type'];
                }
            }
        }
        return '';
    }

    public function getParameters(): array
    {
        $parameters = [];
        foreach ($this->xmlNode->argument as $parameterNode) {
            // Determine the description of the parameter
            $parameterName = (string) $parameterNode->name;
            $description = '';
            if ($this->xmlNode->docblock) {
                foreach ($this->xmlNode->docblock->tag as $tag) {
                    if ($tag['name'] == 'param') {
                        if ((string) $tag['variable'] === $parameterName) {
                            $description = (string) $tag['description'];
                        }
                    }
                }
            }
            $parameter = new ParameterNode(
                $parameterName,
                (string) $parameterNode->type,
                $this->replaceProtoRef($description)
            );

            $parameters[] = $parameter;

            // For option arrays with nested parameters. Example:
            // @param array $options {
            //    @type string $key
            //         Some description of the "key" option
            // }
            if ($parameter->hasNestedParameters()) {
                $parameters = array_merge(
                    $parameters,
                    $parameter->getNestedParameters()
                );
            }
        }

        return $parameters;
    }
}
