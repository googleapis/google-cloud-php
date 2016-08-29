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
use JsonSerializable;
use Psr\Http\Message\StreamInterface;

/**
 * A Datastore Entity
 *
 * Entity implements PHP's [ArrayAccess](http://php.net/arrayaccess), allowing
 * access via the array syntax (example below).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder;
 * $datastore = $cloud->datastore();
 *
 * $key = $datastore->key('Person', 'Bob');
 * $entity = $datastore->entity($key), [
 *     'firstName' => 'Bob',
 *     'lastName' => 'Testguy'
 * ]);
 *
 * echo $entity['firstName']; // 'Bob'
 * $entity['location'] = 'Detroit, MI';
 * ```
 */
class Entity implements JsonSerializable, ArrayAccess
{
    use DatastoreTrait;

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
     * @param Key $key The Entity's Key, defining its unique identifier
     * @param array $entity The entity body
     * @param array $options {
     *     Configuration Options
     *
     *     @type bool $encode If set to true, some values will be base64_encoded
     *     @type string $cursor Set only when the entity is obtained by a query
     *           result. If set, the entity cursor can be retrieved from
     *           {@see Google\Cloud\Datastore\Entity::cursor()}.
     * }
     */
    public function __construct(Key $key, $entity = [], array $options = [])
    {
        if ($key->state() !== Key::STATE_COMPLETE) {
            throw new \InvalidArgumentException(
                'Entities cannot be created using incomplete keys'
            );
        }

        $this->key = $key;
        $this->entity = $entity;
        $this->options = $options + [
            'encode' => true,
            'cursor' => null,
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
     * @param array $entity The new entity body
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
     * @return string|null
     */
    public function cursor()
    {
        return $this->options['cursor'];
    }

    /**
     * The JSON respresentation of an entity
     *
     * @access private
     */
    public function jsonSerialize()
    {
        return $this->entityObject();
    }

    /**
     * Get the entity formatted for the API.
     *
     * This method is used internally and is not meant for use outside the
     * client library API.
     *
     * @access private
     * @return array
     */
    public function entityObject()
    {
        $properties = [];
        foreach ($this->entity as $key => $value) {
            $properties[$key] = $this->valueObject($value, $this->options['encode']);
        }

        return [
            'key' => $this->key,
            'properties' => $properties
        ];
    }

    /**
     * @access private
     */
    public function offsetSet($key, $val)
    {
        $this->entity[$key] = $val;
    }

    /**
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($this->entity[$key]);
    }

    /**
     * @access private
     */
    public function offsetUnset($key)
    {
        unset($this->entity[$key]);
    }

    /**
     * @access private
     */
    public function offsetGet($key)
    {
        return isset($this->entity[$key])
            ? $this->entity[$key]
            : null;
    }
}
