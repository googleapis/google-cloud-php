<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Objects are the individual pieces of data that you store in Google Cloud
 * Storage.
 */
class Object
{
    /**
     * @var ConnectionInterface Represents a connection to Cloud Storage.
     */
    private $connection;

    /**
     * @var array The object's metadata.
     */
    private $data;

    /**
     * @var array The object's identity.
     */
    private $identity;

    /**
     * @var Acl ACL for the object.
     */
    private $acl;

    /**
     * @param ConnectionInterface $connection Represents a connection to Cloud
     *        Storage.
     * @param string $name The object's name.
     * @param string $bucket The name of the bucket the object is contained in.
     * @param string $generation The generation of the object.
     * @param array $data The object's metadata.
     */
    public function __construct(ConnectionInterface $connection, $name, $bucket, $generation = null, array $data = null)
    {
        $this->connection = $connection;
        $this->data = $data;
        $this->identity = [
            'bucket' => $bucket,
            'object' => $name,
            'generation' => $generation
        ];

        $this->acl = new Acl($this->connection, 'objectAccessControls', $this->identity);
    }

    /**
     * Configure ACL for this object.
     *
     * Example:
     * ```
     * use Google\Cloud\Storage\Acl;
     *
     * $acl = $object->acl();
     * $acl->add('allAuthenticatedUsers', Acl::ROLE_READER);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/access-control More about Access Control Lists
     *
     * @return Acl
     */
    public function acl()
    {
        return $this->acl;
    }

    /**
     * Check whether or not the object exists.
     *
     * Example:
     * ```
     * $bucket->exists();
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        try {
            $this->connection->getObject($this->identity + ['fields' => 'name']);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Delete the object.
     *
     * Example:
     * ```
     * $object->delete();
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/delete Objects delete API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the object's current generation matches the given
     *           value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the object's current generation does not match the
     *           given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the object's current metageneration matches the
     *           given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the object's current metageneration does
     *           not match the given value.
     * }
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteObject($options + $this->identity);
    }

    /**
     * Update the object. Upon receiving a result the local object's data will
     * be updated.
     *
     * Example:
     * ```
     * // Add custom metadata to an existing object.
     * $object->update([
     *     'metadata' => [
     *         'albumType' => 'family'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/patch Objects patch API documentation.
     *
     * @param array $metadata The available options for metadata are outlined
     *        at the [JSON API docs](https://cloud.google.com/storage/docs/json_api/v1/objects#resource)
     * @param array $options {
     *     Configuration options.
     *
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the object's current generation matches the given
     *           value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the object's current generation does not match the
     *           given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the object's current metageneration matches the
     *           given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the object's current metageneration does
     *           not match the given value.
     *     @type string $predefinedAcl Apply a predefined set of access controls
     *           to this object.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     *     @type string $fields Selector which will cause the response to only
     *           return the specified fields.
     * }
     * @return array
     */
    public function update(array $metadata, array $options = [])
    {
        $options += $metadata;
        $this->data = $this->connection->patchObject($options + $this->identity);

        return $this->data;
    }

    /**
     * Download an object as a string.
     *
     * Example:
     * ```
     * $string = $object->downloadAsString();
     * file_put_contents($string, 'my-file.txt');
     * ```
     *
     * @param array $options Configuration options.
     * @return string
     */
    public function downloadAsString(array $options = [])
    {
        return (string) $this->connection->downloadObject($options + $this->identity);
    }

    /**
     * Download an object to a specified location.
     *
     * Example:
     * ```
     * $object->downloadToFile('my-file.txt');
     * ```
     *
     * @param string $path Path to download file to.
     * @param array $options Configuration options.
     * @return StreamInterface
     */
    public function downloadToFile($path, array $options = [])
    {
        $destination = Psr7\stream_for(fopen($path, 'w'));

        Psr7\copy_to_stream(
            $this->connection->downloadObject($options + $this->identity),
            $destination
        );

        $destination->seek(0);

        return $destination;
    }

    /**
     * Retrieves the object's details.
     *
     * Example:
     * ```
     * $info = $object->getInfo();
     * echo $info['metadata'];
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $force If true fetches fresh data, otherwise returns data
     *           stored locally if it exists.
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the object's current generation matches the given
     *           value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the object's current generation does not match the
     *           given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the object's current metageneration matches the
     *           given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the object's current metageneration does
     *           not match the given value.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     * }
     * @return array
     */
    public function getInfo(array $options = [])
    {
        if (!$this->data || isset($options['force'])) {
            $this->data = $this->connection->getObject($options + $this->identity);
        }

        return $this->data;
    }

    /**
     * Retrieves the object's name.
     *
     * Example:
     * ```
     * echo $object->getName();
     * ```
     *
     * @return string
     */
    public function getName()
    {
        return $this->identity['object'];
    }

    /**
     * Retrieves the object's identity.
     *
     * Example:
     * ```
     * echo $object->getIdentity()['object'];
     * ```
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
