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

use Google\ApiCore\Serializer;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\LongRunning\LongRunningOperationTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance\State;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceRequest;
use Google\Cloud\Spanner\Backup;
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
 *     @return LongRunningOperationManager
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
    use ApiHelperTrait;
    use ArrayTrait;
    use LongRunningOperationTrait;
    use OperationResponseTrait;
    use RequestTrait;

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

    const DEFAULT_NODE_COUNT = 1;

    /**
     * @var RequestHandler
     * @internal
     * The request handler that is responsible for sending a request and
     * serializing responses into relevant classes.
     */
    private $requestHandler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

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
     * @var IamManager|null
     */
    private $iam;

    /**
     * @var array
     */
    private $lroCallables;

    /**
     * @var array
     */
    private $directedReadOptions;

    /**
     * @var array
     */
    private $defaultQueryOptions;

    /**
     * @var bool
     */
    private $routeToLeader;

    /**
     * Create an object representing a Cloud Spanner instance.
     *
     * @param RequestHandler The request handler that is responsible for sending a request
     *        and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param array $lroCallables
     * @param string $projectId The project ID.
     * @param string $name The instance name or ID.
     * @param bool $returnInt64AsObject [optional] If true, 64 bit integers will be
     *        returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit platform
     *        compatibility. **Defaults to** false.
     * @param array $info [optional] A representation of the instance object.
     * @param array $options [optional]{
     *     Instance options
     *
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *           **Defaults to** `true` (enabled).
     * }
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        array $lroCallables,
        $projectId,
        $name,
        $returnInt64AsObject = false,
        array $info = [],
        array $options = []
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedInstanceName($name, $projectId);
        $this->returnInt64AsObject = $returnInt64AsObject;
        $this->info = $info;
        $this->lroCallables = $lroCallables;
        $this->setLroProperties(
            $requestHandler,
            $serializer,
            $this->lroCallables,
            $this->getLROResponseMappers(),
            $this->name,
            InstanceAdminClient::class
        );
        $this->directedReadOptions = $options['directedReadOptions'] ?? [];
        $this->routeToLeader = $options['routeToLeader'] ?? true;
        $this->defaultQueryOptions = $options['defaultQueryOptions'] ?? [];
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        try {
            if ($this->info) {
                $data += [
                    'name' => $this->name,
                    'fieldMask' => ['paths' => ['name']],
                ];
                $this->createAndSendRequest(
                    InstanceAdminClient::class,
                    'getInstance',
                    $data,
                    $optionalArgs,
                    GetInstanceRequest::class,
                    InstanceAdminClient::projectName(
                        $this->projectId
                    )
                );
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += [
            'name' => $this->name
        ];

        return $this->info = $this->createAndSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            $data,
            $optionalArgs,
            GetInstanceRequest::class,
            InstanceAdminClient::projectName(
                $this->projectId
            )
        );
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
     * @return LongRunningOperationManager<Instance>
     * @throws \InvalidArgumentException
     * @codingStandardsIgnoreEnd
     */
    public function create(InstanceConfiguration $config, array $options = [])
    {
        list($instance, $optionalArgs) = $this->splitOptionalArgs($options);
        $instanceId = InstanceAdminClient::parseName($this->name)['instance'];
        if (isset($instance['nodeCount']) && isset($instance['processingUnits'])) {
            throw new \InvalidArgumentException("Must only set either `nodeCount` or `processingUnits`");
        }
        if (empty($instance['nodeCount']) && empty($instance['processingUnits'])) {
            $instance['nodeCount'] = self::DEFAULT_NODE_COUNT;
        }

        $data = [
            'parent' => InstanceAdminClient::projectName(
                $this->projectId
            ),
            'instanceId' => $instanceId,
            'instance' => $this->createInstanceArray($instance, $config)
        ];

        $res = $this->createAndSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            $data,
            $optionalArgs,
            GetInstanceRequest::class,
            $this->name
        );

        $operation = $this->operationToArray(
            $res,
            $this->serializer,
            $this->getLROResponseMappers()
        );

        return $this->resumeOperation($operation['name'], $operation);
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
     * @return LongRunningOperationManager
     * @throws \InvalidArgumentException
     */
    public function update(array $options = [])
    {
        list($instance, $optionalArgs) = $this->splitOptionalArgs($options);

        if (isset($options['nodeCount']) && isset($options['processingUnits'])) {
            throw new \InvalidArgumentException("Must only set either `nodeCount` or `processingUnits`");
        }

        $fieldMask = $this->fieldMask($instance);
        $data = [
            'filedMask' => $fieldMask,
            'instance' => $this->createInstanceArray($instance)
        ];
        $res = $this->createAndSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            $data,
            $optionalArgs,
            UpdateInstanceRequest::class,
            $this->name
        );
        $operation = $this->operationToArray(
            $res,
            $this->serializer,
            $this->getLROResponseMappers()
        );

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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['name'] = $this->name;
        $this->createAndSendRequest(
            InstanceAdminClient::class,
            'deleteInstance',
            $data,
            $optionalArgs,
            DeleteInstanceRequest::class,
            $this->name
        );
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
     * @return LongRunningOperationManager<Database>
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
     * @return LongRunningOperationManager<Database>
     */
    public function createDatabaseFromBackup($name, $backup, array $options = [])
    {
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type SessionPoolInterface $sessionPool A pool used to manage
     *           sessions.
     *     @type string $databaseRole The user created database role which creates the session.
     * }
     * @return Database
     */
    public function database($name, array $options = [])
    {
        return new Database(
            $this->requestHandler,
            $this->serializer,
            $this,
            $this->lroCallables,
            $this->projectId,
            $name,
            isset($options['sessionPool']) ? $options['sessionPool'] : null,
            $this->returnInt64AsObject,
            isset($options['database']) ? $options['database'] : [],
            isset($options['databaseRole']) ? $options['databaseRole'] : '',
            [
                'routeToLeader' => $this->routeToLeader,
                'defaultQueryOptions' => $this->defaultQueryOptions,
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
    public function databases(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['parent'] = $this->name;

        $resultLimit = $this->pluck('resultLimit', $data, false);
        return new ItemIterator(
            new PageIterator(
                function (array $database) {
                    return $this->database($database['name'], ['database' => $database]);
                },
                function ($callOptions) use ($optionalArgs, $data) {
                    if (isset($callOptions['pageToken'])) {
                        $data['pageToken'] = $callOptions['pageToken'];
                    }

                    return $this->createAndSendRequest(
                        DatabaseAdminClient::class,
                        'listDatabases',
                        $data,
                        $optionalArgs,
                        ListDatabasesRequest::class,
                        $this->name
                    );
                },
                $options,
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
            $this->requestHandler,
            $this->serializer,
            $this,
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['parent'] = $this->name;

        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $backup) {
                    return $this->backup(
                        $backup['name'],
                        $backup
                    );
                },
                function ($callOptions) use ($optionalArgs, $data) {
                    if (isset($callOptions['pageToken'])) {
                        $data['pageToken'] = $callOptions['pageToken'];
                    }

                    return $this->createAndSendRequest(
                        DatabaseAdminClient::class,
                        'listBackups',
                        $data,
                        $optionalArgs,
                        ListBackupsRequest::class,
                        $this->name
                    );
                },
                $options,
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
     * @return ItemIterator<LongRunningOperationManager>
     */
    public function backupOperations(array $options = [])
    {
        // @TODO: Add a better logic for the database name here.
        return $this->database($this->name)->backupOperations($options);
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
     * @return ItemIterator<LongRunningOperationManager>
     */
    public function databaseOperations(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['parent'] = $this->name;

        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $operation) {
                    return $this->resumeOperation($operation['name'], $operation);
                },
                function ($callOptions) use ($optionalArgs, $data) {
                    if (isset($callOptions['pageToken'])) {
                        $data['pageToken'] = $callOptions['pageToken'];
                    }

                    $result = $this->createAndSendRequest(
                        DatabaseAdminClient::class,
                        'listDatabaseOperations',
                        $data,
                        $optionalArgs,
                        ListDatabaseOperationsRequest::class,
                        $this->name
                    );
                    return array_map([$this, 'deserializeOperationArray'], $result['operations']);
                },
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
     * @return IamManager
     */
    public function iam()
    {
        if (!$this->iam) {
            $this->iam = new IamManager(
                $this->requestHandler,
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
    private function fullyQualifiedInstanceName($name, $project)
    {
        return InstanceAdminClient::instanceName(
            $project,
            $name
        );
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
            'requestHandler' => get_class($this->requestHandler),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info
        ];
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
    public function directedReadOptions()
    {
        return $this->directedReadOptions;
    }

    /**
     * @param array $instanceArray
     * @return array
     */
    private function fieldMask(array $instanceArray)
    {
        $mask = [];
        foreach (array_keys($instanceArray) as $key) {
            $mask[] = $this->serializer::toSnakeCase($key);
        }
        return ['paths' => $mask];
    }

    /**
     * @param array $instanceArray
     * @param InstanceConfiguration $config
     * @return array
     */
    public function createInstanceArray(array $instanceArray, InstanceConfiguration $config = null)
    {
        return $instanceArray + [
            'name' => $this->name,
            'displayName' => InstanceAdminClient::parseName($this->name)['instance'],
            'labels' => [],
            'config' => $config ? $config->name() : null
        ];
    }
}
