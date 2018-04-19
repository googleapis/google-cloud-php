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
 * Methods for handling Datastore Entity options boilerplate.
 *
 * This trait partially implements {@see Google\Cloud\Datastore\EntityInterface}
 * and is useful when your application requires custom entities with non-standard
 * objects.
 */
trait EntityOptionsTrait
{
    /**
     * @var array
     */
    private $options;

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
}
