<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\PubSub;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\PubSub\Connection\ConnectionInterface;

/**
 * Represents a Pub/Sub Schema resource.
 *
 * Schema Support for Cloud Pub/Sub allows you to register schemas in common
 * formats as standalone versioned resources, associates schemas with Pub/Sub
 * topics, validates message structure on-publish, and provides APIs
 * parameterized on your entity types.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $client = new PubSubClient();
 * $schema = $client->schema('my-schema');
 * ```
 */
class Schema
{
    /**
     * @var ConnectionInterface
     * @internal
     */
    private $connection;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Pub/Sub
     *        This object is created by PubSubClient,
     *        and should not be instantiated outside of this client.
     * @param string $name The schema name.
     * @param array $info [optional] Schema data.
     */
    public function __construct(
        ConnectionInterface $connection,
        $name,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->name = $name;
        $this->info = $info;
    }

    /**
     * Get the schema resource name.
     *
     * Example:
     * ```
     * $name = $schema->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Delete the schema.
     *
     * Example:
     * ```
     * $schema->delete();
     * ```
     *
     * @param array $options [optional] Configuration options
     * @return void
     */
    public function delete(array $options = [])
    {
        return $this->connection->deleteSchema([
            'name' => $this->name
        ] + $options);
    }

    /**
     * Get schema information.
     *
     * Since this method will throw an exception if the schema is not found, you
     * may find that {@see Schema::exists()} is a better fit
     * for a true/false check.
     *
     * This method will use the previously cached result, if available. To force
     * a refresh from the API, use {@see Schema::reload()}.
     *
     * Example:
     * ```
     * $info = $schema->info();
     * echo $info['name']; // projects/my-awesome-project/schemas/my-schema
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $view The set of Schema fields to return in the
     *           response. If not set, returns Schemas with `name` and `type`,
     *           but not `definition`. Set to `FULL` to retrieve all fields. For
     *           allowed values, use constants defined on
     *           {@see \Google\Cloud\PubSub\V1\SchemaView}. **Note**: for this
     *           method, `$options.view` defaults to `FULL`.
     * }
     * @return array
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Get schema information from the API.
     *
     * Since this method will throw an exception if the schema is not found, you
     * may find that {@see Schema::exists()} is a better fit
     * for a true/false check.
     *
     * This method will retrieve a new result from the API. To use a previously
     * cached result, if one exists, use {@see Schema::info()}.
     *
     * Example:
     * ```
     * $info = $schema->reload();
     * echo $info['name']; // projects/my-awesome-project/schemas/my-schema
     * ```
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $view The set of Schema fields to return in the
     *           response. If not set, returns Schemas with `name` and `type`,
     *           but not `definition`. Set to `FULL` to retrieve all fields. For
     *           allowed values, use constants defined on
     *           {@see \Google\Cloud\PubSub\V1\SchemaView}. **Note**: for this
     *           method, `$options.view` defaults to `FULL`.
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        $options += [
            'view' => 'FULL',
        ];

        return $this->info = $this->connection->getSchema([
            'name' => $this->name,
        ] + $options);
    }

    /**
     * Check if a schema exists.
     *
     * Example:
     * ```
     * if ($schema->exists()) {
     *     echo 'Schema exists';
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * Get list  schema revisions.
     *
     * Example:
     * ```
     * $revisions = $schema->listRevisions();
     * foreach ($revisions['schemas'] as $revision) {
     *     echo $revisions['definition'];
     * }
     * ```
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/listRevisions List revisions
     * @param array $options [optional] Configuration Options
     * @return array
     */
    public function listRevisions(array $options = [])
    {
        return $this->connection->listRevisions([
                'name' => $this->name,
            ] + $options);
    }

    /**
     * Commit schema revision.
     *
     * Example:
     * ```
     * $definition = file_get_contents('my-schema.txt');
     * $revision = $schema->commit($definition, 'AVRO);
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/commit Commit Schema revision.
     * ```
     *
     * @param string $definition The definition of the schema. This should
     *     contain a string representing the full definition of the schema that
     *     is a valid schema definition of the type specified in `type`. See
     *     [Schema](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas#Schema)
     *     for details.
     * @param string $type The schema type. Allowed values are `AVRO` and `PROTOCOL_BUFFER`.
     * @param array $options [optional] Configuration options
     * @return array revision created
     */
    public function commit($definition, $type, array $options = [])
    {
        return $this->connection->commitSchema([
                'schema' => [
                    'definition' => $definition,
                    'type' => $type,
                ],
                'name' => $this->name
            ] + $options);
    }

    /**
     * Commit schema revision.
     *
     * Example:
     * ```
     * $definition = file_get_contents('my-schema.txt');
     * $revision = $schema->commit($definition, 'AVRO);
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/deleteRevision Delete revision.
     * ```
     *
     * @param string $revisionId The revisionId
     * @return array deleted revision
     */
    public function deleteRevision($revisionId)
    {
        return $this->connection->deleteRevision([
            'name' => $this->name .'@' . $revisionId
        ]);
    }
}
