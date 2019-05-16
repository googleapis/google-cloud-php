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
 * $key = $storage->hmacKey($accessId);
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
    private $metadata;

    /**
     * @var string|null
     */
    private $secret;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Storage.
     * @param string $projectId The current project ID.
     * @param string $accessId The key identifier.
     * @param array|null $metadata The key metadata.
     * @param string|null $secret The key secret.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $accessId,
        array $metadata = [],
        $secret = null
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->accessId = $accessId;
        $this->metadata = $metadata;
        $this->secret = $secret;
    }

    /**
     * Get the HMAC Key Access ID.
     *
     * Example:
     * ```
     * $accessId = $key->accessId();
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
     * $keyMetadata = $key->reload();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request.
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->metadata = $this->connection->getHmacKey([
            'projectId' => $this->projectId,
            'accessId' => $this->accessId
        ] + $options);

        return $this->metadata;
    }

    /**
     * Get the HMAC Key Metadata.
     *
     * If the metadata is not already available, it will be requested from Cloud
     * Storage.
     *
     * Example:
     * ```
     * $keyMetadata = $key->metadata();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request.
     * }
     * @return array
     */
    public function metadata(array $options = [])
    {
        return $this->metadata ?: $this->reload($options);
    }

    /**
     * Get the HMAC Key Secret.
     *
     * Only populated immediately after key creation.
     *
     * Example:
     * ```
     * $secret = $key->secret();
     * ```
     *
     * @return string|null
     */
    public function secret()
    {
        return $this->secret;
    }

    /**
     * Update the HMAC Key state.
     *
     * Example:
     * ```
     * $key->update('INACTIVE');
     * ```
     *
     * @param string $state The key state. Either `ACTIVE` or `INACTIVE`.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request.
     * }
     * @return array
     */
    public function update($state, array $options = [])
    {
        $this->metadata = $this->connection->updateHmacKey([
            'accessId' => $this->accessId,
            'projectId' => $this->projectId,
            'state' => $state
        ] + $options);

        return $this->metadata;
    }

    /**
     * Delete the HMAC Key.
     *
     * Key state must be set to `INACTIVE` prior to deletion. See
     * {@see Google\Cloud\Storage\HmacKey::update()} for details.
     *
     * Example:
     * ```
     * $key->delete();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $userProject If set, this is the ID of the project which
     *           will be billed for the request.
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
