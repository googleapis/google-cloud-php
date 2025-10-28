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
 * | {@see \Google\Cloud\Datastore\Key}          | `keyValue`                           |
 * | {@see \Google\Cloud\Datastore\GeoPoint}     | `geoPointValue`                      |
 * | {@see \Google\Cloud\Datastore\Entity}       | `entityValue`                        |
 * | {@see \Google\Cloud\Datastore\Blob}         | `blobValue`                          |
 * | {@see \Google\Cloud\Core\Int64}             | `integerValue`                       |
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
 * $firstName = $entity['firstName']; // 'Bob'
 * $entity['location'] = 'Detroit, MI';
 * ```
 *
 * ```
 * // Custom entity types can be created by implementing the datastore entity interface.
 * // You can also define mappings to correctly fetch embedded entities.
 * use Google\Cloud\Datastore\EntityTrait;
 * use Google\Cloud\Datastore\EntityInterface;
 *
 * class Business implements EntityInterface
 * {
 *     use EntityTrait;
 *
 *     public static function mappings(): array
 *     {
 *         return [
 *             'parent' => Business::class
 *         ];
 *     }
 * }
 *
 * $alphabet = new Business;
 * $alphabet->set([
 *     'companyName' => 'Alphabet'
 * ]);
 *
 * $key = $datastore->key('Business', 'Google');
 * $google = $datastore->entity($key, [
 *     'companyName' => 'Google',
 *     'parent' => $alphabet
 * ], [
 *     'className' => Business::class
 * ]);
 *
 * $datastore->insert($google);
 *
 * $google = $datastore->lookup($key, ['className' => Business::class]);
 * echo get_class($google); // `Business`
 * echo get_class($google->get()['parent']); // `Business`
 * ```
 *
 * @see https://cloud.google.com/datastore/docs/reference/rest/v1/Entity Entity API documentation
 */
class Entity implements ArrayAccess, EntityInterface
{
    use EntityTrait;

    /**
     * @param string $key The value name.
     * @param mixed $val The value.
     * @return void
     * @access private
     */
    public function offsetSet($key, $val): void
    {
        $this->entity[$key] = $val;
    }

    /**
     * @param string $key the value to check.
     * @return bool
     * @access private
     */
    public function offsetExists($key): bool
    {
        return isset($this->entity[$key]);
    }

    /**
     * @param string $key the value to remove.
     * @return void
     * @access private
     */
    public function offsetUnset($key): void
    {
        unset($this->entity[$key]);
    }

    /**
     * @param string $key the value to retrieve.
     * @return mixed
     * @access private
     */
    public function offsetGet($key): mixed
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
    public function __get(string $property)
    {
        return $this->offsetGet($property);
    }

    /**
     * @param string $property
     * @param mixed $value
     * @return void
     * @access private
     */
    public function __set(string $property, $value): void
    {
        $this->offsetSet($property, $value);
    }

    /**
     * @param string $property
     * @return void
     * @access private
     */
    public function __unset(string $property): void
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
    public function __isset(string $property): bool
    {
        return $this->offsetExists($property) && $this->offsetGet($property) !== null;
    }
}
