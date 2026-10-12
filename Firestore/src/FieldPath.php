<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

/**
 * Represents a path to a Firestore Document field.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $path = $firestore->fieldPath(['accounts', 'usd']);
 * ```
 */
class FieldPath
{
    const SPECIAL_CHARS = '/^[^*~\/[\]]+$/';
    const UNESCAPED_FIELD_NAME = '/^[_a-zA-Z][_a-zA-Z0-9]*$/';

    /**
     * @var array
     */
    private $fieldNames;

    /**
     * @param array $fieldNames A list of field names.
     * @throws \InvalidArgumentException If an empty path element is provided.
     */
    public function __construct(array $fieldNames)
    {
        foreach ($fieldNames as $field) {
            // falsey is good enough unless the field is actually `0`.
            if (!$field && $field !== 0) {
                throw new \InvalidArgumentException(sprintf(
                    'Field paths cannot contain empty path elements. Given path was `%s`.',
                    implode('.', $fieldNames)
                ));
            }
        }

        $this->fieldNames = $fieldNames;
    }

    /**
     * Create a field path indicating the document ID.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldPath;
     *
     * $path = FieldPath::documentId();
     * ```
     *
     * @return FieldPath
     */
    public static function documentId()
    {
        return new self(['__name__']);
    }

    /**
     * Create a FieldPath from a string path.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldPath;
     *
     * $path = FieldPath::fromString('path.to.field');
     * ```
     *
     * @param string $path The field path string.
     * @param bool $splitPath If false, the input path will not be split on `.`.
     *        **Defaults to** `true`.
     * @return FieldPath
     * @throws \InvalidArgumentException If an invalid path is provided.
     */
    public static function fromString($path, $splitPath = true)
    {
        self::validateString($path);

        $parts = $splitPath
            ? explode('.', $path)
            : [$path];

        return new self($parts);
    }

    /**
     * Get a new FieldPath with the given path part appended to the current
     * path.
     *
     * Example:
     * ```
     * $child = $path->child('element');
     * ```
     *
     * @param string $part The child path part.
     * @return FieldPath
     * @throws \InvalidArgumentException If an empty path element is provided.
     */
    public function child($part)
    {
        $fieldNames = $this->fieldNames;
        $fieldNames[] = $part;

        return new static($fieldNames);
    }

    /**
     * Get the current path as a string, with special characters escaped.
     *
     * Example:
     * ```
     * $string = $path->pathString();
     * ```
     *
     * @return string
     */
    public function pathString()
    {
        $out = [];
        foreach ($this->fieldNames as $part) {
            $out[] = $this->escapePathPart($part);
        }

        $fieldPath = implode('.', $out);

        return $fieldPath;
    }

    /**
     * Get the path elements.
     *
     * @access private
     * @return array
     */
    public function path()
    {
        return $this->fieldNames;
    }

    /**
     * Cast the path to a string.
     *
     * @return string
     * @access private
     */
    public function __toString()
    {
        return $this->pathString();
    }

    /**
     * Test a field path component, checking for any special characters,
     * and escaping as required.
     *
     * @param string $part The raw field path component.
     * @return string
     */
    private function escapePathPart($part)
    {
        // If no special characters are found, return the input unchanged.
        if (preg_match(self::UNESCAPED_FIELD_NAME, $part)) {
            return $part;
        }

        // If the string is already wrapped in backticks, return as-is.
        if (substr($part, 0, 1) === '`' && substr($part, -1) === '`' && strlen($part) > 1) {
            return $part;
        }

        return '`' . str_replace('`', '\\`', str_replace('\\', '\\\\', $part)) . '`';
    }

    /**
     * Check if a given string field path is valid.
     *
     * @param string $fieldPath
     * @throws \InvalidArgumentException
     */
    private static function validateString($fieldPath)
    {
        if (strpos($fieldPath, '..')) {
            throw new \InvalidArgumentException('Paths cannot contain `..`.');
        }

        if (strpos($fieldPath, '.') === 0 || strpos(strrev($fieldPath), '.') === 0) {
            throw new \InvalidArgumentException('Paths cannot begin or end with `.`.');
        }
    }
}
