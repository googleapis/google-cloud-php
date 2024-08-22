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
            '/\[([^\]]*?)\]\s?\[([a-z][a-z1-9\._]*)?([a-zA-Z][a-zA-Z1-9_\.]*)?\]/',
            function ($matches) {
                list($link, $name, $package, $class) = $matches + ['', '', '', ''];
                $property = $method = $constant = null;

                // if the last word is all lowercase, it's a property
                // if the last word is all uppercase, it's a constant
                // otherwise, it's a nested class
                if (preg_match('/([a-zA-Z\.]+)?\.([a-z1-9_]+)$/', $class, $propertyMatches)) {
                    $class = $propertyMatches[1];
                    $property = $propertyMatches[2];
                } elseif (preg_match('/([a-zA-Z\.]+)?\.([A-Z1-9_]+)$/', $class, $constantMatches)) {
                    $class = $constantMatches[1];
                    $constant = $constantMatches[2];
                }

                // Determine namespace
                $package = rtrim($package, '.');

                // Check the package name against the proto packages for this component (see Command\DocFx)
                $namespace =
                    $this->protoPackages[$package] ?? implode('\\', array_map('ucfirst', explode('.', $package)));

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

                $uid = ($namespace ? '\\' . $namespace : '') . '\\' . implode('\\', $classParts);
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

    private function replaceUidWithLink(string $uid, string $name = null): string
    {
        // Remove preceeding "\" from namespace
        $name = $name ?: ltrim($uid, '\\');

        // Check for external package namespaces
        switch (true) {
            case 0 === strpos($uid, '\Google\ApiCore\\'):
                $extLinkRoot = 'https://googleapis.github.io/gax-php#';
                break;
            case 0 === strpos($uid, '\Google\Auth\\'):
                $extLinkRoot = 'https://googleapis.github.io/google-auth-library-php/main/';
                break;
            case 0 === strpos($uid, '\Google\Protobuf\\'):
                $extLinkRoot = 'https://protobuf.dev/reference/php/api-docs/';
                break;
            case 0 === strpos($uid, '\Google\Api\\'):
            case 0 === strpos($uid, '\Google\Cloud\Iam\V1\\'):
            case 0 === strpos($uid, '\Google\Cloud\Location\\'):
            case 0 === strpos($uid, '\Google\Cloud\Logging\Type\\'):
            case 0 === strpos($uid, '\Google\Iam\\'):
            case 0 === strpos($uid, '\Google\Rpc\\'):
            case 0 === strpos($uid, '\Google\Type\\'):
                $extLinkRoot = 'https://googleapis.github.io/common-protos-php#';
                break;
            default:
                $extLinkRoot = '';
        }

        // Create external link
        if ($extLinkRoot) {
            $path = str_replace(['::', '\\', '()'], ['#method_', '/'], $name);
            return sprintf('<a href="%s">%s</a>', $extLinkRoot . $path, $name);
        }

        return sprintf('<xref uid="%s">%s</xref>', $uid, $name);
    }
}
