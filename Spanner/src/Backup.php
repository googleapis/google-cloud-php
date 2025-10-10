<?php
/**
 * Copyright 2020 Google Inc.
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
use DateTimeInterface;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningClientConnection;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Spanner\Admin\Database\V1\Backup\State;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\Operation as OperationProto;

/**
 * Represents a Cloud Spanner Backup.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 *
 * $backup = $spanner->instance('my-instance')->backup('my-backup');
 * ```
 */
class Backup
{
    use RequestTrait;

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

    private array $info;

    /**
     * Create an object representing a Backup.
     *
     * @internal Backup is constructed by the {@see Instance} class.
     *
     * @param DatabaseAdminClient $databaseAdminClient The database admin client to make backup RPC
     *        calls.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param Instance $instance The instance in which the backup exists.
     * @param string $projectId The project ID.
     * @param string $name The backup name or ID.
     * @param array $options [Optional] {
     *     Backup options.

     *     @type array $backup The backup info.
     * }
     */
    public function __construct(
        private DatabaseAdminClient $databaseAdminClient,
        private Serializer $serializer,
        private Instance $instance,
        private string $projectId,
        private string $name,
        array $options = []
    ) {
        $this->name = $this->fullyQualifiedBackupName($name);
        $this->info = $options['info'] ?? [];
        $this->optionsValidator = new OptionsValidator($serializer);
    }

    /**
     * Create a Cloud Spanner backup for a database.
     *
     * Example:
     * ```
     * $operation = $backup->create('my-database', new \DateTime('+7 hours'));
     * ```
     *
     * @param string $database The name or id of the database that this backup is for.
     * @param DateTimeInterface $expireTime ​The expiration time of the backup,
     *        with microseconds granularity that must be at least 6 hours and
     *        at most 366 days. Once the expireTime has passed, the backup is
     *        eligible to be automatically deleted by Cloud Spanner.
     * @param array $options [optional] {
     *         Configuration Options.
     *
     *         @type DateTimeInterface $versionTime The version time for the externally
     *              consistent copy of the database. If not present, it will be the same
     *              as the create time of the backup.
     *     }
     * @return LongRunningOperation
     * @throws \InvalidArgumentException
     */
    public function create(
        string $database,
        DateTimeInterface $expireTime,
        array $options = []
    ): LongRunningOperation {
        $options += [
            'parent' => $this->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($this->name)['backup'],
            'backup' => [
                'database' => $this->instance->database($database)->name(),
                'expireTime' => $this->formatTimeAsArray($expireTime),
            ],
        ];

        if ($versionTime = $this->pluck('versionTime', $options, false)) {
            if (!$versionTime instanceof DateTimeInterface) {
                throw new \InvalidArgumentException(
                    'Optional argument `versionTime` must be a DateTimeInterface'
                );
            }
            $options['backup']['versionTime'] = $this->formatTimeAsArray($versionTime);
        }

        /**
         * @var CreateBackupRequest $createBackup
         * @var array $callOptions
         */
        [$createBackup, $callOptions] = $this->validateOptions(
            $options,
            new CreateBackupRequest(),
            CallOptions::class
        );

        $operation = $this->databaseAdminClient->createBackup($createBackup, $callOptions + [
            'resource-prefix' => $this->instance->name(),
        ]);
        return $this->operationFromOperationResponse($operation);
    }

    /**
     * Create a copy of an existing backup in Cloud Spanner.
     *
     * Example:
     * ```
     * $sourceInstance = $spanner->instance('source-instance-id');
     * $destInstance = $spanner->instance('destination-instance-id');
     * $sourceBackup = $sourceInstance->backup('source-backup-id');
     * $destBackup = $destInstance->backup('new-backup-id');
     *
     * $operation = $sourceBackup->createCopy($destBackup, new \DateTime('+7 hours'));
     * ```
     *
     * @param Backup $newBackup The backup object that needs to be created as a copy.
     * @param DateTimeInterface $expireTime The expiration time of the backup,
     *        with microseconds granularity that must be at least 6 hours and
     *        at most 366 days. Once the expireTime has passed, the backup is
     *        eligible to be automatically deleted by Cloud Spanner.
     * @param array $options [optional] {
     *         Configuration Options.
     *     }
     * @return LongRunningOperation
     * @throws \InvalidArgumentException
     */
    public function createCopy(
        Backup $newBackup,
        DateTimeInterface $expireTime,
        array $options = []
    ): LongRunningOperation {
        $options += [
            'parent' => $newBackup->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($newBackup->name)['backup'],
            'sourceBackup' => $this->fullyQualifiedBackupName($this->name),
            'expireTime' => $this->formatTimeAsArray($expireTime)
        ];

        /**
         * @var CopyBackupRequest $copyBackup
         * @var array $callOptions
         */
        [$copyBackup, $callOptions] = $this->validateOptions(
            $options,
            new CopyBackupRequest(),
            CallOptions::class
        );

        $operation = $this->databaseAdminClient->copyBackup($copyBackup, $callOptions + [
            'resource-prefix' => $this->instance->name(),
        ]);
        return $this->operationFromOperationResponse($operation);
    }

