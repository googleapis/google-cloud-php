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

use Google\Auth\GetUniverseDomainInterface;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\Retry;
use Google\Cloud\Storage\Connection\RetryTrait;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MimeType;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Ramsey\Uuid\Uuid;

/**
 * Implementation of the
 * [Google Cloud Storage JSON API](https://cloud.google.com/storage/docs/json_api/).
 *
 * @internal
 */
class Rest implements ConnectionInterface
{
    use RestTrait {
        send as private traitSend;
    }
    use RetryTrait;
    use UriTrait;

    /**
     * Header and value that helps us identify a transcoded obj
     * w/o making a metadata(info) call.
     */
    private const TRANSCODED_OBJ_HEADER_KEY = 'X-Goog-Stored-Content-Encoding';
    private const TRANSCODED_OBJ_HEADER_VAL = 'gzip';

    /**
     * @deprecated
     */
    const BASE_URI = 'https://storage.googleapis.com/storage/v1/';

    /**
     * @deprecated
     */
    const DEFAULT_API_ENDPOINT = 'https://storage.googleapis.com';

    const DEFAULT_API_ENDPOINT_TEMPLATE = 'https://storage.UNIVERSE_DOMAIN';

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
     * @var callable
     * value null accepted
     */
    private $restRetryFunction;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/storage-v1.json',
            'componentVersion' => StorageClient::VERSION,
            'apiEndpoint' => null,
            // If the user has not supplied a universe domain, use the environment variable if set.
            // Otherwise, use the default ("googleapis.com").
            'universeDomain' => getenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN')
                ?: GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN,
            // Cloud Storage needs to provide a default scope because the Storage
            // API does not accept JWTs with "audience"
            'scopes' => StorageClient::FULL_CONTROL_SCOPE,
        ];

        $this->apiEndpoint = $this->getApiEndpoint(null, $config, self::DEFAULT_API_ENDPOINT_TEMPLATE);

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->apiEndpoint
        ));

        $this->projectId = $this->pluck('projectId', $config, false);
        $this->restRetryFunction = (isset($config['restRetryFunction'])) ? $config['restRetryFunction'] : null;
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
    public function restoreObject(array $args = [])
    {
        return $this->send('objects', 'restore', $args);
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
        // This makes sure we honour the range headers specified by the user
        $requestedBytes = $this->getRequestedBytes($args);
        $resultStream = Utils::streamFor(null);
        $transcodedObj = false;

        list($request, $requestOptions) = $this->buildDownloadObjectParams($args);

        $invocationId = Uuid::uuid4()->toString();
        $requestOptions['retryHeaders'] = self::getRetryHeaders($invocationId, 1);
        $requestOptions['restRetryFunction'] = $this->getRestRetryFunction('objects', 'get', $requestOptions);
        // We try to deduce if the object is a transcoded object when we receive the headers.
        $requestOptions['restOptions']['on_headers'] = function ($response) use (&$transcodedObj) {
            $header = $response->getHeader(self::TRANSCODED_OBJ_HEADER_KEY);
            if (is_array($header) && in_array(self::TRANSCODED_OBJ_HEADER_VAL, $header)) {
                $transcodedObj = true;
            }
        };
        $requestOptions['restRetryListener'] = function (
            \Exception $e,
            $retryAttempt,
            &$arguments
        ) use (
            $resultStream,
            $requestedBytes,
            $invocationId
        ) {
            // if the exception has a response for us to use
            if ($e instanceof RequestException && $e->hasResponse()) {
                $msg = (string) $e->getResponse()->getBody();

                $fetchedStream = Utils::streamFor($msg);

                // add the partial response to our stream that we will return
                Utils::copyToStream($fetchedStream, $resultStream);

                // Start from the byte that was last fetched
                $startByte = intval($requestedBytes['startByte']) + $resultStream->getSize();
                $endByte = $requestedBytes['endByte'];

                // modify the range headers to fetch the remaining data
                $arguments[1]['headers']['Range'] = sprintf('bytes=%s-%s', $startByte, $endByte);
                $arguments[0] = $this->modifyRequestForRetry($arguments[0], $retryAttempt, $invocationId);
            }
        };

        $fetchedStream = $this->requestWrapper->send(
            $request,
            $requestOptions
        )->getBody();

        // If our object is a transcoded object, then Range headers are not honoured.
        // That means even if we had a partial download available, the final obj
        // that was fetched will contain the complete object. So, we don't need to copy
        // the partial stream, we can just return the stream we fetched.
        if ($transcodedObj) {
            return $fetchedStream;
        }

        Utils::copyToStream($fetchedStream, $resultStream);

        $resultStream->seek(0);
        return $resultStream;
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

        // Passing the preconditions we want to extract out of arguments
        // into our query params.
        $preconditions = self::$condIdempotentOps['objects.insert'];
        foreach ($preconditions as $precondition) {
            if (isset($args[$precondition])) {
                $uriParams['query'][$precondition] = $args[$precondition];
            }
        }

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

        $args['data'] = Utils::streamFor($args['data']);

        if ($args['resumable'] === null) {
            $args['resumable'] = $args['data']->getSize() > AbstractUploader::RESUMABLE_LIMIT;
        }

        if (!$args['name']) {
            $args['name'] = basename($args['data']->getMetadata('uri'));
        }

        $validate = $this->chooseValidationMethod($args);
        if ($validate === 'md5') {
            $args['metadata']['md5Hash'] = base64_encode(Utils::hash($args['data'], 'md5', true));
        } elseif ($validate === 'crc32') {
            $args['metadata']['crc32c'] = $this->crcFromStream($args['data']);
        }

        $args['metadata']['name'] = $args['name'];
        if (isset($args['retention'])) {
            // during object creation retention properties go into metadata
            // but not into request body
            $args['metadata']['retention'] = $args['retention'];
            unset($args['retention']);
        }
        unset($args['name']);
        $args['contentType'] = $args['metadata']['contentType']
            ?? MimeType::fromFilename($args['metadata']['name']);

        $uploaderOptionKeys = [
            'restOptions',
            'retries',
            'requestTimeout',
            'chunkSize',
            'contentType',
            'metadata',
            'uploadProgressCallback',
            'restDelayFunction',
            'restCalcDelayFunction',
        ];

        $args['uploaderOptions'] = array_intersect_key($args, array_flip($uploaderOptionKeys));
        $args = array_diff_key($args, array_flip($uploaderOptionKeys));

        // Passing on custom retry function to $args['uploaderOptions']
        $retryFunc = $this->getRestRetryFunction(
            'objects',
            'insert',
            $args
        );
        $args['uploaderOptions']['restRetryFunction'] = $retryFunc;

        $args['uploaderOptions'] = $this->addRetryHeaderLogic(
            $args['uploaderOptions']
        );

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

        $queryOptions = [
            'generation' => $args['generation'],
            'alt' => 'media',
            'userProject' => $args['userProject'],
        ];
        if (isset($args['softDeleted'])) {
            // alt param cannot be specified with softDeleted param. See:
            // https://cloud.google.com/storage/docs/json_api/v1/objects/get
            unset($args['alt']);
            $queryOptions['softDeleted'] = $args['softDeleted'];
        }

        $uri = $this->expandUri($this->apiEndpoint . self::DOWNLOAD_PATH, [
            'bucket' => $args['bucket'],
            'object' => $args['object'],
            'query' => $queryOptions,
        ]);

        return [
            new Request('GET', Utils::uriFor($uri)),
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
        $data->rewind();
        $crc32c = hash_init('crc32c');
        while (!$data->eof()) {
            $buffer = $data->read(1048576);
            hash_update($crc32c, $buffer);
        }
        $data->seek($pos);
        $hash = hash_final($crc32c, true);
        return base64_encode($hash);
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
     * @deprecated
     * @return bool
     */
    protected function supportsBuiltinCrc32c()
    {
        return extension_loaded('hash') && in_array('crc32c', hash_algos());
    }

    /**
     * Add the required retry function and send the request.
     *
     * @param string $resource resource name, eg: buckets.
     * @param string $method method name, eg: get
     * @param array $options [optional] Options used to build out the request.
     * @param array $whitelisted [optional]
     */
    public function send($resource, $method, array $options = [], $whitelisted = false)
    {
        $retryMap = [
            'projects.resources.serviceAccount' => 'serviceaccount',
            'projects.resources.hmacKeys' => 'hmacKey',
            'bucketAccessControls' => 'bucket_acl',
            'defaultObjectAccessControls' => 'default_object_acl',
            'objectAccessControls' => 'object_acl'
        ];
        $retryResource = isset($retryMap[$resource]) ? $retryMap[$resource] : $resource;
        $options['restRetryFunction'] = $this->restRetryFunction ?? $this->getRestRetryFunction(
            $retryResource,
            $method,
            $options
        );

        $options = $this->addRetryHeaderLogic($options);

        return $this->traitSend($resource, $method, $options);
    }

    /**
     * Adds the retry headers to $args which amends retry hash and attempt
     * count to the required header.
     * @param array $args
     * @return array
     */
    private function addRetryHeaderLogic(array $args)
    {
        $invocationId = Uuid::uuid4()->toString();
        $args['retryHeaders'] = self::getRetryHeaders($invocationId, 1);

        // Adding callback logic to update headers while retrying
        $args['restRetryListener'] = function (
            \Exception $e,
            $retryAttempt,
            &$arguments
        ) use (
            $invocationId
        ) {
            $arguments[0] = $this->modifyRequestForRetry(
                $arguments[0],
                $retryAttempt,
                $invocationId
            );
        };

        return $args;
    }

    private function modifyRequestForRetry(
        RequestInterface $request,
        int $retryAttempt,
        string $invocationId
    ) {
        $changes = self::getRetryHeaders($invocationId, $retryAttempt + 1);
        $headerLine = $request->getHeaderLine(Retry::RETRY_HEADER_KEY);

        // An associative array to contain final header values as
        // $headerValueKey => $headerValue
        $headerElements = [];

        // Adding existing values
        $headerLineValues = explode(' ', $headerLine);
        foreach ($headerLineValues as $value) {
            $key = explode('/', $value)[0];
            $headerElements[$key] = $value;
        }

        // Adding changes with replacing value if $key already present
        foreach ($changes as $change) {
            $key = explode('/', $change)[0];
            $headerElements[$key] = $change;
        }

        return $request->withHeader(
            Retry::RETRY_HEADER_KEY,
            implode(' ', $headerElements)
        );
    }

    /**
     * Util function to compute the bytes requested for a download request.
     *
     * @param array $options Request options
     * @return array
     */
    private function getRequestedBytes(array $options)
    {
        $startByte = 0;
        $endByte = '';

        if (isset($options['restOptions']) && isset($options['restOptions']['headers'])) {
            $headers = $options['restOptions']['headers'];
            if (isset($headers['Range']) || isset($headers['range'])) {
                $header = isset($headers['Range']) ? $headers['Range'] : $headers['range'];
                $range = explode('=', $header);
                $bytes = explode('-', $range[1]);
                $startByte = $bytes[0];
                $endByte = $bytes[1];
            }
        }

        return compact('startByte', 'endByte');
    }
}
