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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
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
 * ```
 */
class StorageObject
{
    use ArrayTrait;
    use EncryptionTrait;

    /**
     * @deprecated
     */
    const DEFAULT_DOWNLOAD_URL = SigningHelper::DEFAULT_DOWNLOAD_HOST;

    /**
     * @var Acl ACL for the object.
     */
    private $acl;

    /**
     * @var ConnectionInterface Represents a connection to Cloud Storage.
     * @internal
     */
    protected $connection;

    /**
     * @var array|null The object's encryption data.
     */
    private $encryptionData;

    /**
     * @var array The object's identity.
     */
    private $identity;

    /**
     * @var array|null The object's metadata.
     */
    private $info;

    /**
     * @param ConnectionInterface $connection Represents a connection to Cloud
     *        Storage. This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
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
        array $info = [],
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
            'generation' => $generation,
            'userProject' => $this->pluck('requesterProjectId', $info, false)
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
     *     echo 'Object exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->connection->getObject($this->identity + $options + ['fields' => 'name']);
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
        $this->connection->deleteObject($options + array_filter($this->identity));
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

        return $this->info = $this->connection->patchObject($options + array_filter($this->identity));
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
        $key = $options['encryptionKey'] ?? null;
        $keySHA256 = $options['encryptionKeySHA256'] ?? null;

        $response = $this->connection->copyObject(
            $this->formatDestinationRequest($destination, $options)
        );

        return new StorageObject(
            $this->connection,
            $response['name'],
            $response['bucket'],
            $response['generation'],
            $response + ['requesterProjectId' => $this->identity['userProject']],
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
     *     @type string $destinationKmsKeyName Name of the Cloud KMS key that
     *           will be used to encrypt the object. Should be in the format
     *           `projects/my-project/locations/kr-location/keyRings/my-kr/cryptoKeys/my-key`.
     *           Please note the KMS key ring must use the same location as the
     *           destination bucket.
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
        $destinationKey = $options['destinationEncryptionKey'] ?? null;
        $destinationKeySHA256 = $options['destinationEncryptionKeySHA256'] ?? null;

        $options = $this->formatDestinationRequest($destination, $options);

        do {
            $response = $this->connection->rewriteObject($options);
            $options['rewriteToken'] = $response['rewriteToken'] ?? null;
        } while ($options['rewriteToken']);

        return new StorageObject(
            $this->connection,
            $response['resource']['name'],
            $response['resource']['bucket'],
            $response['resource']['generation'],
            $response['resource'] + ['requesterProjectId' => $this->identity['userProject']],
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
        $destinationBucket = $options['destinationBucket'] ?? $this->identity['bucket'];
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
     * For an example of setting the range header to download a subrange of the
     * object please see {@see StorageObject::downloadAsStream()}.
     *
     * Example:
     * ```
     * $string = $object->downloadAsString();
     * echo $string;
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     * @see https://cloud.google.com/storage/docs/json_api/v1/parameters#range Learn more about the Range header.
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
     * For an example of setting the range header to download a subrange of the
     * object please see {@see StorageObject::downloadAsStream()}.
     *
     * Example:
     * ```
     * $stream = $object->downloadToFile(__DIR__ . '/my-file.txt');
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     * @see https://cloud.google.com/storage/docs/json_api/v1/parameters#range Learn more about the Range header.
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
        $source = $this->downloadAsStream($options);
        $destination = Utils::streamFor(fopen($path, 'w'));

        Utils::copyToStream(
            $source,
            $destination
        );

        $destination->seek(0);

        return $destination;
    }

    /**
     * Download an object as a stream. The library will attempt to resume the download
     * if a retry-able error is thrown. An attempt to fetch the remaining file will
     * be made only if the user has not supplied a custom retry
     * function of their own.
     *
     * Please note Google Cloud Storage respects the Range header as specified
     * by [RFC7233](https://tools.ietf.org/html/rfc7233#section-3.1). See below
     * for an example of this in action.
     *
     * Example:
     * ```
     * $stream = $object->downloadAsStream();
     * echo $stream->getContents();
     * ```
     *
     * ```
     * // Set the Range header in order to download a subrange of the object. For more examples of
     * // setting the Range header, please see [RFC7233](https://tools.ietf.org/html/rfc7233#section-3.1).
     * $firstFiveBytes = '0-4'; // Get the first 5 bytes.
     * $fromFifthByteToLastByte = '4-'; // Get the bytes starting with the 5th to the last.
     * $lastFiveBytes = '-5'; // Get the last 5 bytes.
     *
     * $stream = $object->downloadAsStream([
     *     'restOptions' => [
     *         'headers' => [
     *             'Range' => "bytes=$firstFiveBytes"
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     * @see https://cloud.google.com/storage/docs/json_api/v1/parameters#range Learn more about the Range header.
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
                + array_filter($this->identity)
            )
        );
    }

    /**
     * Asynchronously download an object as a stream.
     *
     * For an example of setting the range header to download a subrange of the
     * object please see {@see StorageObject::downloadAsStream()}.
     *
     * Example:
     * ```
     * use Psr\Http\Message\StreamInterface;
     *
     * $promise = $object->downloadAsStreamAsync()
     *     ->then(function (StreamInterface $data) {
     *         echo $data->getContents();
     *     });
     *
     * $promise->wait();
     * ```
     *
     * ```
     * // Download all objects in a bucket asynchronously.
     * use GuzzleHttp\Promise\Utils;
     * use Psr\Http\Message\StreamInterface;
     *
     * $promises = [];
     *
     * foreach ($bucket->objects() as $object) {
     *     $promises[] = $object->downloadAsStreamAsync()
     *         ->then(function (StreamInterface $data) {
     *             echo $data->getContents();
     *         });
     * }
     *
     * Utils::unwrap($promises);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/objects/get Objects get API documentation.
     * @see https://cloud.google.com/storage/docs/json_api/v1/parameters#range Learn more about the Range header.
     * @see https://github.com/guzzle/promises Learn more about Guzzle Promises
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
     * @return PromiseInterface<StreamInterface>
     * @experimental The experimental flag means that while we believe this method
     *      or class is ready for use, it may change before release in backwards-
     *      incompatible ways. Please use with caution, and test thoroughly when
     *      upgrading.
     */
    public function downloadAsStreamAsync(array $options = [])
    {
        return $this->connection->downloadObjectAsync(
            $this->formatEncryptionHeaders(
                $options
                + $this->encryptionData
                + array_filter($this->identity)
            )
        );
    }

    /**
     * Create a Signed URL for this object.
     *
     * Signed URLs can be complex, and it is strongly recommended you read and
     * understand the [documentation](https://cloud.google.com/storage/docs/access-control/signed-urls).
     *
     * In cases where a keyfile is available, signing is accomplished in the
     * client using your Service Account private key. In Google Compute Engine,
     * signing is accomplished using
     * [IAM signBlob](https://cloud.google.com/iam/credentials/reference/rest/v1/projects.serviceAccounts/signBlob).
     * Signing using IAM requires that your service account be granted the
     * `iam.serviceAccounts.signBlob` permission, part of the "Service Account
     * Token Creator" IAM role.
     *
     * Additionally, signing using IAM requires different scopes. When creating
     * an instance of {@see StorageClient}, provide the
     * `https://www.googleapis.com/auth/cloud-platform` scopein `$options.scopes`.
     * This scope may be used entirely in place of the scopes provided in
     * {@see StorageClient}.
     *
     * App Engine and Compute Engine will attempt to sign URLs using IAM.
     *
     * Example:
     * ```
     * $url = $object->signedUrl(new \DateTime('tomorrow'));
     * ```
     *
     * ```
     * // Create a signed URL allowing updates to the object.
     * $url = $object->signedUrl(new \DateTime('tomorrow'), [
     *     'method' => 'PUT'
     * ]);
     * ```
     *
     * ```
     * // Use Signed URLs v4
     * $url = $object->signedUrl(new \DateTime('tomorrow'), [
     *     'version' => 'v4'
     * ]);
     * ```
     *
     * ```
     * // Using Bucket-Bound hostnames
     * // By default, a custom bucket-bound hostname will use `http` as the schema rather than `https`.
     * // In order to get an https URI, we need to specify the proper scheme.
     * $url = $object->signedUrl(new \DateTime('tomorrow'), [
     *     'version' => 'v4',
     *     'bucketBoundHostname' => 'cdn.example.com',
     *     'scheme' => 'https'
     * ]);
     * ```
     *
     * ```
     * // Using virtual hosted style URIs
     * // When true, returns a URL with the hostname `<bucket>.storage.googleapis.com`.
     * $url = $object->signedUrl(new \DateTime('tomorrow'), [
     *     'virtualHostedStyle' => true
     * ]);
     * ````
     *
     * @see https://cloud.google.com/storage/docs/access-control/signed-urls Signed URLs
     *
     * @param Timestamp|\DateTimeInterface|int $expires Specifies when the URL
     *        will expire. May provide an instance of {@see \Google\Cloud\Core\Timestamp},
     *        [http://php.net/datetimeimmutable](`\DateTimeImmutable`), or a
     *        UNIX timestamp as an integer.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $bucketBoundHostname The hostname for the bucket, for
     *           instance `cdn.example.com`. May be used for Google Cloud Load
     *           Balancers or for custom bucket CNAMEs. **Defaults to**
     *           `storage.googleapis.com`.
     *     @type string $contentMd5 The MD5 digest value in base64. If you
     *           provide this, the client must provide this HTTP header with
     *           this same value in its request. If provided, take care to
     *           always provide this value as a base64 encoded string.
     *     @type string $contentType If you provide this value, the client must
     *           provide this HTTP header set to the same value.
     *     @type bool $forceOpenssl If true, OpenSSL will be used regardless of
     *           whether phpseclib is available. **Defaults to** `false`.
     *     @type array $headers If additional headers are provided, the server
     *           will check to make sure that the client provides matching
     *           values. Provide headers as a key/value array, where the key is
     *           the header name, and the value is an array of header values.
     *           Headers with multiple  values may provide values as a simple
     *           array, or a comma-separated string. For a reference of allowed
     *           headers, see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers).
     *           Header values will be trimmed of leading and trailing spaces,
     *           multiple spaces within values will be collapsed to a single
     *           space, and line breaks will be replaced by an empty string.
     *           V2 Signed URLs may not provide `x-goog-encryption-key` or
     *           `x-goog-encryption-key-sha256` headers.
     *     @type array $keyFile Keyfile data to use in place of the keyfile with
     *           which the client was constructed. If `$options.keyFilePath` is
     *           set, this option is ignored.
     *     @type string $keyFilePath A path to a valid Keyfile to use in place
     *           of the keyfile with which the client was constructed.
     *     @type string $method One of `GET`, `PUT` or `DELETE`.
     *           **Defaults to** `GET`.
     *     @type string $responseDisposition The
     *           [`response-content-disposition`](http://www.iana.org/assignments/cont-disp/cont-disp.xhtml)
     *           parameter of the signed url.
     *     @type string $responseType The `response-content-type` parameter of the
     *           signed url. When the server contentType is `null`, this option
     *           may be used to control the content type of the response.
     *     @type string $saveAsName The filename to prompt the user to save the
     *           file as when the signed url is accessed. This is ignored if
     *           `$options.responseDisposition` is set.
     *     @type string $scheme Either `http` or `https`. Only used if a custom
     *           hostname is provided via `$options.bucketBoundHostname`. If a
     *           custom bucketBoundHostname is provided, **defaults to** `http`.
     *           In all other cases, **defaults to** `https`.
     *     @type string|array $scopes One or more authentication scopes to be
     *           used with a key file. This option is ignored unless
     *           `$options.keyFile` or `$options.keyFilePath` is set.
     *     @type array $queryParams Additional query parameters to be included
     *           as part of the signed URL query string. For allowed values,
     *           see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers#query).
     *     @type string $version One of "v2" or "v4". **Defaults to** `"v2"`.
     *     @type bool $virtualHostedStyle If `true`, URL will be of form
     *           `mybucket.storage.googleapis.com`. If `false`,
     *           `storage.googleapis.com/mybucket`. **Defaults to** `false`.
     * }
     * @return string
     * @throws \InvalidArgumentException If the given expiration is invalid or in the past.
     * @throws \InvalidArgumentException If the given `$options.method` is not valid.
     * @throws \InvalidArgumentException If the given `$options.keyFilePath` is not valid.
     * @throws \InvalidArgumentException If the given custom headers are invalid.
     * @throws \InvalidArgumentException If the keyfile does not contain the required information.
     * @throws \RuntimeException If the credentials provided cannot be used for signing strings.
     */
    public function signedUrl($expires, array $options = [])
    {
        // May be overridden for testing.
        $signingHelper = $this->pluck('helper', $options, false)
            ?: SigningHelper::getHelper();

        $resource = sprintf(
            '/%s/%s',
            $this->identity['bucket'],
            $this->identity['object']
        );

        return $signingHelper->sign(
            $this->connection,
            $expires,
            $resource,
            $this->identity['generation'],
            $options
        );
    }

    /**
     * Create a Signed Upload URL for this object.
     *
     * This method differs from {@see StorageObject::signedUrl()}
     * in that it allows you to initiate a new resumable upload session. This
     * can be used to allow non-authenticated users to insert an object into a
     * bucket.
     *
     * In order to upload data, a session URI must be
     * obtained by sending an HTTP POST request to the URL returned from this
     * method. See the [Cloud Storage Documentation](https://goo.gl/b1ZiZm) for
     * more information.
     *
     * If you prefer to skip this initial step, you may find
     * {@see StorageObject::beginSignedUploadSession()} to
     * fit your needs. Note that `beginSignedUploadSession()` cannot be used
     * with Google Cloud PHP's Signed URL Uploader, and does not support a
     * configurable expiration date.
     *
     * Example:
     * ```
     * $url = $object->signedUploadUrl(new \DateTime('tomorrow'));
     * ```
     *
     * ```
     * // Use Signed URLs v4
     * $url = $object->signedUploadUrl(new \DateTime('tomorrow'), [
     *     'version' => 'v4'
     * ]);
     * ```
     *
     * @param Timestamp|\DateTimeInterface|int $expires Specifies when the URL
     *        will expire. May provide an instance of {@see \Google\Cloud\Core\Timestamp},
     *        [http://php.net/datetimeimmutable](`\DateTimeImmutable`), or a
     *        UNIX timestamp as an integer.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $contentMd5 The MD5 digest value in base64. If you
     *           provide this, the client must provide this HTTP header with
     *           this same value in its request. If provided, take care to
     *           always provide this value as a base64 encoded string.
     *     @type string $contentType If you provide this value, the client must
     *           provide this HTTP header set to the same value.
     *     @type bool $forceOpenssl If true, OpenSSL will be used regardless of
     *           whether phpseclib is available. **Defaults to** `false`.
     *     @type array $headers If additional headers are provided, the server
     *           will check to make sure that the client provides matching
     *           values. Provide headers as a key/value array, where the key is
     *           the header name, and the value is an array of header values.
     *           Headers with multiple  values may provide values as a simple
     *           array, or a comma-separated string. For a reference of allowed
     *           headers, see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers).
     *           Header values will be trimmed of leading and trailing spaces,
     *           multiple spaces within values will be collapsed to a single
     *           space, and line breaks will be replaced by an empty string.
     *           V2 Signed URLs may not provide `x-goog-encryption-key` or
     *           `x-goog-encryption-key-sha256` headers.
     *     @type array $keyFile Keyfile data to use in place of the keyfile with
     *           which the client was constructed. If `$options.keyFilePath` is
     *           set, this option is ignored.
     *     @type string $keyFilePath A path to a valid Keyfile to use in place
     *           of the keyfile with which the client was constructed.
     *     @type string $responseDisposition The
     *           [`response-content-disposition`](http://www.iana.org/assignments/cont-disp/cont-disp.xhtml)
     *           parameter of the signed url.
     *     @type string $responseType The `response-content-type` parameter of the
     *           signed url. When the server contentType is `null`, this option
     *           may be used to control the content type of the response.
     *     @type string $saveAsName The filename to prompt the user to save the
     *           file as when the signed url is accessed. This is ignored if
     *           `$options.responseDisposition` is set.
     *     @type string $scheme Either `http` or `https`. Only used if a custom
     *           hostname is provided via `$options.bucketBoundHostname`. In all
     *           other cases, `https` is used. When a custom bucketBoundHostname
     *           is provided, **defaults to** `http`.
     *     @type string|array $scopes One or more authentication scopes to be
     *           used with a key file. This option is ignored unless
     *           `$options.keyFile` or `$options.keyFilePath` is set.
     *     @type array $queryParams Additional query parameters to be included
     *           as part of the signed URL query string. For allowed values,
     *           see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers#query).
     *     @type string $version One of "v2" or "v4". **Defaults to** `"v2"`.
     * }
     * @return string
     */
    public function signedUploadUrl($expires, array $options = [])
    {
        $options += [
            'headers' => []
        ];

        $options['headers']['x-goog-resumable'] = 'start';

        unset(
            $options['cname'],
            $options['bucketBoundHostname'],
            $options['saveAsName'],
            $options['responseDisposition'],
            $options['responseType'],
            $options['virtualHostedStyle']
        );

        return $this->signedUrl($expires, [
            'method' => 'POST',
            'allowPost' => true
        ] + $options);
    }

    /**
     * Create a signed URL upload session.
     *
     * The returned URL differs from the return value of
     * {@see StorageObject::signedUploadUrl()} in that it
     * is ready to accept upload data immediately via an HTTP PUT request.
     *
     * Because an upload session is created by the client, the expiration date
     * is not configurable. The URL generated by this method is valid for one
     * week.
     *
     * Example:
     * ```
     * $url = $object->beginSignedUploadSession();
     * ```
     *
     * ```
     * // Use Signed URLs v4
     * $url = $object->beginSignedUploadSession([
     *     'version' => 'v4'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/storage/docs/xml-api/resumable-upload#practices Resumable Upload Best Practices
     *
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $contentMd5 The MD5 digest value in base64. If you
     *           provide this, the client must provide this HTTP header with
     *           this same value in its request. If provided, take care to
     *           always provide this value as a base64 encoded string.
     *     @type string $contentType If you provide this value, the client must
     *           provide this HTTP header set to the same value.
     *     @type bool $forceOpenssl If true, OpenSSL will be used regardless of
     *           whether phpseclib is available. **Defaults to** `false`.
     *     @type array $headers If additional headers are provided, the server
     *           will check to make sure that the client provides matching
     *           values. Provide headers as a key/value array, where the key is
     *           the header name, and the value is an array of header values.
     *           Headers with multiple  values may provide values as a simple
     *           array, or a comma-separated string. For a reference of allowed
     *           headers, see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers).
     *           Header values will be trimmed of leading and trailing spaces,
     *           multiple spaces within values will be collapsed to a single
     *           space, and line breaks will be replaced by an empty string.
     *           V2 Signed URLs may not provide `x-goog-encryption-key` or
     *           `x-goog-encryption-key-sha256` headers.
     *     @type array $keyFile Keyfile data to use in place of the keyfile with
     *           which the client was constructed. If `$options.keyFilePath` is
     *           set, this option is ignored.
     *     @type string $keyFilePath A path to a valid Keyfile to use in place
     *           of the keyfile with which the client was constructed.
     *     @type string $origin Value of CORS header
     *           "Access-Control-Allow-Origin". **Defaults to** `"*"`.
     *     @type string|array $scopes One or more authentication scopes to be
     *           used with a key file. This option is ignored unless
     *           `$options.keyFile` or `$options.keyFilePath` is set.
     *     @type array $queryParams Additional query parameters to be included
     *           as part of the signed URL query string. For allowed values,
     *           see [Reference Headers](https://cloud.google.com/storage/docs/xml-api/reference-headers#query).
     *     @type string $version One of "v2" or "v4". **Defaults to** `"v2"`.
     * }
     * @return string
     */
    public function beginSignedUploadSession(array $options = [])
    {
        $expires = new \DateTimeImmutable('+1 minute');
        $startUri = $this->signedUploadUrl($expires, $options);

        $uploaderOptions = $this->pluckArray([
            'contentType',
            'origin'
        ], $options);

        if (!isset($uploaderOptions['origin'])) {
            $uploaderOptions['origin'] = '*';
        }

        $uploader = new SignedUrlUploader($this->connection->requestWrapper(), '', $startUri, $uploaderOptions);

        return $uploader->getResumeUri();
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
        return $this->info ?: $this->reload($options);
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
                + array_filter($this->identity)
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
     * @return array
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

        $destAcl = $options['predefinedAcl'] ?? null;
        $destObject = $options['name'] ?? $this->identity['object'];

        unset($options['name']);
        unset($options['predefinedAcl']);

        return array_filter([
            'destinationBucket' => $destination instanceof Bucket ? $destination->name() : $destination,
            'destinationObject' => $destObject,
            'destinationPredefinedAcl' => $destAcl,
            'sourceBucket' => $this->identity['bucket'],
            'sourceObject' => $this->identity['object'],
            'sourceGeneration' => $this->identity['generation'],
            'userProject' => $this->identity['userProject'],
        ]) + $this->formatEncryptionHeaders($options + $this->encryptionData);
    }
}
