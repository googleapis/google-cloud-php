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

use Google\ApiCore\Veneer\Exception\NotFoundException;
use Google\ApiCore\Veneer\RequestHandler;
use Google\Cloud\PubSub\V1\SchemaServiceClient;
use Google\Cloud\PubSub\V1\SchemaView;

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
     * The request handler that is responsible for sending a req and
     * serializing responses into relevant classes.
     */
    private $requestHandler;

    /**
     * The GAPIC class to call under the hood.
     */
    private $gapic;

    /**
     * @var Google\ApiCore\Serializer The serializer to be used for PubSub
     */
    private $serializer;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * @param string $name The schema name.
     * @param array $info [optional] Schema data.
     */
    public function __construct(
        $name,
        array $info = [],
        $clientConfig = []
    ) {
        $this->gapic = new SchemaServiceClient($clientConfig);
        $this->serializer = new PubSubSerializer();
        $this->requestHandler = new RequestHandler(
            $this->serializer,
            ['libVersion' => PubSubClient::VERSION]
        );

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
        return $this->requestHandler->sendReq(
            $this->gapic,
            'deleteSchema',
            [$this->name],
            $options
        );
    }

    /**
     * Get schema information.
     *
     * Since this method will throw an exception if the schema is not found, you
     * may find that {@see Google\Cloud\PubSub\Schema::exists()} is a better fit
     * for a true/false check.
     *
     * This method will use the previously cached result, if available. To force
     * a refresh from the API, use {@see Google\Cloud\PubSub\Schema::reload()}.
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
     * may find that {@see Google\Cloud\PubSub\Schema::exists()} is a better fit
     * for a true/false check.
     *
     * This method will retrieve a new result from the API. To use a previously
     * cached result, if one exists, use {@see Google\Cloud\PubSub\Schema::info()}.
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

        if (is_string($options['view'])) {
            $options['view'] = SchemaView::value($options['view']);
        }

        return $this->requestHandler->sendReq(
            $this->gapic,
            'getSchema',
            [$this->name],
            $options
        );
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
}
