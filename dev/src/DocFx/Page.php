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

namespace Google\Cloud\Dev\DocFx;

use Google\Cloud\Dev\DocFx\Node\ClassNode;

/**
 * Class to output the DocFX array before exporting to YAML.
 */
class Page
{
    public function __construct(
        private ClassNode $classNode,
        private string $filePath
    ) {}

    public function getClassNode(): ClassNode
    {
        return $this->classNode;
    }

    public function getFilename(): string
    {
        $filename = str_replace(['src/', '.php'], '', $this->filePath);

        return str_replace('/', '.', $filename);
    }

    public function getItems(): array
    {
        $methods = $this->getMethodItems();
        $constants = $this->getConstantItems();

        $classItem = $this->getClassItem();
        if ($children = array_merge(array_keys($methods), array_keys($constants))) {
            $classItem['children'] = $children;
        }

        return array_merge(
            [$classItem],
            array_values($methods),
            array_values($constants)
        );
    }

    private function getClassItem(): array
    {
        return array_filter([
            'uid' => $this->classNode->getFullname(),
            'name' => $this->classNode->getName(),
            'id' => $this->classNode->getName(),
            'summary' => $this->classNode->getContent(),
            'status' => $this->classNode->getStatus(),
            'type' => 'class',
            'langs' => ['php'],
            'implements' => $this->classNode->getImplements(),
        ]);
    }

    private function getMethodItems(): array
    {
        $methods = [];

        foreach ($this->classNode->getMethods() as $method) {
            $methodItem = array_filter([
                'uid' => $method->getFullname(),
                'name' => $method->getName(),
                'id' => $method->getName(),
                'summary' => $method->getContent(),
                'parent'  => $this->classNode->getFullname(),
                'type' => 'method',
                'langs' => ['php'],
                // 'syntax' => array_filter([
                //     'content' => $method->getContent(),
                // ]),
            ]);
            if ($parameters = $method->getParameters()) {
                $methodItem['syntax']['parameters'] = [];
                foreach ($parameters as $parameter) {
                    $methodItem['syntax']['parameters'][] = [
                        'id' => $parameter->getName(),
                        'var_type' => $parameter->getType(),
                        'description' => $parameter->getDescription(),
                    ];
                }
            }
            if ($returnType = $method->getReturnType()) {
                $methodItem['syntax']['return'] = array_filter([
                    'type' => [$returnType],
                    'description' => $method->getReturnDescription(),
                ]);
            }

            $methods[$methodItem['uid']] = $methodItem;
        }

        return $methods;
    }

    private function getConstantItems(): array
    {
        $constants = [];

        foreach ($this->classNode->getConstants() as $constant) {
            $constantItem = array_filter([
                'uid' => $constant->getFullname(),
                'name' => $constant->getName(),
                'id' => $constant->getName(),
                'summary' => $constant->getContent(),
                'parent'  => $this->classNode->getFullname(),
                'type' => 'const',
                'langs' => ['php'],
                'syntax' => [
                    'content' => 'Value: ' . $constant->getValue(),
                ],
            ]);

            $constants[$constantItem['uid']] = $constantItem;
        }

        return $constants;
    }
}
