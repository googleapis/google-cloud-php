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

use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance\State;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamInstance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

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

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

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
     * @var Iam|null
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
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string|string[] $fieldMask One or a list of `Instance` fields that should be returned.
     *           Eligible values are: `name`, `displayName`, `endpointUris`, `labels`, `config`, `nodeCount`, `state`.
     *           If absent, all fields are returned.
     *           Note: This parameter will only apply when service call is required (`info` values are not present).
     * }
     *
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
            if ($this->info) {
                $this->connection->getInstance([
                    'name' => $this->name,
                    'projectName' => InstanceAdminClient::projectName(
                        $this->projectId
                    ),
                    'fieldMask' => ['name'],
                ] + $options);
            } else {
                $this->reload($options);
            }
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
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string|string[] $fieldMask One or a list of `Instance` fields that should be returned.
     *           Eligible values are: `name`, `displayName`, `endpointUris`, `labels`, `config`, `nodeCount`, `state`.
     *           If absent, all fields are returned.
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getInstance($options + [
            'name' => $this->name,
            'projectName' => InstanceAdminClient::projectName($this->projectId),
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
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type int $nodeCount **Defaults to** `1`.
     *     @type int $processingUnits An alternative measurement to `nodeCount` that allows smaller increments.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return LongRunningOperation<Instance>
     * @throws \InvalidArgumentException
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $config, array $options = [])
    {
        $instanceId = InstanceAdminClient::parseName($this->name)['instance'];
        $options += [
            'displayName' => $instanceId,
            'labels' => [],
        ];

        if (isset($options['nodeCount']) && isset($options['processingUnits'])) {
            throw new \InvalidArgumentException("Must only set either `nodeCount` or `processingUnits`");
        }
        if (empty($options['nodeCount']) && empty($options['processingUnits'])) {
            $options['nodeCount'] = self::DEFAULT_NODE_COUNT;
        }

        // This must always be set to CREATING, so overwrite anything else.
        $options['state'] = State::CREATING;

        $operation = $this->connection->createInstance([
            'instanceId' => $instanceId,
            'name' => $this->name,
            'projectName' => InstanceAdminClient::projectName($this->projectId),
            'config' => $config->name()
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Return the instance state.
     *
     * When instances are created or updated, they may take some time before
     * they are ready for use. This method allows for checking whether an
     * instance is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see Google\Cloud\Spanner\Instance::reload()}
     * to refresh the cached value
     *
     * Example:
     * ```
     * if ($instance->state() === Instance::STATE_READY) {
     *     echo 'Instance is ready!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return int|null
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
     *     @type int $processingUnits An alternative measurement to `nodeCount` that allows smaller increments.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://goo.gl/xmQnxf).
     * }
     * @return LongRunningOperation
     * @throws \InvalidArgumentException
     */
    public function update(array $options = [])
    {
        if (isset($options['nodeCount']) && isset($options['processingUnits'])) {
            throw new \InvalidArgumentException("Must only set either `nodeCount` or `processingUnits`");
        }

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
        $this->connection->deleteInstance($options + [
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
     * Create a database from a backup.
     *
     * Example:
     * ```
     * $operation = $instance->createDatabaseFromBackup('my-new-database', $backup);
     * ```
     *
     * @param string $name The database name.
     * @param Backup|string $backup The backup to restore, given
     *        as a Backup instance or a string of the form
     *        `projects/<project>/instances/<instance>/backups/<backup>`.
     * @param array $options [optional] Configuration options.
     *
     * @return LongRunningOperation<Database>
     */

    public function createDatabaseFromBackup($name, $backup, array $options = [])
    {
        $backup = $backup instanceof Backup
            ? $backup->name()
            : $backup;

        $operation = $this->connection->restoreDatabase([
            'instance' => $this->name(),
            'databaseId' => $this->databaseIdOnly($name),
            'backup' => $backup,
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
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
            $this->returnInt64AsObject,
            isset($options['database']) ? $options['database'] : []
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
                    return $this->database($database['name'], ['database' => $database]);
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
     * Lazily instantiate a backup object
     *
     * Example:
     * ```
     * $backup = $instance->backup('my-backup');
     * ```
     *
     * @param string $name The backup name.
     *
     * @return Backup
     */
    public function backup($name, array $backup = [])
    {
        return new Backup(
            $this->connection,
            $this,
            $this->lroConnection,
            $this->lroCallables,
            $this->projectId,
            $name,
            $backup
        );
    }

    /**
     * List completed and pending backups in an instance.
     *
     * Example:
     * ```
     * $backups = $instance->backups();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.database.v1#listbackupsrequest ListBackupsRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $filter The standard list filter.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<Backup>
     */
    public function backups(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $backup) {
                    return $this->backup(
                        $backup['name'],
                        $backup
                    );
                },
                [$this->connection, 'listBackups'],
                $options + ['instance' => $this->name],
                [
                    'itemsKey' => 'backups',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lists backup operations for the instance.
     *
     * Example:
     * ```
     * $backupOperations = $instance->backupOperations();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<LongRunningOperation>
     */
    public function backupOperations(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $operation) {
                    return $this->resumeOperation($operation['name'], $operation);
                },
                [$this->connection, 'listBackupOperations'],
                $options + ['instance' => $this->name],
                [
                    'itemsKey' => 'operations',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lists database operations for the instance.
     *
     * Example:
     * ```
     * $databaseOperations = $instance->databaseOperations();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<LongRunningOperation>
     */
    public function databaseOperations(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $operation) {
                    return $this->resumeOperation($operation['name'], $operation);
                },
                [$this->connection, 'listDatabaseOperations'],
                $options + ['instance' => $this->name],
                [
                    'itemsKey' => 'operations',
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
            return InstanceAdminClient::instanceName(
                $project,
                $name
            );
        // } catch (ValidationException $e) {
        //     return $name;
        // }
    }

    /**
     * Extracts a database id from fully qualified name.
     *
     * @param string $name The database name or id.
     * @return string
     */
    private function databaseIdOnly($name)
    {
        try {
            return DatabaseAdminClient::parseName($name)['database'];
        } catch (ValidationException $e) {
            return $name;
        }
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
