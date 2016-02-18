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

use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\Object;

class Bucket
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var array
     */
    private $identity;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Acl
     */
    private $acl;

    /**
     * @var Acl
     */
    private $defaultAcl;

    /**
     * @param ConnectionInterface $connection
     * @param string $name
     * @param array $data
     */
    public function __construct(ConnectionInterface $connection, $name, array $data = null)
    {
        $this->connection = $connection;
        $this->identity = ['bucket' => $name];
        $this->data = $data;
        $this->acl = new Acl($this->connection, 'bucketAccessControls', $this->identity);
        $this->defaultAcl = new Acl($this->connection, 'defaultObjectAccessControls', $this->identity);
    }

    /**
     * Configure ACL for this bucket.
     *
     * @return Acl
     */
    public function acl()
    {
        return $this->acl;
    }

    /**
     * Configure default object ACL for this bucket.
     *
     * @return Acl
     */
    public function defaultAcl()
    {
        return $this->defaultAcl;
    }

    /**
     * Check whether or not the bucket exists.
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
            $resp = $this->connection->getBucket($this->identity + ['fields' => 'name']);
        } catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * Upload data from a stream.
     *
     * Example:
     * ```
     * $bucket->uploadFromStream(
     *     fopen('image.jpg', 'r'),
     *     'image.jpg',
     *     ['contentType' => 'image/jpeg']
     * );
     * ```
     *
     * @param resource|StreamInterface $data
     * @param string $destination Name of where the file will be stored.
     * @param array $options Configuration options.
     * @return Object
     */
    public function uploadFromStream($data, $destination, array $options = [])
    {
        $response = $this->connection->uploadObject($options + [
            'bucket' => $this->identity['bucket'],
            'data' => $data,
            'name' => $destination
        ]);

        return new Object($this->connection, $destination, $this->identity['bucket'], null, $response);
    }

    /**
     * Upload
     *
     * Example:
     * ```
     * ```
     *
     * @param string $path Path to the file to be uploaded.
     * @param array $options Configuration options.
     * @return Object
     */
    public function uploadFromPath($path, array $options = [])
    {

    }

    /**
     * Lazily instantiates an object.
     *
     * Example:
     * ```
     * $object = $bucket->object('file.txt');
     * ```
     *
     * @param string $objectName The name of the object to request.
     * @param array $options Configuration options. {
     *     @type string $generation Request a specific revision of the object.
     * }
     * @return Object
     */
    public function object($objectName, array $options = [])
    {
        $generation = isset($options['generation']) ? $options['generation'] : null;

        return new Object($this->connection, $objectName, $this->identity['bucket'], $generation);
    }

    /**
     * Fetches all objects in the bucket.
     *
     * Example:
     * ```
     * // Get all objects beginning with the prefix 'photo'
     * $objects = $bucket->objects([
     *     'prefix' => 'photo',
     *     'fields' => 'items/name,nextPageToken'
     * ]);
     *
     * foreach ($objects as $object) {
     *     var_dump($object->getName());
     * }
     * ```
     *
     * @param array $options Configuration options. {
     *     @type string $delimiter Returns results in a directory-like mode.
     *           Results will contain only objects whose names, aside from the
     *           prefix, do not contain delimiter. Objects whose names, aside
     *           from the prefix, contain delimiter will have their name,
     *           truncated after the delimiter, returned in prefixes. Duplicate
     *           prefixes are omitted.
     *     @type integer $maxResults Maximum number of results to return per
     *           request. Defaults to 1000.
     *     @type string $prefix Filter results with this prefix.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     *     @type bool $versions If true, lists all versions of an object as
     *           distinct results. The default is false.
     *     @type string $fields Selector which will cause the response to only
     *           return the specified fields.
     * }
     * @return \Generator
     */
    public function objects(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listObjects($options + $this->identity);

            foreach ($response['items'] as $object) {
                // @todo when versions === true pass generation
                yield new Object($this->connection, $object['name'], $this->identity['bucket'], null, $object);
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }

    /**
     * @todo should this return something significant to the user?
     * Delete the bucket.
     *
     * Example:
     * ```
     * $bucket->delete();
     * ```
     *
     * @param array $options Configuration options. {
     *     @type string $ifMetagenerationMatch If set, only deletes the bucket
     *           if its metageneration matches this value.
     *     @type string $ifMetagenerationNotMatch If set, only deletes the
     *           bucket if its metageneration does not match this value.
     * }
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteBucket($options + $this->identity);
    }

    /**
     * Update the bucket. Upon receiving a result the local bucket's data will
     * be updated.
     *
     * @link https://goo.gl/KgufNr Learn more about configuring request options
     *       at the bucket patch API documentation.
     *
     * Example:
     * ```
     * // Enable logging on an existing bucket.
     * $bucket->update([
     *     'logging' => [
     *         'logBucket' => 'myBucket',
     *         'logObjectPrefix' => 'prefix'
     *     ]
     * ]);
     * ```
     *
     * @param array $options Configuration options. {
     *     @type string $ifMetagenerationMatch Makes the return of the bucket
     *           metadata conditional on whether the bucket's current
     *           metageneration matches the given value.
     *     @type string $ifMetagenerationNotMatch Makes the return of the bucket
     *           metadata conditional on whether the bucket's current
     *           metageneration does not match the given value.
     *     @type string $predefinedAcl Apply a predefined set of access controls
     *           to this bucket.
     *     @type string $predefinedDefaultObjectAcl Apply a predefined set of
     *           default object access controls to this bucket.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     *     @type string $fields Selector which will cause the response to only
     *           return the specified fields.
     *     @type array $acl Access controls on the bucket.
     *     @type array $cors The bucket's Cross-Origin Resource Sharing (CORS)
     *           configuration.
     *     @type array $defaultObjectAcl Default access controls to apply to new
     *           objects when no ACL is provided.
     *     @type array $lifecycle The bucket's lifecycle configuration.
     *     @type array $logging The bucket's logging configuration, which
     *           defines the destination bucket and optional name prefix for the
     *           current bucket's logs.
     *     @type array $versioning The bucket's versioning configuration.
     *     @type array $website The bucket's website configuration.
     * }
     * @return array
     */
    public function update(array $options = [])
    {
        $this->data = $this->connection->patchBucket($options + $this->identity);

        return $this->data;
    }

    /**
     * Retrieves the bucket's details.
     *
     * Example:
     * ```
     * $info = $bucket->getInfo();
     * var_dump($info['location']);
     * ```
     *
     * @param array $options Configuration options. {
     *     @type bool $force If true fetches fresh data, otherwise returns data
     *           stored locally if it exists.
     *     @type string $ifMetagenerationMatch Makes the return of the bucket
     *           metadata conditional on whether the bucket's current
     *           metageneration matches the given value.
     *     @type string $ifMetagenerationNotMatch Makes the return of the bucket
     *           metadata conditional on whether the bucket's current
     *           metageneration does not match the given value.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     * }
     * @return array
     */
    public function getInfo(array $options = [])
    {
        if (!$this->data || isset($options['force'])) {
            $this->data = $this->connection->getBucket($options + $this->identity);
        }

        return $this->data;
    }

    /**
     * Retrieves the bucket's name.
     *
     * Example:
     * ```
     * var_dump($bucket->getName());
     * ```
     *
     * @return string
     */
    public function getName()
    {
        return $this->identity['bucket'];
    }
}
