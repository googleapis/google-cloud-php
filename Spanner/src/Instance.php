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

use Closure;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningClientConnection;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance as InstanceProto;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance\State;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceRequest;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\TransactionOptions\IsolationLevel;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\Operation as OperationProto;
use InvalidArgumentException;

/**
 * Represents a Cloud Spanner instance
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => $projectId]);
 *
 * $instance = $spanner->instance('my-instance');
 * ```
 */
class Instance
{
    use ApiHelperTrait;
    use RequestTrait;

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

    const DEFAULT_NODE_COUNT = 1;

    private IamManager|null $iam = null;
    private array $directedReadOptions;
    private array $defaultQueryOptions;
    private bool $routeToLeader;
    private string $projectName;
    private bool $returnInt64AsObject;
    private array $info;
    private int $isolationLevel;

    /**
     * Create an object representing a Cloud Spanner instance.
     *
     * @internal Instance is constructed by the {@see SpannerClient} class.
     *
     * @param GapicSpannerClient $spannerClient The spanner client.
     * @param InstanceAdminClient $instanceAdminClient The instance admin client.
     * @param DatabaseAdminClient $databaseAdminClient The database admin client.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The project ID.
     * @param string $name The instance name or ID.
     * @param array $options {
     *     Instance options
     *
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     *     @type int $isolationLevel The level of Isolation for the transactions executed by this Client's instance.
     *           **Defaults to** IsolationLevel::ISOLATION_LEVEL_UNSPECIFIED
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *           **Defaults to** `true` (enabled).
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit platform
     *           compatibility. **Defaults to** false.
     *     @type array $instance An array representation of the instance object.
     * }
     */
    public function __construct(
        private GapicSpannerClient $spannerClient,
        private InstanceAdminClient $instanceAdminClient,
        private DatabaseAdminClient $databaseAdminClient,
        private Serializer $serializer,
        private string $projectId,
        private string $name,
        array $options = [],
    ) {
        $this->name = $this->fullyQualifiedInstanceName($name, $projectId);
        $this->directedReadOptions = $options['directedReadOptions'] ?? [];
        $this->isolationLevel = $options['isolationLevel'] ?? IsolationLevel::ISOLATION_LEVEL_UNSPECIFIED;
        $this->routeToLeader = $options['routeToLeader'] ?? true;
        $this->defaultQueryOptions = $options['defaultQueryOptions'] ?? [];
        $this->returnInt64AsObject = $options['returnInt64AsObject'] ?? false;
        $this->info = $options['instance'] ?? [];
        $this->projectName = InstanceAdminClient::projectName($projectId);
        $this->optionsValidator = new OptionsValidator($serializer);
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
    public function name(): string
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
    public function info(array $options = []): array
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
    public function exists(array $options = []): bool
    {
        try {
            if ($this->info) {
                $options += [
                    'name' => $this->name,
                    'fieldMask' => ['paths' => ['name']],
                ];

                /**
                 * @var GetInstanceRequest $getInstanceRequest
                 * @var array $callOptions
                 */
                [$getInstanceRequest, $callOptions] = $this->validateOptions(
                    $options,
                    new GetInstanceRequest(),
                    CallOptions::class
                );

                $this->instanceAdminClient->getInstance($getInstanceRequest, $callOptions + [
                    'resource-prefix' => $this->projectName
                ]);
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
    public function reload(array $options = []): array
    {
        $options['name'] ??= $this->name;
        /**
         * @var GetInstanceRequest $request
         * @var array $callOptions
         */
        [$request, $callOptions] = $this->validateOptions(
            $options,
            new GetInstanceRequest(),
            CallOptions::class
        );

        $response = $this->instanceAdminClient->getInstance($request, $callOptions + [
            'resource-prefix' => $this->projectName
        ]);
        return $this->info = $this->handleResponse($response);
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
     * @return LongRunningOperation
     * @throws InvalidArgumentException
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $config, array $options = []): LongRunningOperation
    {
        /**
         * @var InstanceProto $instance
         * @var array $callOptions
         */
        [$instance, $callOptions] = $this->validateOptions(
            $options,
            new InstanceProto(),
            CallOptions::class
        );

        $instanceId = InstanceAdminClient::parseName($this->name)['instance'];
        if ($instance->getNodeCount() !== 0 && $instance->getProcessingUnits() !== 0) {
            throw new InvalidArgumentException('Must only set either `nodeCount` or `processingUnits`');
        }
        if ($instance->getNodeCount() === 0 && $instance->getProcessingUnits() === 0) {
            $instance->setNodeCount(self::DEFAULT_NODE_COUNT);
        }

        $instance->setName($this->name);
        $instance->setConfig($config->name());
        if (!$instance->getDisplayName()) {
            $instance->setDisplayName($instanceId);
        }

        $request = new CreateInstanceRequest([
            'parent' => InstanceAdminClient::projectName($this->projectId),
            'instance_id' => $instanceId,
            'instance' => $instance
        ]);

        $operation = $this->instanceAdminClient->createInstance($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);
        return $this->operationFromOperationResponse($operation);
    }

    /**
     * Return the instance state.
     *
     * When instances are created or updated, they may take some time before
     * they are ready for use. This method allows for checking whether an
     * instance is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see \Google\Cloud\Spanner\Instance::reload()}
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
     * @return int
     */
    public function state(array $options = []): int
    {
        $info = $this->info($options);

        return $info['state'] ?? State::STATE_UNSPECIFIED;
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
     * @throws InvalidArgumentException
     */
    public function update(array $options = []): LongRunningOperation
    {
        if (isset($options['nodeCount']) && isset($options['processingUnits'])) {
            throw new InvalidArgumentException('Must only set either `nodeCount` or `processingUnits`');
        }

        /**
         * @var UpdateInstanceRequest $request
         * @var array $callOptions
         */
        [$request, $callOptions] = $this->validateOptions(
            [
                'instance' => $options + ['name' => $this->name],
                'fieldMask' => $this->fieldMask($options)
            ],
            new UpdateInstanceRequest(),
            CallOptions::class
        );

        $operation = $this->instanceAdminClient->updateInstance($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);
        return $this->operationFromOperationResponse($operation);
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
    public function delete(array $options = []): void
    {
        /**
         * @var DeleteInstanceRequest $deleteInstancesRequest
         * @var array $callOptions
         */
        [$deleteInstancesRequest, $callOptions] = $this->validateOptions(
            $options,
            new DeleteInstanceRequest(),
            CallOptions::class
        );
        $deleteInstancesRequest->setName($this->name);

        $this->instanceAdminClient->deleteInstance($deleteInstancesRequest, $callOptions + [
            'resource-prefix' => $this->name
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
     *     @type \Google\Protobuf\FileDescriptorSet|string $protoDescriptors The file
     *         descriptor set object to be used in the update, or alternatively, an absolute
     *         path to the generated file descriptor set. The descriptor set is only used
     *         during DDL statements, such as `CREATE PROTO BUNDLE`.
     *     @type SessionPoolInterface $sessionPool A pool used to manage
     *           sessions.
     * }
     * @return LongRunningOperation
     */
    public function createDatabase($name, array $options = []): LongRunningOperation
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
     * @return LongRunningOperation
     */
    public function createDatabaseFromBackup(
        string $name,
        Backup|string $backup,
        array $options = []
    ): LongRunningOperation {
        return $this->database($name)->createDatabaseFromBackup($name, $backup, $options);
    }

    /**
     * Lazily instantiate a database object
     *
     * Example:
     * ```
     * $database = $instance->database('my-database');
     * ```
     *
     * Database role configured on the database object
     * will be applied to the session created by this object.
     * ```
     * $database = $instance->database('my-database', ['databaseRole' => 'Reader']);
     * ```
     *
     * @param string $name The database name
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *         **Defaults to** `true` (enabled).
     *     @type array $defaultQueryOptions
     *     @type SessionPoolInterface $sessionPool The session pool
     *         implementation.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will
     *         be returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *         platform compatibility. **Defaults to** false.
     *     @type string $databaseRole The user created database role which
     *         creates the session.
     *     @type array $database The database info.
     *     @type int $isolationLevel The IsolationLevel set for the transaction.
     *           Check {@see IsolationLevel} for more details.
     * }
     * @return Database
     */
    public function database(string $name, array $options = []): Database
    {
        [$options] = $this->validateOptions($options, [
            'routeToLeader',
            'defaultQueryOptions',
            'returnint64AsObject',
            'databaseRole',
            'database',
            'sessionPool',
            'lock',
            'isolationLevel',
        ]);

        try {
            $instance = DatabaseAdminClient::parseName($this->name())['instance'];
            $databaseName = GapicSpannerClient::databaseName(
                $this->projectId,
                $instance,
                $name
            );
        } catch (ValidationException $e) {
            $databaseName = $name;
        }

        return new Database(
            $this->spannerClient,
            $this->databaseAdminClient,
            $this->serializer,
            $this,
            $this->projectId,
            $name,
            $options + [
                'routeToLeader' => $this->routeToLeader,
                'defaultQueryOptions' => $this->defaultQueryOptions,
                'returnInt64AsObject' => $this->returnInt64AsObject,
                'isolationLevel' => $this->isolationLevel,
            ]
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
    public function databases(array $options = []): ItemIterator
    {
        /**
         * @var ListDatabasesRequest $listDatabasesRequest
         * @var array $callOptions
         */
        [$listDatabasesRequest, $callOptions] = $this->validateOptions(
            $options,
            new ListDatabasesRequest(),
            CallOptions::class
        );
        $listDatabasesRequest->setParent($this->name);

        return $this->buildListItemsIterator(
            [$this->databaseAdminClient, 'listDatabases'],
            $listDatabasesRequest,
            $callOptions + ['resource-prefix' => $this->name],
            function (array $database) {
                return $this->database($database['name'], ['database' => $database]);
            },
            'databases',
            $this->pluck('resultLimit', $options, false)
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
    public function backup(string $name, array $backup = []): Backup
    {
        return new Backup(
            $this->databaseAdminClient,
            $this->serializer,
            $this,
            $this->projectId,
            $name,
            ['backup' => $backup]
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
    public function backups(array $options = []): ItemIterator
    {
        /**
         * @var ListBackupsRequest $listBackupsRequest
         * @var array $callOptions
         */
        [$listBackupsRequest, $callOptions] = $this->validateOptions(
            $options,
            new ListBackupsRequest(),
            CallOptions::class
        );
        $listBackupsRequest->setParent($this->name);

        return $this->buildListItemsIterator(
            [$this->databaseAdminClient, 'listBackups'],
            $listBackupsRequest,
            $callOptions + ['resource-prefix' => $this->name],
            function (array $backup) {
                return $this->backup($backup['name'], $backup);
            },
            'backups',
            $this->pluck('resultLimit', $options, false)
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
    public function backupOperations(array $options = []): ItemIterator
    {
        /**
         * @var ListBackupOperationsRequest $listBackupOperations
         * @var array $callOptions
         */
        [$listBackupOperations, $callOptions] = $this->validateOptions(
            $options,
            new ListBackupOperationsRequest(),
            CallOptions::class
        );
        $listBackupOperations->setParent($this->name);

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient, 'listBackupOperations'],
            $listBackupOperations,
            $callOptions +  ['resource-prefix' => $this->name],
            $this->getResultMapper()
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
    public function databaseOperations(array $options = []): ItemIterator
    {
        /**
         * @var ListDatabaseOperationsRequest $listDatabaseOperations
         * @var array $callOptions
         */
        [$listDatabaseOperations, $callOptions] = $this->validateOptions(
            $options,
            new ListDatabaseOperationsRequest(),
            CallOptions::class
        );
        $listDatabaseOperations->setParent($this->name);

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient, 'listDatabaseOperations'],
            $listDatabaseOperations,
            $callOptions + ['resource-prefix' => $this->name],
            $this->getResultMapper()
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
     * @return IamManager
     */
    public function iam(): IamManager
    {
        if (!$this->iam) {
            $this->iam = new IamManager(
                new RequestHandler($this->serializer, [$this->instanceAdminClient]),
                $this->serializer,
                InstanceAdminClient::class,
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
    private function fullyQualifiedInstanceName(string $name, string $project): string
    {
        return InstanceAdminClient::instanceName(
            $project,
            $name
        );
    }

    /**
     * Return the directed read options.
     *
     * Example:
     * ```
     * $name = $instance->directedReadOptions();
     * ```
     *
     * @return array
     */
    public function directedReadOptions(): array
    {
        return $this->directedReadOptions;
    }

    /**
     * Resume a Long Running Operation
     *
     * Example:
     * ```
     * $operation = $instance->resumeOperation($operationName);
     * ```
     *
     * @param string $operationName The Long Running Operation name.
     * @return LongRunningOperation
     */
    public function resumeOperation(string $operationName, array $options = []): LongRunningOperation
    {
        return new LongRunningOperation(
            new LongRunningClientConnection($this->instanceAdminClient, $this->serializer),
            $operationName,
            [
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceMetadata',
                    'callable' => $this->instanceResultFunction()
                ],
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceMetadata',
                    'callable' => $this->instanceResultFunction()
                ]
            ],
            $options
        );
    }

    /**
     * List long running operations.
     *
     * Example:
     * ```
     * $operations = $instance->longRunningOperations();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $name The name of the operation collection.
     *     @type string $filter The standard list filter.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<LongRunningOperation>
     */
    public function longRunningOperations(array $options = []): ItemIterator
    {
        /**
         * @var ListOperationsRequest $listOperationsRequest
         * @var array $callOptions
         */
        [$listOperationsRequest, $callOptions] = $this->validateOptions(
            $options,
            new ListOperationsRequest(),
            CallOptions::class
        );
        $listOperationsRequest->setName($this->name . '/operations');

        return $this->buildLongRunningIterator(
            [$this->instanceAdminClient->getOperationsClient(), 'listOperations'],
            $listOperationsRequest,
            $callOptions,
            $this->getResultMapper(),
        );
    }

    private function instanceResultFunction(): Closure
    {
        return function (array $result) {
            $name = InstanceAdminClient::parseName($result['name']);
            return new self(
                $this->spannerClient,
                $this->instanceAdminClient,
                $this->databaseAdminClient,
                $this->serializer,
                $this->projectId,
                $name['instance'],
                [
                    'directedReadOptions' => $this->directedReadOptions,
                    'routeToLeader' => $this->routeToLeader,
                    'defaultQueryOptions' => $this->defaultQueryOptions,
                    'returnInt64AsObject' => $this->returnInt64AsObject,
                    'instance' => $result,
                ],
            );
        };
    }

    private function getResultMapper(): callable
    {
        return function (OperationProto $operation) {
            return $this->resumeOperation(
                $operation->getName(),
                $this->handleResponse($operation)
            );
        };
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
            'spannerClient' => get_class($this->spannerClient),
            'databaseAdminClient' => get_class($this->databaseAdminClient),
            'instanceAdminClient' => get_class($this->instanceAdminClient),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
        ];
    }
}
