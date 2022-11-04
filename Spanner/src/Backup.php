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

use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\Admin\Database\V1\Backup\State;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use DateTimeInterface;

/**
 * Represents a Cloud Spanner Backup.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $backup = $spanner->instance('my-instance')->backup('my-backup');
 * ```
 *
 * @method resumeOperation() {
 *     Resume a long running operation
 *
 *     Example:
 *     ```
 *     $operation = $backup->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The long running operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 * @method longRunningOperations() {
 *     List long running operations.
 *
 *     Example:
 *     ```
 *     $operations = $backup->longRunningOperations();
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
 *     @return ItemIterator<LongRunningOperation>
 * }
 */
class Backup
{
    use ArrayTrait;
    use LROTrait;

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var Instance
     */
    private $instance;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * Create an object representing a Backup.
     *
     * @param ConnectionInterface $connection The connection to the
     *        Cloud Spanner Admin API.
     * @param Instance $instance The instance in which the backup exists.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param array $lroCallables
     * @param string $projectId The project ID.
     * @param string $name The backup name or ID.
     * @param array $info [optional] An array representing the backup resource.
     */
    public function __construct(
        ConnectionInterface $connection,
        Instance $instance,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $name,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedBackupName($name);
        $this->info = $info;

        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
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
     * @return LongRunningOperation<Backup>
     * @throws \InvalidArgumentException
     */
    public function create($database, DateTimeInterface $expireTime, array $options = [])
    {
        if (isset($options['versionTime'])) {
            if (!($options['versionTime'] instanceof DateTimeInterface)) {
                throw new \InvalidArgumentException(
                    'Optional argument `versionTime` must be a DateTimeInterface, got ' .
                    (is_object($options['versionTime'])
                        ? get_class($options['versionTime'])
                        : gettype($options['versionTime']))
                );
            }
            $options['versionTime'] = $options['versionTime']->format('Y-m-d\TH:i:s.u\Z');
        }
        $operation = $this->connection->createBackup([
            'instance' => $this->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($this->name)['backup'],
            'backup' => [
                'database' => $this->instance->database($database)->name(),
                'expireTime' => $expireTime->format('Y-m-d\TH:i:s.u\Z'),
            ],
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
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
     *
     *         @type DateTimeInterface $versionTime The version time for the externally
     *              consistent copy of the database. If not present, it will be the same
     *              as the create time of the backup.
     *     }
     * @return LongRunningOperation<Backup>
     * @throws \InvalidArgumentException
     */
    public function createCopy(Backup $newBackup, DateTimeInterface $expireTime, array $options = [])
    {
        $operation = $this->connection->copyBackup([
            'instance' => $newBackup->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($newBackup->name)['backup'],
            'sourceBackupId' => $this->fullyQualifiedBackupName($this->name),
            'expireTime' => $expireTime->format('Y-m-d\TH:i:s.u\Z')
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
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
    public function delete(array $options = [])
    {
        return $this->connection->deleteBackup(['name' => $this->name] + $options);
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
    public function exists(array $options = [])
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
    public function info(array $options = [])
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
    public function name()
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
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getBackup([
            'name' => $this->name
        ] + $options);
    }

    /**
     * Return the backup state.
     *
     * When backups are created, they may take some time before
     * they are ready for use. This method allows for checking whether a
     * backup is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see Google\Cloud\Spanner\Backup::reload()}
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
    public function state(array $options = [])
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
     * @return Backup
     */
    public function updateExpireTime(DateTimeInterface $newTimestamp, array $options = [])
    {
        return $this->info = $this->connection->updateBackup([
            'backup' => [
                'name' => $this->name(),
                'expireTime' => $newTimestamp->format('Y-m-d\TH:i:s.u\Z'),
            ],
            'updateMask' => [
                'paths' => ['expire_time']
            ]
        ] + $options);
    }

    /**
     * Convert the simple backup name to a fully qualified name.
     *
     * @return string
     */
    private function fullyQualifiedBackupName($name)
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
}
