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

use phpDocumentor\Reflection\Types\ContextFactory;
use phpDocumentor\Reflection\FqsenResolver;

/**
 * @internal
 */
class ParameterNode
{
    use XrefTrait;

    public function __construct(
        private string $name,
        private string $type,
        private string $description,
        private string $namespace,
        private string $className,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->normalizeTypedVariables($this->type);
    }

    public function getDescription(): string
    {
        return html_entity_decode($this->description);
    }

    /**
     * For option arrays with nested parameters.
     * Example:
     * ```
     * param $options {
     *    @type string $key
     *         Some description of the "key" option
     * }
     * ```
     */
    public function hasNestedParameters(): bool
    {
        $description = trim(str_replace('[optional]', '', $this->description));

        if (strlen($description) === 0) {
            return false;
        }

        return $description[0] === '{';
    }

    /**
     * PHPDoc has no support for nested parameters. This is a workaround to parse
     * our custom format.
     */
    public function getNestedParameters(): array
    {
        $parameters = [];

        // Remove "optional" prefix (in handwritten clients).
        $parameterString = trim(str_replace('[optional]', '', $this->description));

        // Remove wrapping "{}".
        $parameterString = substr($parameterString, 1, -1);

        // Create an array item for each parameter.
        $nestedParameters = preg_split('/(?<!\\\\)@type/', $parameterString);

        // Remove the first, since that's the wrapping array param,
        // and use it for the wrapping param description
        if ($parentDescription = trim(array_shift($nestedParameters))) {
            $this->description = $parentDescription;
        }

        foreach ($nestedParameters as $param) {
            // Parse "@type string $key" syntax
            if (!preg_match('/^([^ ]+) +([\$\w\.]+)(.*)?/sm', trim($param), $matches)) {
                throw new \LogicException('unable to parse nested parameter "' . $param . '"');
            }
            list($_, $type, $name, $description) = $matches + [3 => ''];
            $type = $this->resolveNestedType($type);

            // remove "$" prefix from parameter name and add "↳ " for UX to indicate it's nested.
            $name = '↳ ' . ltrim($name, '$');

            // Trim newline whitespace
            $description = preg_replace('/\s+/', ' ', $description);

            $parameter = new ParameterNode(
                $name,
                $type,
                $this->replaceSeeTag(trim($description)),
                $this->namespace,
                $this->className,
            );

            if (isset($this->parentNode)) {
                $parameter->setParentNode($this->parentNode);
            }

            $parameters[] = $parameter;
        }

        return $parameters;
    }

    private function resolveNestedType(string $name): string
    {
        if (false !== strpos($name, '|')) {
            return implode('|', array_map(
                fn($type) => $this->resolveNestedType($type),
                explode('|', $name)
            ));
        }

        if ('[]' === substr($name, -2)) {
            $name = sprintf('array<%s>', substr($name, 0, -2));
        }

        if (0 === strpos($name, 'array<')) {
            return preg_replace_callback(
                '/^array<([^ ]*)>$/',
                function ($matches) {
                    return sprintf('array<%s>', $this->resolveNestedType($matches[1]));
                },
                $name
            );
        }

        if (match ($name) {
            'int', 'integer',
            'float', 'double',
            'string',
            'bool', 'boolean',
            'array',
            'object',
            'callable',
            'iterable',
            'void',
            'null',
            'mixed',
            'never',
            'false', 'true' => true,
            default => false,
        }) {
            return $name;
        }

        // Fail silently for unresolvable types
        if (!class_exists($this->className)) {
            return $name;
        }

        // Automatically extract the namespace and imports from the target class
        $context = (new ContextFactory())
            ->createFromReflector(new \ReflectionClass($this->className));

        // Resolve your raw string against that file's context
        $resolver = new FqsenResolver();
        $resolved = $resolver->resolve($name, $context);
        return (string) $resolved;
    }
}
