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

/**
 * @internal
 */
trait XrefTrait
{
    private string $namespace;

    /**
     * @param string $type The parameter type to replace
     */
    private function normalizeTypedVariables(string $type): string
    {
        $types = explode('|', $type);

        // Remove redundant "RepeatedField" type for protobuf parameters
        // e.g. "@return array<Google\Cloud\SomeMessage>|\Google\Protobuf\Internal\RepeatedField[]"
        if (count($types) == 2 && '\Google\Protobuf\Internal\RepeatedField' === $types[1]) {
            array_pop($types);
        }

        foreach ($types as $i => $type) {
            if (0 === strpos($type, '\\')) {
                // Reformat "ClassName[]" to "array<ClassName>"
                if ('[]' === substr($type, -2)) {
                    $type = substr($type, 0, -2);
                    $types[$i] = $this->normalizeArrayType($type);
                } else {
                    $types[$i] = $this->replaceUidWithLink($type);
                }
            } elseif (0 === strpos($type, 'array<\\')) {
                $types[$i] = preg_replace_callback(
                    '/^array<([^ ]*)>$/',
                    function ($matches) {
                        return $this->normalizeArrayType($matches[1]);
                    },
                    $type
                );
            }
        }

        return implode('|', $types);
    }

    private function normalizeArrayType(string $type): string
    {
        return sprintf(
            htmlentities('array<%s>'),
            $this->replaceUidWithLink($type)
        );
    }

    private function replaceSeeTag(string $description): string
    {
        return preg_replace_callback(
            '/{@see ([^ ]*)}/',
            function ($matches) {
                return $this->replaceUidWithLink($matches[1]);
            },
            $description
        );
    }

    /**
     * Replaces protobuf references in text. This will match the following:
     *  - [link][google.cloud.automl.v1.SomeClass]
     *  - [link][google.cloud.automl.v1.SomeClass.some_property]
     *  - [link][google.cloud.automl.v1.SomeClass.SomeNestedClass]
     *  - [link][google.cloud.automl.v1.SomeServiceClass.SomeRpcMethod]
     */
    private function replaceProtoRef(string $description): string
    {
        return preg_replace_callback(
            '/\[([^\]]*?)\]\s?\[([a-z1-9\._]*)([a-zA-Z1-9_\.]*)\]/',
            function ($matches) {
                list($link, $name, $package, $class) = $matches;
                $property = $method = $constant = null;

                // if the last word is all lowercase, it's a property
                // if the last word is all uppercase, it's a constant
                // otherwise, it's a nested class
                if (preg_match('/([a-zA-Z\.]+)?\.([a-z_1-9]+)$/', $class, $propertyMatches)) {
                    $class = $propertyMatches[1];
                    $property = $propertyMatches[2];
                } elseif (preg_match('/([a-zA-Z\.]+)?\.([A-Z_1-9]+)$/', $class, $constantMatches)) {
                    $class = $constantMatches[1];
                    $constant = $constantMatches[2];
                }

                // Determine namespace
                $package = rtrim($package, '.');

                // Check the package name against the proto packages for this component (see Command\DocFx)
                $namespace =
                    $this->protoPackages[$package]
                    ?? str_replace(' ', '\\', ucwords(str_replace('.', ' ', $package)));

                $classParts = empty($class) ? [] : explode('.', $class);

                if ($property) {
                    // Convert the underscore property name to camel case getter method name
                    $property = ltrim($property, '.');
                    $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
                } elseif (is_null($constant) && count($classParts) === 2) {
                    // Check if the nested class exists, and if not, assume this is a service method
                    if (!class_exists($namespace . '\\' . implode('\\', $classParts))) {
                        if (class_exists($namespace . '\\' . $classParts[0] . 'Client')) {
                            $classParts[0] .= 'Client';
                            $method = lcfirst($classParts[1]);
                            array_pop($classParts);
                        } elseif (class_exists($namespace . '\\Client\\' . $classParts[0] . 'Client')) {
                            $classParts[0] = 'Client\\' . $classParts[0] . 'Client';
                            $method = lcfirst($classParts[1]);
                            array_pop($classParts);
                        }
                    }
                } elseif (
                    count($classParts) === 1
                    && !class_exists($namespace . '\\' . $classParts[0])
                ) {
                    if (class_exists($namespace . '\\Client\\' . $classParts[0])) {
                        $classParts = ['Client', $classParts[0]];
                    } elseif (class_exists($namespace . '\\Client\\' . $classParts[0] . 'Client')) {
                        $classParts = ['Client', $classParts[0] . 'Client'];
                    }
                }

                $uid = sprintf('\\%s\\%s', $namespace, implode('\\', $classParts));
                if ($method) {
                    $uid = sprintf('%s::%s()', $uid, $method);
                } elseif ($constant) {
                    $uid = sprintf('%s::%s', $uid, $constant);
                }

                return $this->replaceUidWithLink($uid, $name);
            },
            $description
        );
    }

    private function replaceUidWithLink(string $uid, ?string $name = null): string
    {
        if (is_null($name)) {
            $name = ltrim($uid, '\\');
            // Remove the namespace from the name if it matches the current namespace
            if (!empty($this->namespace) && str_starts_with($uid, $this->namespace)) {
                $name = substr($uid, strlen($this->namespace) + 1);
            }
        }

        // Case for generic types
        if (preg_match('/(.*)<(.*)>/', $uid, $matches)) {
            return sprintf(
                '%s&lt;%s&gt;',
                $this->replaceUidWithLink($matches[1]),
                $this->replaceUidWithLink($matches[2])
            );
        }

        // Check for external package namespaces
        switch (true) {
            case str_starts_with($uid, '\Google\Auth\\'):
                $extLinkRoot = 'https://googleapis.github.io/google-auth-library-php/main/';
                break;
            case str_starts_with($uid, '\Google\Protobuf\\'):
                $extLinkRoot = 'https://protobuf.dev/reference/php/api-docs/';
                break;
            case 0 === strpos($uid, '\GuzzleHttp\Promise\PromiseInterface'):
                $extLinkRoot = 'https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-GuzzleHttp.Promise.Promise.html';
                break;
            default:
                $extLinkRoot = '';
        }

        // Create external link
        if ($extLinkRoot) {
            if (str_starts_with($uid, '\Google')) {
                $extLinkRoot .= str_replace(['::', '\\', '()'], ['#method_', '/'], $name);
            }
            return sprintf('<a href="%s">%s</a>', $extLinkRoot, $name);
        }

        return sprintf('<xref uid="%s">%s</xref>', $uid, $name);
    }
}
