<?php
/**
 * Copyright 2018 Google Inc.
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

/**
 * A trait to provide Datastore Entity functionality to classes.
 *
 * This class fulfills the {@see Google\Cloud\Datastore\EntityInterface} requirements.
 */
trait EntityTrait
{
    use EntityOptionsTrait;

    /**
     * @var Key|null
     */
    private $key;

    /**
     * @var array
     */
    private $entity;

    /**
     * @param Key|null $key [optional] The Entity's Key, defining its unique
     *        identifier. **Defaults to** `null`.
     * @param array $entity [optional] The entity body. **Defaults to** `[]`.
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
     */
    public function __construct(Key $key = null, array $entity = [], array $options = [])
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
     * A factory method, used by the Datastore client to create entities.
     *
     * @param Key|null $key [optional] The Entity's Key, defining its unique
     *        identifier. **Defaults to** `null`.
     * @param array $entity [optional] The entity body. **Defaults to** `[]`.
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
    public static function build(Key $key = null, array $entity = [], array $options = [])
    {
        return new static($key, $entity, $options);
    }

    /**
     * Get the entity data.
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
     * Get a single property from the entity data.
     *
     * If the property does not exist, this method will return `null`.
     *
     * Example:
     * ```
     * $value = $entity->getProperty('firstName');
     * ```
     *
     * @param string $property The name of an entity property to return.
     * @return mixed|null
     */
    public function getProperty($property)
    {
        return isset($this->entity[$property])
            ? $this->entity[$property]
            : null;
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
     * Set the value of a single entity property.
     *
     * If the property already exists, the value will be overwritten. If it does
     * not exist, it will be added.
     *
     * Example:
     * ```
     * $entity->setProperty('firstName', 'Bob');
     * ```
     *
     * @param string $property The property name.
     * @param mixed $value The property value.
     * @return void
     */
    public function setProperty($property, $value)
    {
        $this->entity[$property] = $value;
    }

    /**
     * Get the Entity Key
     *
     * Example:
     * ```
     * $key = $entity->key();
     * ```
     *
     * @return Key|null
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @access private
     */
    public static function mappings()
    {
        return [];
    }
}
