<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Datastore;

use ArrayAccess;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

/**
 * A Datastore Entity
 *
 * Entity implements PHP's [ArrayAccess](http://php.net/arrayaccess), allowing
 * access via the array syntax (example below).
 *
 * Properties are mapped automatically to their corresponding Datastore value
 * types. Refer to the table below for a guide to how types are stored.
 *
 * | **PHP Type**                               | **Datastore Value Type**             |
 * |--------------------------------------------|--------------------------------------|
 * | `\DateTimeInterface`                       | `timestampValue`                     |
 * | {@see Google\Cloud\Datastore\Key}          | `keyValue`                           |
 * | {@see Google\Cloud\Datastore\GeoPoint}     | `geoPointValue`                      |
 * | {@see Google\Cloud\Datastore\Entity}       | `entityValue`                        |
 * | {@see Google\Cloud\Datastore\Blob}         | `blobValue`                          |
 * | {@see Google\Cloud\Core\Int64}             | `integerValue`                       |
 * | Associative Array                          | `entityValue` (No Key)               |
 * | Non-Associative Array                      | `arrayValue`                         |
 * | `float`                                    | `doubleValue`                        |
 * | `int`                                      | `integerValue`                       |
 * | `string`                                   | `stringValue`                        |
 * | `resource`                                 | `blobValue`                          |
 * | `NULL`                                     | `nullValue`                          |
 * | `bool`                                     | `booleanValue`                       |
 * | `object` (Outside types specified above)   | **ERROR** `InvalidArgumentException` |
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $key = $datastore->key('Person', 'Bob');
 * $entity = $datastore->entity($key, [
 *     'firstName' => 'Bob',
 *     'lastName' => 'Testguy'
 * ]);
 *
 * echo $entity['firstName']; // 'Bob'
 * $entity['location'] = 'Detroit, MI';
 * ```
 *
 * @see https://cloud.google.com/datastore/docs/reference/rest/v1/Entity Entity API documentation
 */
class Entity implements ArrayAccess
{
    use DatastoreTrait;

    const EXCLUDE_FROM_INDEXES = '___GOOGLECLOUDPHP___EXCLUDEFROMINDEXES___';

    /**
     * @var Key
     */
    private $key;

    /**
     * @var array
     */
    private $entity;

    /**
     * @var array
     */
    private $options;

    /**
     * @param Key $key The Entity's Key, defining its unique identifier.
     * @param array $entity [optional] The entity body.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $cursor Set only when the entity is obtained by a query
     *           result. If set, the entity cursor can be retrieved from
     *           {@see Google\Cloud\Datastore\Entity::cursor()}.
     *     @type string $baseVersion Set only when the entity is obtained by a
     *           query result. If set, the entity cursor can be retrieved from
     *           {@see Google\Cloud\Datastore\Entity::baseVersion()}.
     *     @type array $excludeFromIndexes A list of entity keys to exclude from
     *           datastore indexes.
     *     @type array $meanings A list of meaning values for entity properties.
     *     @type bool $populatedByService Indicates whether the entity was
     *           created as the result of a service request.
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(Key $key, array $entity = [], array $options = [])
    {
        $this->key = $key;
        $this->entity = $entity;
        $this->options = $options + [
            'cursor' => null,
            'baseVersion' => null,
            'populatedByService' => false,
            'excludeFromIndexes' => [],
            'meanings' => []
        ];
    }

    /**
     * Get the entity data
     *
     * Example:
     * ```
     * $data = $entity->get();
     * ```
     *
     * @return array
     */
    public function get()
    {
        return $this->entity;
    }

    /**
     * Set the entity data
     *
     * Calling this method replaces the entire entity body. To add or modify a
     * single value on the entity, use the array syntax for assignment.
     *
     * Example:
     * ```
     * $entity->set([
     *     'firstName' => 'Dave'
     * ]);
     * ```
     *
     * @param array $entity The new entity body.
     * @return void
     */
    public function set(array $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the Entity Key
     *
     * Example:
     * ```
     * $key = $entity->key();
     * ```
     *
     * @return Key
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Fetch the cursor
     *
     * This is only set when the entity was obtained from a query result. It
     * can be used to manually paginate results.
     *
     * Example:
     * ```
     * $cursor = $entity->cursor();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/EntityResult EntityResult.cursor
     *
     * @return string|null
     */
    public function cursor()
    {
        return $this->options['cursor'];
    }

    /**
     * Fetch the baseVersion
     *
     * This is only set when the entity was obtained from a query result. It
     * is used for concurrency control internally.
     *
     * Example:
     * ```
     * $baseVersion = $entity->baseVersion();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/EntityResult EntitResult.version
     *
     * @return string|null
     */
    public function baseVersion()
    {
        return $this->options['baseVersion'];
    }

    /**
     * Indicate whether the entity was created as the result of an API call.
     *
     * Example:
     * ```
     * $populatedByService = $entity->populatedByService();
     * ```
     *
     * @return bool
     */
    public function populatedByService()
    {
        return $this->options['populatedByService'];
    }

    /**
     * A list of entity properties to exclude from datastore indexes.
     *
     * Example:
     * ```
     * $entity['birthDate'] = new DateTime('December 31, 1969');
     * $entity->setExcludeFromIndexes([
     *     'birthDate'
     * ]);
     * ```
     *
     * @param array $properties A list of properties to exclude from indexes.
     * @return void
     */
    public function setExcludeFromIndexes(array $properties)
    {
        $this->options['excludeFromIndexes'] = $properties;
    }

    /**
     * Return a list of properties excluded from datastore indexes
     *
     * Example:
     * ```
     * $excludedFromIndexes = $entity->excludedProperties();
     * ```
     *
     * @return array
     */
    public function excludedProperties()
    {
        return $this->options['excludeFromIndexes'];
    }

    /**
     * return a list of meaning values
     *
     * Example:
     * ```
     * $meanings = $entity->meanings();
     * ```
     *
     * @return array
     */
    public function meanings()
    {
        return $this->options['meanings'];
    }

    /**
     * @param string $key The value name.
     * @param mixed $value The value.
     * @return void
     * @access private
     */
    public function offsetSet($key, $val)
    {
        $this->entity[$key] = $val;
    }

    /**
     * @param string $key the value to check.
     * @return bool
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($this->entity[$key]);
    }

    /**
     * @param string $key the value to remove.
     * @return void
     * @access private
     */
    public function offsetUnset($key)
    {
        unset($this->entity[$key]);
    }

    /**
     * @param string $key the value to retrieve.
     * @return mixed
     * @access private
     */
    public function offsetGet($key)
    {
        return isset($this->entity[$key])
            ? $this->entity[$key]
            : null;
    }

    /**
     * @param string $property
     * @return mixed
     * @access private
     */
    public function __get($property)
    {
        return $this->offsetGet($property);
    }

    /**
     * @param string $property
     * @param mixed $value
     * @return void
     * @access private
     */
    public function __set($property, $value)
    {
        $this->offsetSet($property, $value);
    }

    /**
     * @param string $property
     * @return void
     * @access private
     */
    public function __unset($property)
    {
        if ($this->offsetExists($property)) {
            $this->offsetUnset($property);
        }
    }

    /**
     * @param string $property
     * @return bool
     * @access private
     */
    public function __isset($property)
    {
        return $this->offsetExists($property) && $this->offsetGet($property) !== null;
    }
}
