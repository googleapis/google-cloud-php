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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Objects are the individual pieces of data that you store in Google Cloud
 * Storage.
 *
 * Example:
 * ```
 * use Google\Cloud\Storage\StorageClient;
 *
 * $storage = new StorageClient();
 *
 * $bucket = $storage->bucket('my-bucket');
 * $object = $bucket->object('my-object');
 */
class StorageObject
{
    use EncryptionTrait;

    /**
     * @var Acl ACL for the object.
     */
    private $acl;

    /**
     * @var ConnectionInterface Represents a connection to Cloud Storage.
     */
    protected $connection;

    /**
     * @var array The object's encryption data.
     */
    private $encryptionData;

    /**
     * @var array The object's identity.
     */
    private $identity;

    /**
     * @var array The object's metadata.
     */
    private $info;

    /**
     * @param ConnectionInterface $connection Represents a connection to Cloud
     *        Storage.
     * @param string $name The object's name.
     * @param string $bucket The name of the bucket the object is contained in.
     * @param string $generation [optional] The generation of the object.
     * @param array $info [optional] The object's metadata.
     * @param string $encryptionKey [optional] An AES-256 customer-supplied
     *        encryption key.
     * @param string $encryptionKeySHA256 [optional] The SHA256 hash of the
     *        customer-supplied encryption key.
     */
    public function __construct(
        ConnectionInterface $connection,
        $name,
        $bucket,
        $generation = null,
        array $info = null,
        $encryptionKey = null,
        $encryptionKeySHA256 = null
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->encryptionData = [
            'encryptionKey' => $encryptionKey,
            'encryptionKeySHA256' => $encryptionKeySHA256
        ];
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
     * $acl = $object->acl();
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
     * if ($object->exists()) {
     *     echo "Object exists!";
     * }
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
     * @param array $options [optional] {
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
     * @param array $options [optional] {
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
     *     @type string $predefinedAcl Predefined ACL to apply to the object.
     *           Acceptable values include, `"authenticatedRead"`,
     *           `"bucketOwnerFullControl"`, `"bucketOwnerRead"`, `"private"`,
     *           `"projectPrivate"`, and `"publicRead"`.
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

        // can only set predefinedAcl or acl
        if (isset($options['predefinedAcl'])) {
            $options['acl'] = null;
        }

        return $this->info = $this->connection->patchObject($options + $this->identity);
    }

    /**
     * Copy the object to a destination bucket.
     *
     * Please note that if the destination bucket is the same as the source
     * bucket and a new name is not provided the source object will be replaced
     * with the copy of itself.
     *
     * Example:
     * ```
     * // Provide your destination bucket as a string and retain the source
     * // object's name.
     * $copiedObject = $object->copy('otherBucket');
     * ```
     *
     * ```
     * // Provide your destination bucket as a bucket object and choose a new
     * // name for the copied object.
     * $otherBucket = $storage->bucket('otherBucket');
     * $copiedObject = $object->copy($otherBucket, [
     *     'name' => 'newFile.txt'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/copy Objects copy API documentation.
     *
     * @param Bucket|string $destination The destination bucket.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $name The name of the destination object. **Defaults
     *           to** the name of the source object.
     *     @type string $predefinedAcl Predefined ACL to apply to the object.
     *           Acceptable values include, `"authenticatedRead"`,
     *           `"bucketOwnerFullControl"`, `"bucketOwnerRead"`, `"private"`,
     *           `"projectPrivate"`, and `"publicRead"`.
     *     @type string $encryptionKey A base64 encoded AES-256 customer-supplied
     *           encryption key. It will be neccesary to provide this when a key
     *           was used during the object's creation.
     *     @type string $encryptionKeySHA256 Base64 encoded SHA256 hash of the
     *           customer-supplied encryption key. This value will be calculated
     *           from the `encryptionKey` on your behalf if not provided, but
     *           for best performance it is recommended to pass in a cached
     *           version of the already calculated SHA.
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the destination object's current generation matches the
     *           given value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the destination object's current generation does not
     *           match the given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the destination object's current metageneration
     *           matches the given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the destination object's current
     *           metageneration does not match the given value.
     *     @type string $ifSourceGenerationMatch Makes the operation conditional
     *           on whether the source object's current generation matches the
     *           given value.
     *     @type string $ifSourceGenerationNotMatch Makes the operation
     *           conditional on whether the source object's current generation
     *           does not match the given value.
     *     @type string $ifSourceMetagenerationMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration matches the given value.
     *     @type string $ifSourceMetagenerationNotMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration does not match the given value.
     * }
     * @return StorageObject
     */
    public function copy($destination, array $options = [])
    {
        $key = isset($options['encryptionKey']) ? $options['encryptionKey'] : null;
        $keySHA256 = isset($options['encryptionKeySHA256']) ? $options['encryptionKeySHA256'] : null;

        $response = $this->connection->copyObject(
            $this->formatDestinationRequest($destination, $options)
        );

        return new StorageObject(
            $this->connection,
            $response['name'],
            $response['bucket'],
            $response['generation'],
            $response,
            $key,
            $keySHA256
        );
    }

    /**
     * Rewrite the object to a destination bucket.
     *
     * This method copies data using multiple requests so large objects can be
     * copied with a normal length timeout per request rather than one very long
     * timeout for a single request.
     *
     * Please note that if the destination bucket is the same as the source
     * bucket and a new name is not provided the source object will be replaced
     * with the copy of itself.
     *
     * Example:
     * ```
     * // Provide your destination bucket as a string and retain the source
     * // object's name.
     * $rewrittenObject = $object->rewrite('otherBucket');
     * ```
     *
     * ```
     * // Provide your destination bucket as a bucket object and choose a new
     * // name for the copied object.
     * $otherBucket = $storage->bucket('otherBucket');
     * $rewrittenObject = $object->rewrite($otherBucket, [
     *     'name' => 'newFile.txt'
     * ]);
     * ```
     *
     * ```
     * // Rotate customer-supplied encryption keys.
     * $key = file_get_contents(__DIR__ . '/key.txt');
     * $destinationKey = base64_encode(openssl_random_pseudo_bytes(32)); // Make sure to remember your key.
     *
     * $rewrittenObject = $object->rewrite('otherBucket', [
     *     'encryptionKey' => $key,
     *     'destinationEncryptionKey' => $destinationKey
     * ]);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/rewrite Objects rewrite API documentation.
     * @see https://cloud.google.com/storage/docs/encryption#customer-supplied Customer-supplied encryption keys.
     *
     * @param Bucket|string $destination The destination bucket.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $name The name of the destination object. **Defaults
     *           to** the name of the source object.
     *     @type string $predefinedAcl Predefined ACL to apply to the object.
     *           Acceptable values include, `"authenticatedRead"`,
     *           `"bucketOwnerFullControl"`, `"bucketOwnerRead"`, `"private"`,
     *           `"projectPrivate"`, and `"publicRead"`.
     *     @type string $maxBytesRewrittenPerCall The maximum number of bytes
     *           that will be rewritten per rewrite request. Most callers
     *           shouldn't need to specify this parameter - it is primarily in
     *           place to support testing. If specified the value must be an
     *           integral multiple of 1 MiB (1048576). Also, this only applies
     *           to requests where the source and destination span locations
     *           and/or storage classes.
     *     @type string $encryptionKey A base64 encoded AES-256 customer-supplied
     *           encryption key. It will be neccesary to provide this when a key
     *           was used during the object's creation.
     *     @type string $encryptionKeySHA256 Base64 encoded SHA256 hash of the
     *           customer-supplied encryption key. This value will be calculated
     *           from the `encryptionKey` on your behalf if not provided, but
     *           for best performance it is recommended to pass in a cached
     *           version of the already calculated SHA.
     *     @type string $destinationEncryptionKey A base64 encoded AES-256
     *           customer-supplied encryption key that will be used to encrypt
     *           the rewritten object.
     *     @type string $destinationEncryptionKeySHA256 Base64 encoded SHA256
     *           hash of the customer-supplied destination encryption key. This
     *           value will be calculated from the `destinationEncryptionKey` on
     *           your behalf if not provided, but for best performance it is
     *           recommended to pass in a cached version of the already
     *           calculated SHA.
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the destination object's current generation matches the
     *           given value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the destination object's current generation does not
     *           match the given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the destination object's current metageneration
     *           matches the given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the destination object's current
     *           metageneration does not match the given value.
     *     @type string $ifSourceGenerationMatch Makes the operation conditional
     *           on whether the source object's current generation matches the
     *           given value.
     *     @type string $ifSourceGenerationNotMatch Makes the operation
     *           conditional on whether the source object's current generation
     *           does not match the given value.
     *     @type string $ifSourceMetagenerationMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration matches the given value.
     *     @type string $ifSourceMetagenerationNotMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration does not match the given value.
     * }
     * @return StorageObject
     * @throws \InvalidArgumentException
     */
    public function rewrite($destination, array $options = [])
    {
        $options['useCopySourceHeaders'] = true;
        $destinationKey = isset($options['destinationEncryptionKey']) ? $options['destinationEncryptionKey'] : null;
        $destinationKeySHA256 = isset($options['destinationEncryptionKeySHA256'])
            ? $options['destinationEncryptionKeySHA256']
            : null;

        $options = $this->formatDestinationRequest($destination, $options);

        do {
            $response = $this->connection->rewriteObject($options);
            $options['rewriteToken'] = isset($response['rewriteToken']) ? $response['rewriteToken'] : null;
        } while ($options['rewriteToken']);

        return new StorageObject(
            $this->connection,
            $response['resource']['name'],
            $response['resource']['bucket'],
            $response['resource']['generation'],
            $response['resource'],
            $destinationKey,
            $destinationKeySHA256
        );
    }

    /**
     * Renames the object.
     *
     * Please note that there is no atomic rename provided by the Storage API.
     * This method is for convenience and is a set of sequential calls to copy
     * and delete. Upon success the source object's metadata will be cleared,
     * please use the returned object instead.
     *
     * Example:
     * ```
     * $object2 = $object->rename('object2.txt');
     * echo $object2->name();
     * ```
     *
     * @param string $name The new name.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $predefinedAcl Predefined ACL to apply to the object.
     *           Acceptable values include, `"authenticatedRead"`,
     *           `"bucketOwnerFullControl"`, `"bucketOwnerRead"`, `"private"`,
     *           `"projectPrivate"`, and `"publicRead"`.
     *     @type string $encryptionKey A base64 encoded AES-256 customer-supplied
     *           encryption key. It will be neccesary to provide this when a key
     *           was used during the object's creation.
     *     @type string $encryptionKeySHA256 Base64 encoded SHA256 hash of the
     *           customer-supplied encryption key. This value will be calculated
     *           from the `encryptionKey` on your behalf if not provided, but
     *           for best performance it is recommended to pass in a cached
     *           version of the already calculated SHA.
     *     @type string $ifGenerationMatch Makes the operation conditional on
     *           whether the destination object's current generation matches the
     *           given value.
     *     @type string $ifGenerationNotMatch Makes the operation conditional on
     *           whether the destination object's current generation does not
     *           match the given value.
     *     @type string $ifMetagenerationMatch Makes the operation conditional
     *           on whether the destination object's current metageneration
     *           matches the given value.
     *     @type string $ifMetagenerationNotMatch Makes the operation
     *           conditional on whether the destination object's current
     *           metageneration does not match the given value.
     *     @type string $ifSourceGenerationMatch Makes the operation conditional
     *           on whether the source object's current generation matches the
     *           given value.
     *     @type string $ifSourceGenerationNotMatch Makes the operation
     *           conditional on whether the source object's current generation
     *           does not match the given value.
     *     @type string $ifSourceMetagenerationMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration matches the given value.
     *     @type string $ifSourceMetagenerationNotMatch Makes the operation
     *           conditional on whether the source object's current
     *           metageneration does not match the given value.
     *     @type string $destinationBucket Will move to this bucket if set. If
     *           not set, will default to the same bucket.
     * }
     * @return StorageObject The renamed object.
     */
    public function rename($name, array $options = [])
    {
        $destinationBucket = isset($options['destinationBucket'])
            ? $options['destinationBucket']
            : $this->identity['bucket'];
        unset($options['destinationBucket']);

        $copiedObject = $this->copy($destinationBucket, [
            'name' => $name
        ] + $options);

        $this->delete(
            array_intersect_key($options, [
                'restOptions' => null,
                'retries' => null
            ])
        );
        $this->info = [];

        return $copiedObject;
    }

    /**
     * Download an object as a string.
     *
     * Example:
     * ```
     * $string = $object->downloadAsString();
     * echo $string;
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $encryptionKey An AES-256 customer-supplied encryption
     *           key. It will be neccesary to provide this when a key was used
     *           during the object's creation. If provided one must also include
     *           an `encryptionKeySHA256`.
     *     @type string $encryptionKeySHA256 The SHA256 hash of the
     *           customer-supplied encryption key. It will be neccesary to
     *           provide this when a key was used during the object's creation.
     *           If provided one must also include an `encryptionKey`.
     * }
     * @return string
     */
    public function downloadAsString(array $options = [])
    {
        return (string) $this->downloadAsStream($options);
    }

    /**
     * Download an object to a specified location.
     *
     * Example:
     * ```
     * $stream = $object->downloadToFile(__DIR__ . '/my-file.txt');
     * ```
     *
     * @param string $path Path to download the file to.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $encryptionKey An AES-256 customer-supplied encryption
     *           key. It will be neccesary to provide this when a key was used
     *           during the object's creation. If provided one must also include
     *           an `encryptionKeySHA256`.
     *     @type string $encryptionKeySHA256 The SHA256 hash of the
     *           customer-supplied encryption key. It will be neccesary to
     *           provide this when a key was used during the object's creation.
     *           If provided one must also include an `encryptionKey`.
     * }
     * @return StreamInterface
     */
    public function downloadToFile($path, array $options = [])
    {
        $destination = Psr7\stream_for(fopen($path, 'w'));

        Psr7\copy_to_stream(
            $this->downloadAsStream($options),
            $destination
        );

        $destination->seek(0);

        return $destination;
    }

    /**
     * Download an object as a stream.
     *
     * Example:
     * ```
     * $stream = $object->downloadAsStream();
     * echo $stream->getContents();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $encryptionKey An AES-256 customer-supplied encryption
     *           key. It will be neccesary to provide this when a key was used
     *           during the object's creation. If provided one must also include
     *           an `encryptionKeySHA256`.
     *     @type string $encryptionKeySHA256 The SHA256 hash of the
     *           customer-supplied encryption key. It will be neccesary to
     *           provide this when a key was used during the object's creation.
     *           If provided one must also include an `encryptionKey`.
     * }
     * @return StreamInterface
     */
    public function downloadAsStream(array $options = [])
    {
        return $this->connection->downloadObject(
            $this->formatEncryptionHeaders(
                $options
                + $this->encryptionData
                + $this->identity
            )
        );
    }

    /**
     * Retrieves the object's details. If no object data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $object->info();
     * echo $info['size'];
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $encryptionKey An AES-256 customer-supplied encryption
     *           key. It will be neccesary to provide this when a key was used
     *           during the object's creation in order to retrieve the MD5 hash
     *           and CRC32C checksum. If provided one must also include an
     *           `encryptionKeySHA256`.
     *     @type string $encryptionKeySHA256 The SHA256 hash of the
     *           customer-supplied encryption key. It will be neccesary to
     *           provide this when a key was used during the object's creation
     *           in order to retrieve the MD5 hash and CRC32C checksum. If
     *           provided one must also include an `encryptionKey`.
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
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Triggers a network request to reload the object's details.
     *
     * Example:
     * ```
     * $object->reload();
     * $info = $object->info();
     * echo $info['location'];
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $encryptionKey A base64 encoded AES-256 customer-supplied
     *           encryption key. It will be neccesary to provide this when a key
     *           was used during the object's creation.
     *     @type string $encryptionKeySHA256 Base64 encoded SHA256 hash of the
     *           customer-supplied encryption key. This value will be calculated
     *           from the `encryptionKey` on your behalf if not provided, but
     *           for best performance it is recommended to pass in a cached
     *           version of the already calculated SHA.
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
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getObject(
            $this->formatEncryptionHeaders(
                $options
                + $this->encryptionData
                + $this->identity
            )
        );
    }

    /**
     * Retrieves the object's name.
     *
     * Example:
     * ```
     * echo $object->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->identity['object'];
    }

    /**
     * Retrieves the object's identity.
     *
     * Example:
     * ```
     * echo $object->identity()['object'];
     * ```
     *
     * @return string
     */
    public function identity()
    {
        return $this->identity;
    }

    /**
     * Formats the object as a string in the following format:
     * `gs://{bucket-name}/{object-name}`.
     *
     * Example:
     * ```
     * echo $object->gcsUri();
     * ```
     *
     * @return string
     */
    public function gcsUri()
    {
        return sprintf(
            'gs://%s/%s',
            $this->identity['bucket'],
            $this->identity['object']
        );
    }

    /**
     * Formats a destination based request, such as copy or rewrite.
     *
     * @param string|Bucket $destination The destination bucket.
     * @param array $options Options to configure.
     * @return array
     */
    private function formatDestinationRequest($destination, array $options)
    {
        if (!is_string($destination) && !($destination instanceof Bucket)) {
            throw new \InvalidArgumentException(
                '$destination must be either a string or an instance of Bucket.'
            );
        }

        $destAcl = isset($options['predefinedAcl']) ? $options['predefinedAcl'] : null;
        $destObject = isset($options['name']) ? $options['name'] : $this->identity['object'];

        unset($options['name']);
        unset($options['predefinedAcl']);

        return array_filter([
            'destinationBucket' => $destination instanceof Bucket ? $destination->name() : $destination,
            'destinationObject' => $destObject,
            'destinationPredefinedAcl' => $destAcl,
            'sourceBucket' => $this->identity['bucket'],
            'sourceObject' => $this->identity['object'],
            'sourceGeneration' => $this->identity['generation']
        ]) + $this->formatEncryptionHeaders($options + $this->encryptionData);
    }
}
