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
    public static function factory(Key $key = null, array $entity = [], array $options = [])
    {
        return new static($key, $entity, $options);
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
     * @return Key|null
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
        return isset($this->options['cursor'])
            ? $this->options['cursor']
            : null;
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
        return isset($this->options['baseVersion'])
            ? $this->options['baseVersion']
            : null;
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
        return isset($this->options['populatedByService'])
            ? $this->options['populatedByService']
            : false;
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
     * Return a list of properties excluded from datastore indexes.
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
        return isset($this->options['excludeFromIndexes'])
            ? $this->options['excludeFromIndexes']
            : [];
    }

    /**
     * Return a list of meaning values.
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
        return isset($this->options['meanings'])
            ? $this->options['meanings']
            : [];
    }

    /**
     * @access private
     */
    public static function mappings()
    {
        return [];
    }
}