    /**
     * Marks this backup for deletion.
     *
     * Example:
     * ```
     * $backup->delete();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = []): void
    {
        $options += [
            'name' => $this->name
        ];

        /**
         * @var DeleteBackupRequest $deleteBackup
         * @var array $callOptions
         */
        [$deleteBackup, $callOptions] = $this->validateOptions(
            $options,
            new DeleteBackupRequest(),
            CallOptions::class,
        );

        $this->databaseAdminClient->deleteBackup($deleteBackup, $callOptions + [
            'resource-prefix' => $this->name,
        ]);
    }

    /**
     * Tests whether this backup exists.
     *
     * This method sends a service call.
     *
     * Example:
     * ```
     * if ($backup->exists()) {
     *     echo 'Backup exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = []): bool
    {
        try {
            $this->reload($options);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Get info of a Cloud Spanner backup from cache or request.
     *
     * Example:
     * ```
     * $info = $backup->info();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = []): array
    {
        if (!$this->info) {
            $this->info = $this->reload($options);
        }
        return $this->info;
    }

    /**
     * Return the backup name.
     *
     * Example:
     * ```
     * $name = $backup->name();
     * ```
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Reload the backup info from the Cloud Spanner API.
     *
     * Example:
     * ```
     * $info = $backup->reload();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = []): array
    {
        $options += [
            'name' => $this->name
        ];

        /**
         * @var GetBackupRequest $getBackup
         * @var array $callOptions
         */
        [$getBackup, $callOptions] = $this->validateOptions(
            $options,
            new GetBackupRequest(),
            CallOptions::class,
        );

        $response = $this->databaseAdminClient->getBackup($getBackup, $callOptions + [
            'resource-prefix' => $this->name,
        ]);

        return $this->info = $this->handleResponse($response);
    }

    /**
     * Return the backup state.
     *
     * When backups are created, they may take some time before
     * they are ready for use. This method allows for checking whether a
     * backup is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see \Google\Cloud\Spanner\Backup::reload()}
     * to refresh the cached value.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\Backup;
     *
     * if ($backup->state() === Backup::STATE_READY) {
     *     echo 'Backup is ready!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return int|null
     */
    public function state(array $options = []): int|null
    {
        $info = $this->info($options);

        return (isset($info['state']))
            ? $info['state']
            : null;
    }

    /**
     * Update the expire time of this backup.
     *
     * Example:
     * ```
     * $info = $backup->updateExpireTime(new \DateTime("+ 7 hours"));
     * ```
     *
     * @param DateTimeInterface $newTimestamp New expire time.
     * @param array $options [optional] Configuration options.
     *
     * @return array
     */
    public function updateExpireTime(DateTimeInterface $newTimestamp, array $options = []): array
    {
        $options += [
            'backup' => [
                'name' => $this->name(),
                'expireTime' => $this->formatTimeAsArray($newTimestamp),
            ],
            'updateMask' => [
                'paths' => ['expire_time']
            ]
        ];

        /**
         * @var UpdateBackupRequest $updateBackup
         * @var array $callOptions
         */
        [$updateBackup, $callOptions] = $this->validateOptions(
            $options,
            new UpdateBackupRequest(),
            CallOptions::class,
        );

        $response = $this->databaseAdminClient->updateBackup($updateBackup, $callOptions + [
            'resource-prefix' => $this->name,
        ]);

        return $this->info = $this->handleResponse($response);
    }

    /**
     * Resume a Long Running Operation
     *
     * Example:
     * ```
     * $operation = $backup->resumeOperation($operationName);
     * ```
     *
     * @param string $operationName The Long Running Operation name.
     * @return LongRunningOperation
     */
    public function resumeOperation(string $operationName, array $options = []): LongRunningOperation
    {
        return new LongRunningOperation(
            new LongRunningClientConnection($this->databaseAdminClient, $this->serializer),
            $operationName,
            [
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateBackupMetadata',
                    'callable' => $this->backupResultFunction(),
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
     * $operations = $backup->longRunningOperations();
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
         * @var ListOperationsRequest $listOperations
         * @var array $callOptions
         */
        [$listOperations, $callOptions] = $this->validateOptions(
            $options,
            new ListOperationsRequest(),
            CallOptions::class,
        );
        $listOperations->setName($this->name . '/operations');

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient->getOperationsClient(), 'listOperations'],
            $listOperations,
            $callOptions,
            function (OperationProto $operation) {
                return $this->resumeOperation(
                    $operation->getName(),
                    $this->handleResponse($operation)
                );
            }
        );
    }

    /**
     * Convert the simple backup name to a fully qualified name.
     *
     * @return string
     */
    private function fullyQualifiedBackupName(string $name): string
    {
        $instance = DatabaseAdminClient::parseName($this->instance->name())['instance'];

        try {
            return DatabaseAdminClient::backupName(
                $this->projectId,
                $instance,
                $name
            );
            //@codeCoverageIgnoreStart
        } catch (ValidationException $e) {
            return $name;
        }
        //@codeCoverageIgnoreEnd
    }

    private function backupResultFunction(): Closure
    {
        return function (array $backup) {
            $name = DatabaseAdminClient::parseName($backup['name']);
            return $this->instance->backup($name['backup'], $backup);
        };
    }
}
