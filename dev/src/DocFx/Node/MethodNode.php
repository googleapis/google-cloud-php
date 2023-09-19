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

/**
 * @internal
 */
class MethodNode
{
    use DocblockTrait {
        getContent as getDocblockContent;
    }
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

    public function getExample(): string
    {
        if ($this->xmlNode->docblock) {
            foreach ($this->xmlNode->docblock->tag as $tag) {
                if ($tag['name'] == 'example' && (string) $tag['description']) {
                    return $tag['description'];
                }
            }
        }
        return '';
    }

    public function isStatic(): bool
    {
        return 'true' === (string) $this->xmlNode['static'];
    }

    /**
     * Allows exclusion of some methods we don't want to display in the docs,
     * such as magic methods. Right now the only such method is "__call".
     */
    public function isExcludedMethod(): bool
    {
        return $this->getName() === '__call';
    }

    public function isOperationMethod(): bool
    {
        return $this->getName() === 'getOperationsClient'
            || $this->getName() === 'resumeOperation';
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
                $this->replaceSeeTag($this->replaceProtoRef($description))
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

    public function getDisplayName(): string
    {
        return $this->isStatic() ? 'static::' . $this->getName() : $this->getName();
    }

    public function getContent(): string
    {
        $content = $this->getDocblockContent();
        $links = [];
        if ($this->xmlNode->docblock) {
            foreach ($this->xmlNode->docblock->tag as $tag) {
                if ($tag['name'] == 'see') {
                    $link = (string) $tag['link'];
                    $description = ((string) $tag['description']) ?: $link;
                    if (0 === strpos($link, 'http')) {
                        $links[] = sprintf("<a href=\"%s\">%s</a>", $link, $description);
                    } else {
                        $links[] = $this->replaceUidWithLink($link, $description);
                    }

                }
            }
        }
        if ($links) {
            // Add links as an unordered list
            $content = "\nSee also:";
            $content .= "\n - " . implode("\n - ", $links);
        }

        return $content;
    }
}
