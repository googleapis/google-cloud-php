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
use Google\ApiCore\Serializer;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as BackupProto;
use Google\Cloud\Spanner\Admin\Database\V1\Backup\State;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest;
use DateTimeInterface;

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
    use ApiHelperTrait;
    use RequestProcessorTrait;
    use RequestTrait;

    const STATE_READY = State::READY;
    const STATE_CREATING = State::CREATING;

    /**
     * Create an object representing a Backup.
     *
     * @internal Backup is constructed by the {@see Instance} class.
     *
     * @param DatabaseAdminClient The database admin client to make backup RPC calls.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param Instance $instance The instance in which the backup exists.
     * @param string $projectId The project ID.
     * @param string $name The backup name or ID.
     * @param array $info [optional] An array representing the backup resource.
     */
    public function __construct(
        private DatabaseAdminClient $databaseAdminClient,
        private Serializer $serializer,
        private Instance $instance,
        private $projectId,
        private string $name,
        private array $info = []
    ) {
        $this->name = $this->fullyQualifiedBackupName($name);
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
     * @return OperationResponse
     * @throws \InvalidArgumentException
     */
    public function create($database, DateTimeInterface $expireTime, array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data = $this->validateAndFormatVersionTime($data);

        $data += [
            'parent' => $this->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($this->name)['backup'],
            'backup' => [
                'database' => $this->instance->database($database)->name(),
                'expireTime' => $this->formatTimestampForApi($expireTime->format('Y-m-d\TH:i:s.u\Z'))
            ],
        ];
        if (isset($data['versionTime'])) {
            $data['backup']['versionTime'] = $data['versionTime'];
            unset($data['versionTime']);
        }

        $request = $this->serializer->decodeMessage(new CreateBackupRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->instance->name());

        return $this->databaseAdminClient->createBackup($request, $callOptions)
            ->withResultFunction($this->backupResultFunction());
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
     * @return OperationResponse
     * @throws \InvalidArgumentException
     */
    public function createCopy(Backup $newBackup, DateTimeInterface $expireTime, array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'parent' => $newBackup->instance->name(),
            'backupId' => DatabaseAdminClient::parseName($newBackup->name)['backup'],
            'sourceBackup' => $this->fullyQualifiedBackupName($this->name),
            'expireTime' => $this->formatTimestampForApi($expireTime->format('Y-m-d\TH:i:s.u\Z'))
        ];

        $request = $this->serializer->decodeMessage(new CopyBackupRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->instance->name());

        return $this->databaseAdminClient->copyBackup($request, $callOptions)
            ->withResultFunction($this->backupResultFunction());
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
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'name' => $this->name
        ];

        $request = $this->serializer->decodeMessage(new DeleteBackupRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->name);

        $this->databaseAdminClient->deleteBackup($request, $callOptions);
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
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'name' => $this->name
        ];

        $request = $this->serializer->decodeMessage(new GetBackupRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->name);

        $response = $this->databaseAdminClient->getBackup($request, $callOptions);
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
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'backup' => [
                'name' => $this->name(),
                'expireTime' => $this->formatTimestampForApi(
                    $newTimestamp->format('Y-m-d\TH:i:s.u\Z')
                ),
            ],
            'updateMask' => [
                'paths' => ['expire_time']
            ]
        ];

        $request = $this->serializer->decodeMessage(new UpdateBackupRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->name);

        $response = $this->databaseAdminClient->updateBackup($request, $callOptions);
        return $this->info = $this->handleResponse($response);
    }

    /**
     * Resume a Long Running Operation
     *
     * Example:
     * ```
     * $operation = $spanner->resumeOperation($operationName);
     * ```
     *
     * @param string $operationName The Long Running Operation name.
     * @return OperationResponse
     */
    public function resumeOperation($operationName)
    {
        return (new OperationResponse(
            $operationName,
            $this->databaseAdminClient->getOperationsClient()
        ))->withResultFunction($this->backupResultFunction());
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

    /**
     * @param array $options
     * @return array
     */
    private function validateAndFormatVersionTime(array $options)
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
            $options['versionTime'] = $this->formatTimestampForApi(
                $options['versionTime']->format('Y-m-d\TH:i:s.u\Z')
            );
        }
        return $options;
    }

    private function backupResultFunction(): Closure
    {
        return function (BackupProto $backup) {
            $name = DatabaseAdminClient::parseName($backup->getName());
            $info = $this->serializer->decodeMessage($backup);
            return $this->instance->backup($name['name'], $info);
        };
    }
}
