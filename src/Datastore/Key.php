<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore;

use InvalidArgumentException;
use JsonSerializable;

/**
 * Represents a Datastore Key.
 *
 * Keys are unique identifiers for entities.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $datastore = $cloud->datastore();
 *
 * $key = $datastore->key('Person', 'Bob');
 * ```
 *
 * ```
 * // Keys with complex paths can be constructed by chaining method calls.
 *
 * $key = $datastore->key('Person', 'Bob');
 * $key->ancestor('Parents', 'Joe');
 * $key->ancestor('Grandparents', 'Barb');
 * ```
 *
 * ```
 * // Path elements can also be appended, so long as the current last path
 * // element contains a kind and identifier.
 *
 * $key = $datastore->key('Grandparents', 'Barb');
 * $key->pathElement('Parents', 'Joe');
 * $key->pathElement('Person');
 * $key->pathElement('Child', 'Dave'); // Error here.
 * ```
 *
 * @see https://cloud.google.com/datastore/reference/rest/v1/Key Key
 */
class Key implements JsonSerializable
{
    use DatastoreTrait;

    const TYPE_NAME = 'name';
    const TYPE_ID = 'id';

    const STATE_COMPLETE   = 'complete';
    const STATE_INCOMPLETE = 'incomplete';

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var array
     */
    private $path = [];

    /**
     * @var array
     */
    private $options;

    /**
     * Create a Key.
     *
     * @param string $projectId The project ID.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $namespaceId Partitions data under a namespace. Useful for
     *           [Multitenant Projects](https://cloud.google.com/datastore/docs/concepts/multitenancy).
     *           Applications with no need for multitenancy should not set this value.
     *     @type array $path The initial Key path.
     * }
     */
    public function __construct($projectId, array $options = [])
    {
        $this->projectId = $projectId;
        $this->options = $options + [
            'path' => [],
            'namespaceId' => null
        ];

        if (is_array($this->options['path']) && !empty($this->options['path'])) {
            $this->path = $this->normalizePath($this->options['path']);
        }

        unset($this->options['path']);
    }

    /**
     * Add a path element to the end of the Key path
     *
     * If the previous pathElement is incomplete (has no name or ID specified),
     * an `InvalidArgumentException` will be thrown. Once an incomplete
     * pathElement is given, the key cannot be extended any further.
     *
     * Example:
     * ```
     * $key->pathElement('Person', 'Jane');
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind.
     * @param string|int $identifier [optional] The name or ID of the object.
     * @param string $identifierType [optional] If omitted, the type will be determined
     *        internally. Setting this to either `Key::TYPE_ID` or
     *        `Key::TYPE_NAME` will force the pathElement identifier type.
     * @return Key
     * @throws InvalidArgumentException
     */
    public function pathElement($kind, $identifier = null, $identifierType = null)
    {
        if (!empty($this->path) && $this->state() !== Key::STATE_COMPLETE) {
            throw new InvalidArgumentException(
                'Cannot add pathElement because the previous element is missing an id or name'
            );
        }

        $pathElement = $this->normalizeElement($kind, $identifier, $identifierType);

        $this->path[] = $pathElement;

        return $this;
    }

    /**
     * Add a path element to the beginning of the Key path.
     *
     * Example:
     * ```
     * $key->ancestor('Person', 'Bob');
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind.
     * @param string|int $identifier The name or ID of the object.
     * @param string $identifierType [optional] If omitted, the type will be determined
     *        internally. Setting this to either `Key::TYPE_ID` or
     *        `Key::TYPE_NAME` will force the pathElement identifier type.
     * @return Key
     */
    public function ancestor($kind, $identifier, $identifierType = null)
    {
        $pathElement = $this->normalizeElement($kind, $identifier, $identifierType);

        array_unshift($this->path, $pathElement);

        return $this;
    }

    /**
     * Use another Key's path as the current Key's ancestor
     *
     * Given key path will be prepended to any path elements on the current key.
     *
     * Example:
     * ```
     * $parent = $datastore->key('Person', 'Dad');
     * $key->ancestoryKey($parent);
     * ```
     *
     * @param Key $key The ancestor Key.
     * @return Key
     * @throws InvalidArgumentException
     */
    public function ancestorKey(Key $key)
    {
        if ($key->state() !== self::STATE_COMPLETE) {
            throw new InvalidArgumentException('Cannot use an incomplete key as an ancestor');
        }

        $path = $key->path();

        $this->path = array_merge($path, $this->path);

        return $this;
    }

