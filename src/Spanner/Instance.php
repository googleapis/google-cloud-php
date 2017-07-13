<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamInstance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\GAX\ValidationException;
use Google\Spanner\Admin\Instance\V1\Instance_State;

/**
 * Represents a Cloud Spanner instance
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $instance = $spanner->instance('my-instance');
 * ```
 *
 * @method resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $instance->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 * @method longRunningOperations() {
 *     List long running operations.
 *
 *     Example:
 *     ```
 *     $operations = $instance->longRunningOperations();
 *     ```
 *
 *     @param array $options [optional] {
 *         Configuration Options.
 *
 *         @type string $name The name of the operation collection.
 *         @type string $filter The standard list filter.
 *         @type int $pageSize Maximum number of results to return per
 *               request.
 *         @type int $resultLimit Limit the number of results returned in total.
 *               **Defaults to** `0` (return all results).
 *         @type string $pageToken A previously-returned page token used to
 *               resume the loading of results from a specific point.
 *     }
 *     @return ItemIterator<InstanceConfiguration>
 * }
 */
class Instance
{
    use ArrayTrait;
    use LROTrait;

    const STATE_READY = Instance_State::READY;
    const STATE_CREATING = Instance_State::CREATING;

    const DEFAULT_NODE_COUNT = 1;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @var array
     */
    private $info;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * Create an object representing a Cloud Spanner instance.
     *
     * @param ConnectionInterface $connection The connection to the
     *        Cloud Spanner Admin API.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param array $lroCallables
     * @param string $projectId The project ID.
     * @param string $name The instance name or ID.
     * @param bool $returnInt64AsObject [optional] If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Core\Int64} object for 32 bit platform
     *        compatibility. **Defaults to** false.
     * @param array $info [optional] A representation of the instance object.
     */
    public function __construct(
        ConnectionInterface $connection,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $name,
        $returnInt64AsObject = false,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedInstanceName($name, $projectId);
        $this->returnInt64AsObject = $returnInt64AsObject;
        $this->info = $info;

        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
    }

    /**
     * Return the instance name.
     *
     * Example:
     * ```
     * $name = $instance->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the service representation of the instance.
     *
     * This method may require a service call.
     *
     * Example:
     * ```
     * $info = $instance->info();
     * echo $info['nodeCount'];
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Check if the instance exists.
     *
     * This method requires a service call.
     *
     * Example:
     * ```
     * if ($instance->exists()) {
     *    echo 'Instance exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options = []);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Fetch a fresh representation of the instance from the service.
     *
     * Example:
     * ```
     * $info = $instance->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.instance.v1#google.spanner.admin.instance.v1.GetInstanceRequest GetInstanceRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getInstance($options + [
            'name' => $this->name,
            'projectId' => $this->projectId
        ]);

        return $this->info;
    }

    /**
     * Create a new instance.
     *
     * Example:
     * ```
     * $operation = $instance->create($configuration);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#createinstancerequest CreateInstanceRequest
     *
     * @param InstanceConfiguration $config The configuration to use
     * @param string $name The instance name
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type int $nodeCount **Defaults to** `1`.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return LongRunningOperation<Instance>
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $config, array $options = [])
    {
        $instanceId = InstanceAdminClient::parseInstanceFromInstanceName($this->name);
        $options += [
            'displayName' => $instanceId,
            'nodeCount' => self::DEFAULT_NODE_COUNT,
            'labels' => [],
        ];

        // This must always be set to CREATING, so overwrite anything else.
        $options['state'] = Instance_State::CREATING;

        $operation = $this->connection->createInstance([
            'instanceId' => $instanceId,
            'name' => $this->name,
            'projectId' => InstanceAdminClient::formatProjectName($this->projectId),
            'config' => $config->name()
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Return the instance state.
     *
     * When instances are created or updated, they may take some time before
     * they are ready for use. This method allows for checking whether an
     * instance is ready.
     *
     * Example:
     * ```
     * if ($instance->state() === Instance::STATE_READY) {
     *     echo 'Instance is ready!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return string|null
     */
    public function state(array $options = [])
    {
        $info = $this->info($options);

        return (isset($info['state']))
            ? $info['state']
            : null;
    }

    /**
     * Update the instance
     *
     * Example:
     * ```
     * $instance->update([
     *     'displayName' => 'My Instance',
     *     'nodeCount' => 4
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.instance.v1#updateinstancerequest UpdateInstanceRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName The descriptive name for this instance as
     *           it appears in UIs. **Defaults to** the value of $name.
     *     @type int $nodeCount The number of nodes allocated to this instance.
     *           **Defaults to** `1`.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://goo.gl/xmQnxf).
     * }
     * @return LongRunningOperation<void>
     * @throws \InvalidArgumentException
     */
    public function update(array $options = [])
    {
        $operation = $this->connection->updateInstance([
            'name' => $this->name,
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Delete the instance, any databases in the instance, and all data.
     *
     * Example:
     * ```
     * $instance->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.instance.v1#deleteinstancerequest DeleteInstanceRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = [])
    {
        return $this->connection->deleteInstance($options + [
            'name' => $this->name
        ]);
    }

    /**
     * Create a Database
     *
     * Example:
     * ```
     * $operation = $instance->createDatabase('my-database');
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#createdatabaserequest CreateDatabaseRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $name The database name.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type array $statements Additional DDL statements.
     *     @type SessionPoolInterface $sessionPool A pool used to manage
     *           sessions.
     * }
     * @return LongRunningOperation<Database>
     */
    public function createDatabase($name, array $options = [])
    {
        $instantiation = $this->pluckArray(['sessionPool'], $options);

        $database = $this->database($name, $instantiation);
        return $database->create($options);
    }

    /**
     * Lazily instantiate a database object
     *
     * Example:
     * ```
     * $database = $instance->database('my-database');
     * ```
     *
     * @param string $name The database name
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type SessionPoolInterface $sessionPool A pool used to manage
     *           sessions.
     * }
     * @return Database
     */
    public function database($name, array $options = [])
    {
        return new Database(
            $this->connection,
            $this,
            $this->lroConnection,
            $this->lroCallables,
            $this->projectId,
            $name,
            isset($options['sessionPool']) ? $options['sessionPool'] : null,
            $this->returnInt64AsObject
        );
    }

    /**
     * List databases in an instance
     *
     * Example:
     * ```
     * $databases = $instance->databases();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.database.v1#listdatabasesrequest ListDatabasesRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Database>
     */
    public function databases(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $database) {
                    return $this->database($database['name']);
                },
                [$this->connection, 'listDatabases'],
                $options + ['instance' => $this->name],
                [
                    'itemsKey' => 'databases',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Manage the instance IAM policy
     *
     * Example:
     * ```
     * $iam = $instance->iam();
     * ```
     *
     * @return Iam
     */
    public function iam()
    {
        if (!$this->iam) {
            $this->iam = new Iam(
                new IamInstance($this->connection),
                $this->name
            );
        }

        return $this->iam;
    }

    /**
     * Convert the simple instance name to a fully qualified name.
     *
     * @param string $name The instance name.
     * @param string $project The project ID.
     * @return string
     */
    private function fullyQualifiedInstanceName($name, $project)
    {
        // try {
            return InstanceAdminClient::formatInstanceName(
                $project,
                $name
            );
        // } catch (ValidationException $e) {
        //     return $name;
        // }
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info
        ];
    }
}
