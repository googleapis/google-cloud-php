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
 * Defines an interface for Datastore Entities.
 *
 * This interface is fulfilled by {@see Google\Cloud\Datastore\EntityTrait},
 * and it is recommended that classes implementing EntityInterface make use of that
 * trait to ensure proper configuration.
 */
interface EntityInterface
{
    const EXCLUDE_FROM_INDEXES = '___GOOGLECLOUDPHP___EXCLUDEFROMINDEXES___';

    /**
     * Create an instance of the entity class.
     *
     * This factory method allows the implementor to define the means by which
     * the key, entity data and entity options are managed within the entity
     * implementation. This method is called by the Google Cloud PHP client to
     * create entities.
     *
     * @param Key|null $key [optional] The Entity's Key, defining its unique
     *        identifier. **Defaults to** `null`.
     * @param array $entity [optional] The entity body. **Defaults to** `[]`.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $cursor Set only when the entity is obtained by a query
     *           result. If set, the entity cursor can be retrieved from
     *           {@see Google\Cloud\Datastore\EntityInterface::cursor()}.
     *     @type string $baseVersion Set only when the entity is obtained by a
     *           query result. If set, the entity cursor can be retrieved from
     *           {@see Google\Cloud\Datastore\EntityInterface::baseVersion()}.
     *     @type array $excludeFromIndexes A list of entity keys to exclude from
     *           datastore indexes.
     *     @type array $meanings A list of meaning values for entity properties.
     *     @type bool $populatedByService Indicates whether the entity was
     *           created as the result of a service request.
     * }
     */
    public static function build(Key $key = null, array $entity = [], array $options = []);

    /**
     * Defines embedded entity mappings.
     *
     * Embedded entities are converted to instances of
     * {@see Google\Cloud\Datastore\Entity}, or to associative arrays by default.
     * By providing mappings, you can define the types to use in your application.
     *
     * Types must implement {@see Google\Cloud\Datastore\EntityInterface}.
     *
     * @return array An associative array, where the key is the property name,
     *         and the value is the fully-qualified name of a PHP class
     *         implementing {@see Google\Cloud\Datastore\EntityInterface}.
     */
    public static function mappings();

    /**
     * Return all entity data as an array.
     *
     * @return array
     */
    public function get();

    /**
     * Set the entity body.
     *
     * @param array $entity The new entity body.
     * @return void
     */
    public function set(array $entity);

    /**
     * Return the Datastore key, or null if no key is present.
     *
     * @return Key|null
     */
    public function key();

    /**
     * Fetch the cursor
     *
     * This is only set when the entity was obtained from a query result. It
     * can be used to manually paginate results.
     *
     * @return string|null
     */
    public function cursor();

    /**
     * Fetch the baseVersion
     *
     * This is only set when the entity was obtained from a query result. It
     * is used for concurrency control internally.
     *
     * @return string|null
     */
    public function baseVersion();

    /**
     * Indicate whether the entity was created as the result of an API call.
     *
     * @return bool
     */
    public function populatedByService();

    /**
     * A list of entity properties to exclude from datastore indexes.
     *
     * @param array $properties A list of properties to exclude from indexes.
     * @return void
     */
    public function setExcludeFromIndexes(array $properties);

    /**
     * Return a list of properties excluded from datastore indexes.
     *
     * @return array
     */
    public function excludedProperties();

    /**
     * Return a list of meaning values.
     *
     * @return array
     */
    public function meanings();
}