    /**
     * Check if the Key is considered Complete or Incomplete.
     *
     * Use `Key::STATE_COMPLETE` and `Key::STATE_INCOMPLETE` to check value.
     *
     * Example:
     * ```
     * // An incomplete key does not have an ID on its last path element.
     * $key = $datastore->key('parent', 1234)
     *     ->pathElement('child');
     *
     * if ($key->state() === Key::STATE_INCOMPLETE) {
     *     echo 'Key is incomplete!';
     * }
     * ```
     *
     * ```
     * // A complete key has a kind and an identifier on each path element.
     * $key = $datastore->key('parent', 1234)
     *     ->pathElement('child', 4321);
     *
     * if ($key->state() === Key::STATE_COMPLETE) {
     *     echo 'Key is complete!';
     * }
     * ```
     *
     * @return bool
     */
    public function state()
    {
        $end = $this->pathEnd();
        return (isset($end['id']) || isset($end['name']))
            ? self::STATE_COMPLETE
            : self::STATE_INCOMPLETE;
    }

    /**
     * Set the value of the last path element in a Key
     *
     * This method is used internally when IDs are allocated to existing instances
     * of a Key. It should not generally be used externally.
     *
     * @param string $value The value of the ID or Name.
     * @param string $type [optional] 'id' or 'name'. **Defaults to** `"id"`.
     * @return void
     * @access private
     */
    public function setLastElementIdentifier($value, $type = Key::TYPE_ID)
    {
        $end = $this->pathEnd();
        $end[$type] = (string) $value;

        $elements = array_keys($this->path);
        $lastElement = end($elements);

        $this->path[$lastElement] = $end;
    }

    /**
     * Get the key path
     *
     * Example:
     * ```
     * $path = $key->path();
     * ```
     *
     * @return array
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Get the last pathElement in the key
     *
     * Example:
     * ```
     * $lastPathElement = $key->pathEnd();
     * ```
     *
     * @return array
     */
    public function pathEnd()
    {
        $path = $this->path;
        $end = end($path);

        return $end;
    }

    /**
     * Get the key object formatted for the datastore service.
     *
     * @access private
     * @return array
     */
    public function keyObject()
    {
        return [
            'partitionId' => $this->partitionId($this->projectId, $this->options['namespaceId']),
            'path' => $this->path
        ];
    }

    /**
     * @access private
     */
    public function jsonSerialize()
    {
        return $this->keyObject();
    }

    /**
     * Determine the identifier type and return the valid pathElement
     *
     * @param string $kind the kind.
     * @param mixed $identifier The ID or name.
     * @param string $identifierType Either `id` or `name`.
     * @return array
     */
    private function normalizeElement($kind, $identifier, $identifierType)
    {
        $identifierType = $this->determineIdentifierType($identifier, $identifierType);

        $element = [];
        $element['kind'] = $kind;

        if (!is_null($identifier)) {
            $element[$identifierType] = $identifier;
        }

        return $element;
    }

    /**
     * Determine whether the given identifier is an ID or a Name
     *
     * @param mixed $identifier The given value.
     * @param string|null $identifierType If not null and allowed, this will be
     *        used as the type. If null, type will be inferred.
     * @return string
     * @throws InvalidArgumentException
     */
    private function determineIdentifierType($identifier, $identifierType)
    {
        $allowedTypes = [self::TYPE_ID, self::TYPE_NAME];

        if (!is_null($identifierType) && in_array($identifierType, $allowedTypes)) {
            return $identifierType;
        } elseif (!is_null($identifierType)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid identifier type %s',
                $identifierType
            ));
        }

        if (is_numeric($identifier)) {
            return self::TYPE_ID;
        }

        return self::TYPE_NAME;
    }

    /**
     * Normalize the internal representation of a path
     *
     * @param array $path
     * @return array
     * @throws InvalidArgumentException
     */
    private function normalizePath(array $path)
    {
        // If the path is associative (i.e. not nested), wrap it up.
        if ($this->isAssoc($path)) {
            $path = [$path];
        }

        $res = [];
        foreach ($path as $index => $pathElement) {
            if (!isset($pathElement['kind'])) {
                throw new InvalidArgumentException('Each path element must contain a kind.');
            }

            $incomplete = (!isset($pathElement['id']) && !isset($pathElement['name']));
            if ($index < count($path) -1 && $incomplete) {
                throw new InvalidArgumentException(
                    'Only the final pathElement may omit a name or ID.'
                );
            }

            if (isset($pathElement['id']) && !is_string($pathElement['id'])) {
                $pathElement['id'] = (string) $pathElement['id'];
            }

            $res[] = $pathElement;
        }

        return $res;
    }

    /**
     * Represent the path as a string.
     *
     * @access private
     */
    public function __toString()
    {
        $el = [];
        foreach ($this->path as $element) {
            $element = $element + [
                'id' => null,
                'name' => null
            ];
            $id = ($element['id']) ? $element['id'] : $element['name'];
            $el[] = sprintf('[%s: %s]', $element['kind'], $id);
        }

        return sprintf('[ %s ]', implode(', ', $el));
    }
}
