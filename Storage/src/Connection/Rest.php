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

namespace Google\Cloud\Storage\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageClient;
use Google\CRC32\Builtin;
use Google\CRC32\CRC32;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Implementation of the
 * [Google Cloud Storage JSON API](https://cloud.google.com/storage/docs/json_api/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    /**
     * @deprecated
     */
    const BASE_URI = 'https://storage.googleapis.com/storage/v1/';

    const DEFAULT_API_ENDPOINT = 'https://storage.googleapis.com';

    /**
     * @deprecated
     */
    const UPLOAD_URI = 'https://storage.googleapis.com/upload/storage/v1/b/{bucket}/o{?query*}';

    const UPLOAD_PATH = 'upload/storage/v1/b/{bucket}/o{?query*}';

    /**
     * @deprecated
     */
    const DOWNLOAD_URI = 'https://storage.googleapis.com/storage/v1/b/{bucket}/o/{object}{?query*}';

    const DOWNLOAD_PATH = 'storage/v1/b/{bucket}/o/{object}{?query*}';

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $apiEndpoint;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/storage-v1.json',
            'componentVersion' => StorageClient::VERSION,
            'apiEndpoint' => self::DEFAULT_API_ENDPOINT
        ];

        $this->apiEndpoint = $this->getApiEndpoint(self::DEFAULT_API_ENDPOINT, $config);

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->apiEndpoint
        ));

        $this->projectId = $this->pluck('projectId', $config, false);
    }

    /**
     * @return string
     */
    public function projectId()
    {
        return $this->projectId;
    }

    /**
     * @param array $args
     */
    public function deleteAcl(array $args = [])
    {
        return $this->send($args['type'], 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getAcl(array $args = [])
    {
        return $this->send($args['type'], 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listAcl(array $args = [])
    {
        return $this->send($args['type'], 'list', $args);
    }

    /**
     * @param array $args
     */
    public function insertAcl(array $args = [])
    {
        return $this->send($args['type'], 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function patchAcl(array $args = [])
    {
        return $this->send($args['type'], 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function deleteBucket(array $args = [])
    {
        return $this->send('buckets', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getBucket(array $args = [])
    {
        return $this->send('buckets', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listBuckets(array $args = [])
    {
        return $this->send('buckets', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function insertBucket(array $args = [])
    {
        return $this->send('buckets', 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function patchBucket(array $args = [])
    {
        return $this->send('buckets', 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function deleteObject(array $args = [])
    {
        return $this->send('objects', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function copyObject(array $args = [])
    {
        return $this->send('objects', 'copy', $args);
    }

    /**
     * @param array $args
     */
    public function rewriteObject(array $args = [])
    {
        return $this->send('objects', 'rewrite', $args);
    }

    /**
     * @param array $args
     */
    public function composeObject(array $args = [])
    {
        return $this->send('objects', 'compose', $args);
    }

    /**
     * @param array $args
     */
    public function getObject(array $args = [])
    {
        return $this->send('objects', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listObjects(array $args = [])
    {
        return $this->send('objects', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function patchObject(array $args = [])
    {
        return $this->send('objects', 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function downloadObject(array $args = [])
    {
        list($request, $requestOptions) = $this->buildDownloadObjectParams($args);

        return $this->requestWrapper->send(
            $request,
            $requestOptions
        )->getBody();
    }

    /**
     * @param array $args
     * @experimental The experimental flag means that while we believe this method
     *      or class is ready for use, it may change before release in backwards-
     *      incompatible ways. Please use with caution, and test thoroughly when
     *      upgrading.
     */
    public function downloadObjectAsync(array $args = [])
    {
        list($request, $requestOptions) = $this->buildDownloadObjectParams($args);

        return $this->requestWrapper->sendAsync(
            $request,
            $requestOptions
        )->then(function (ResponseInterface $response) {
            return $response->getBody();
        });
    }

    /**
     * @param array $args
     */
    public function insertObject(array $args = [])
    {
        $args = $this->resolveUploadOptions($args);

        $uploadType = AbstractUploader::UPLOAD_TYPE_RESUMABLE;
        if ($args['streamable']) {
            $uploaderClass = StreamableUploader::class;
        } elseif ($args['resumable']) {
            $uploaderClass = ResumableUploader::class;
        } else {
            $uploaderClass = MultipartUploader::class;
            $uploadType = AbstractUploader::UPLOAD_TYPE_MULTIPART;
        }

        $uriParams = [
            'bucket' => $args['bucket'],
            'query' => [
                'predefinedAcl' => $args['predefinedAcl'],
                'uploadType' => $uploadType,
                'userProject' => $args['userProject']
            ]
        ];

        return new $uploaderClass(
            $this->requestWrapper,
            $args['data'],
            $this->expandUri($this->apiEndpoint . self::UPLOAD_PATH, $uriParams),
            $args['uploaderOptions']
        );
    }

    /**
     * @param array $args
     */
    private function resolveUploadOptions(array $args)
    {
        $args += [
            'bucket' => null,
            'name' => null,
            'validate' => true,
            'resumable' => null,
            'streamable' => null,
            'predefinedAcl' => null,
            'metadata' => [],
            'userProject' => null,
        ];

        $args['data'] = Psr7\stream_for($args['data']);

        if ($args['resumable'] === null) {
            $args['resumable'] = $args['data']->getSize() > AbstractUploader::RESUMABLE_LIMIT;
        }

        if (!$args['name']) {
            $args['name'] = basename($args['data']->getMetadata('uri'));
        }

        $validate = $this->chooseValidationMethod($args);
        if ($validate === 'md5') {
            $args['metadata']['md5Hash'] = base64_encode(Psr7\hash($args['data'], 'md5', true));
        } elseif ($validate === 'crc32') {
            $args['metadata']['crc32c'] = $this->crcFromStream($args['data']);
        }

        $args['metadata']['name'] = $args['name'];
        unset($args['name']);
        $args['contentType'] = isset($args['metadata']['contentType'])
            ? $args['metadata']['contentType']
            : Psr7\mimetype_from_filename($args['metadata']['name']);

        $uploaderOptionKeys = [
            'restOptions',
            'retries',
            'requestTimeout',
            'chunkSize',
            'contentType',
            'metadata',
            'uploadProgressCallback'
        ];

        $args['uploaderOptions'] = array_intersect_key($args, array_flip($uploaderOptionKeys));
        $args = array_diff_key($args, array_flip($uploaderOptionKeys));

        return $args;
    }

    /**
     * @param  array $args
     */
    public function getBucketIamPolicy(array $args)
    {
        return $this->send('buckets', 'getIamPolicy', $args);
    }

    /**
     * @param  array $args
     */
    public function setBucketIamPolicy(array $args)
    {
        return $this->send('buckets', 'setIamPolicy', $args);
    }

    /**
     * @param  array $args
     */
    public function testBucketIamPermissions(array $args)
    {
        return $this->send('buckets', 'testIamPermissions', $args);
    }

    /**
     * @param array $args
     */
    public function getNotification(array $args = [])
    {
        return $this->send('notifications', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function deleteNotification(array $args = [])
    {
        return $this->send('notifications', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function insertNotification(array $args = [])
    {
        return $this->send('notifications', 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function listNotifications(array $args = [])
    {
        return $this->send('notifications', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function getServiceAccount(array $args = [])
    {
        return $this->send('projects.resources.serviceAccount', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function lockRetentionPolicy(array $args = [])
    {
        return $this->send('buckets', 'lockRetentionPolicy', $args);
    }

    /**
     * @param array $args
     */
    public function createHmacKey(array $args = [])
    {
        return $this->send('projects.resources.hmacKeys', 'create', $args);
    }

    /**
     * @param array $args
     */
    public function deleteHmacKey(array $args = [])
    {
        return $this->send('projects.resources.hmacKeys', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getHmacKey(array $args = [])
    {
        return $this->send('projects.resources.hmacKeys', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function updateHmacKey(array $args = [])
    {
        return $this->send('projects.resources.hmacKeys', 'update', $args);
    }

    /**
     * @param array $args
     */
    public function listHmacKeys(array $args = [])
    {
        return $this->send('projects.resources.hmacKeys', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    private function buildDownloadObjectParams(array $args)
    {
        $args += [
            'bucket' => null,
            'object' => null,
            'generation' => null,
            'userProject' => null
        ];

        $requestOptions = array_intersect_key($args, [
            'restOptions' => null,
            'retries' => null,
            'restRetryFunction' => null,
            'restCalcDelayFunction' => null,
            'restDelayFunction' => null
        ]);

        $uri = $this->expandUri($this->apiEndpoint . self::DOWNLOAD_PATH, [
            'bucket' => $args['bucket'],
            'object' => $args['object'],
            'query' => [
                'generation' => $args['generation'],
                'alt' => 'media',
                'userProject' => $args['userProject']
            ]
        ]);

        return [
            new Request('GET', Psr7\uri_for($uri)),
            $requestOptions
        ];
    }

    /**
     * Choose a upload validation method based on user input and platform
     * requirements.
     *
     * @param array $args
     * @return bool|string
     */
    private function chooseValidationMethod(array $args)
    {
        // If the user provided a hash, skip hashing.
        if (isset($args['metadata']['md5Hash']) || isset($args['metadata']['crc32c'])) {
            return false;
        }

        $validate = $args['validate'];
        if (in_array($validate, [false, 'crc32', 'md5'], true)) {
            return $validate;
        }

        // not documented, but the feature is called crc32c, so let's accept that as input anyways.
        if ($validate === 'crc32c') {
            return 'crc32';
        }

        // is the extension loaded?
        if ($this->crc32cExtensionLoaded()) {
            return 'crc32';
        }

        // is crc32c available in `hash()`?
        if ($this->supportsBuiltinCrc32c()) {
            return 'crc32';
        }

        return 'md5';
    }

    /**
     * Generate a CRC32c checksum from a stream.
     *
     * @param StreamInterface $data
     * @return string
     */
    private function crcFromStream(StreamInterface $data)
    {
        $pos = $data->tell();

        if ($pos > 0) {
            $data->rewind();
        }

        $crc32c = CRC32::create(CRC32::CASTAGNOLI);

        $data->rewind();
        while (!$data->eof()) {
            $crc32c->update($data->read(1048576));
        }

        $data->seek($pos);

        return base64_encode($crc32c->hash(true));
    }

    /**
     * Check if the crc32c extension is available.
     *
     * Protected access for unit testing.
     *
     * @return bool
     */
    protected function crc32cExtensionLoaded()
    {
        return extension_loaded('crc32c');
    }

    /**
     * Check if hash() supports crc32c.
     *
     * Protected access for unit testing.
     *
     * @return bool
     */
    protected function supportsBuiltinCrc32c()
    {
        return Builtin::supports(CRC32::CASTAGNOLI);
    }
}
