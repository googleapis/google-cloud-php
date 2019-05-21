<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

use Google\Cloud\Storage\Connection\ConnectionInterface;

/**
 * Represents a Service Account HMAC key.
 *
 * Example:
 * ```
 * use Google\Cloud\Storage\StorageClient;
 *
 * $storage = new StorageClient();
 * $hmacKey = $storage->hmacKey($accessId);
 * ```
 */
class HmacKey
{
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
    private $accessId;

    /**
     * @var array|null
     */
    private $info;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Storage.
     * @param string $projectId The current project ID.
     * @param string $accessId The key identifier.
     * @param array|null $info The key metadata.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $accessId,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->accessId = $accessId;
        $this->info = $info;
    }

    /**
     * Get the HMAC Key Access ID.
     *
     * Example:
     * ```
     * $accessId = $hmacKey->accessId();
     * ```
     *
     * @return string
     */
    public function accessId()
    {
        return $this->accessId;
    }

    /**
     * Fetch the key metadata from Cloud Storage.
     *
     * Example:
     * ```
     * $keyMetadata = $hmacKey->reload();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request. **NOTE**: This option is
     *           currently ignored by Cloud Storage.
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getHmacKey([
            'projectId' => $this->projectId,
            'accessId' => $this->accessId
        ] + $options);

        return $this->info;
    }

    /**
     * Get the HMAC Key Metadata.
     *
     * If the metadata is not already available, it will be requested from Cloud
     * Storage.
     *
     * Example:
     * ```
     * $keyMetadata = $hmacKey->info();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request. **NOTE**: This option is
     *           currently ignored by Cloud Storage.
     * }
     * @return array
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Update the HMAC Key state.
     *
     * Example:
     * ```
     * $hmacKey->update('INACTIVE');
     * ```
     *
     * @param string $state The key state. Either `ACTIVE` or `INACTIVE`.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request. **NOTE**: This option is
     *           currently ignored by Cloud Storage.
     * }
     * @return array
     */
    public function update($state, array $options = [])
    {
        $this->info = $this->connection->updateHmacKey([
            'accessId' => $this->accessId,
            'projectId' => $this->projectId,
            'state' => $state
        ] + $options);

        return $this->info;
    }

    /**
     * Delete the HMAC Key.
     *
     * Key state must be set to `INACTIVE` prior to deletion. See
     * {@see Google\Cloud\Storage\HmacKey::update()} for details.
     *
     * Example:
     * ```
     * $hmacKey->delete();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request. **NOTE**: This option is
     *           currently ignored by Cloud Storage.
     * }
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteHmacKey([
            'accessId' => $this->accessId,
            'projectId' => $this->projectId,
        ] + $options);
    }
}
