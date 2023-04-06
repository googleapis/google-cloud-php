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

use Google\ApiCore\AgentHeader;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Storage\Connection\RetryTrait;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageClient;
use Google\CRC32\Builtin;
use Google\CRC32\CRC32;
use GuzzleHttp\Psr7\MimeType;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Ramsey\Uuid\Uuid;

/**
 * Implementation of the
 * [Google Cloud Storage JSON API](https://cloud.google.com/storage/docs/json_api/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use RetryTrait {
        getRestRetryFunction as public;
    }
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
            'apiEndpoint' => self::DEFAULT_API_ENDPOINT,
            // Cloud Storage needs to provide a default scope because the Storage
            // API does not accept JWTs with "audience"
            'scopes' => StorageClient::FULL_CONTROL_SCOPE,
        ];

        $this->apiEndpoint = $this->getApiEndpoint(self::DEFAULT_API_ENDPOINT, $config);

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
        return $this->sendWithRetry($args['type'], 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getAcl(array $args = [])
    {
        return $this->sendWithRetry($args['type'], 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listAcl(array $args = [])
    {
        return $this->sendWithRetry($args['type'], 'list', $args);
    }

    /**
     * @param array $args
     */
    public function insertAcl(array $args = [])
    {
        return $this->sendWithRetry($args['type'], 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function patchAcl(array $args = [])
    {
        return $this->sendWithRetry($args['type'], 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function deleteBucket(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getBucket(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listBuckets(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function insertBucket(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function patchBucket(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function deleteObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function copyObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'copy', $args);
    }

    /**
     * @param array $args
     */
    public function rewriteObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'rewrite', $args);
    }

    /**
     * @param array $args
     */
    public function composeObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'compose', $args);
    }

    /**
     * @param array $args
     */
    public function getObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listObjects(array $args = [])
    {
        return $this->sendWithRetry('objects', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function patchObject(array $args = [])
    {
        return $this->sendWithRetry('objects', 'patch', $args);
    }

    /**
     * @param array $args
     */
    public function downloadObject(array $args = [])
    {
        list($request, $requestOptions) = $this->buildDownloadObjectParams($args);

        $requestOptions['restRetryFunction'] = $this->getRestRetryFunction('objects', 'get', $requestOptions);

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
        unset($args['name']);
        $args['contentType'] = isset($args['metadata']['contentType'])
            ? $args['metadata']['contentType']
            : MimeType::fromFilename($args['metadata']['name']);

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

        $args['uploaderOptions'] = $this->addRetryHeaderCallbacks(
            $args['uploaderOptions']
        );

        return $args;
    }

    /**
     * @param  array $args
     */
    public function getBucketIamPolicy(array $args)
    {
        return $this->sendWithRetry('buckets', 'getIamPolicy', $args);
    }

    /**
     * @param  array $args
     */
    public function setBucketIamPolicy(array $args)
    {
        return $this->sendWithRetry('buckets', 'setIamPolicy', $args);
    }

    /**
     * @param  array $args
     */
    public function testBucketIamPermissions(array $args)
    {
        return $this->sendWithRetry('buckets', 'testIamPermissions', $args);
    }

    /**
     * @param array $args
     */
    public function getNotification(array $args = [])
    {
        return $this->sendWithRetry('notifications', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function deleteNotification(array $args = [])
    {
        return $this->sendWithRetry('notifications', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function insertNotification(array $args = [])
    {
        return $this->sendWithRetry('notifications', 'insert', $args);
    }

    /**
     * @param array $args
     */
    public function listNotifications(array $args = [])
    {
        return $this->sendWithRetry('notifications', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function getServiceAccount(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.serviceAccount', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function lockRetentionPolicy(array $args = [])
    {
        return $this->sendWithRetry('buckets', 'lockRetentionPolicy', $args);
    }

    /**
     * @param array $args
     */
    public function createHmacKey(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.hmacKeys', 'create', $args);
    }

    /**
     * @param array $args
     */
    public function deleteHmacKey(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.hmacKeys', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getHmacKey(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.hmacKeys', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function updateHmacKey(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.hmacKeys', 'update', $args);
    }

    /**
     * @param array $args
     */
    public function listHmacKeys(array $args = [])
    {
        return $this->sendWithRetry('projects.resources.hmacKeys', 'list', $args);
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
            'restOnRetryExceptionFunction' => null,
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

    /**
     * Add the required retry function and send the request.
     *
     * @param string $resource resource name, eg: buckets.
     * @param string $method method name, eg: get
     * @param array $args
     */
    private function sendWithRetry($resource, $method, array $args)
    {
        $retryMap = [
            'projects.resources.serviceAccount' => 'serviceaccount',
            'projects.resources.hmacKeys' => 'hmacKey',
            'bucketAccessControls' => 'bucket_acl',
            'defaultObjectAccessControls' => 'default_object_acl',
            'objectAccessControls' => 'object_acl'
        ];
        $retryResource = isset($retryMap[$resource]) ? $retryMap[$resource] : $resource;
        $args['restRetryFunction'] = $this->getRestRetryFunction(
            $retryResource,
            $method,
            $args,
            $this->restRetryFunction
        );

        $args = $this->addRetryHeaderCallbacks($args);

        return $this->send($resource, $method, $args);
    }

    /**
     * Adds the callback methods to $args which amends retry hash and attempt
     * count to the headers.
     * @param array $args
     *
     * @return array
     */
    private function addRetryHeaderCallbacks(array $args)
    {
        $requestHash = Uuid::uuid4()->toString();
        $args['restOnRetryExceptionFunction'] = function (
            \Exception $e,
            $currentAttempt,
            &$arguments
        ) use ($requestHash) {
            // Since we the the last attempt number here, so incrementing it
            // to get the current attempt count.
            // We're adding a '2' and not '1' as we need to incorporate the initial
            // request as well.
            $this->updateRetryHeaders(
                $arguments,
                $requestHash,
                $currentAttempt + 2
            );
        };

        $args['restOnExecutionStartFunction'] = function (&$arguments) use ($requestHash) {
            $this->updateRetryHeaders(
                $arguments,
                $requestHash
            );
        };
        return $args;
    }

    /**
     * Updates the api client identification header value with UUID
     * and retry count
     *
     * @param array &$arguments The arguments array(passed by reference) used by
     * execute method of ExponentialBackoff object.
     * @param string $requestHash A UUID4 string value that represents a request and
     * it's retries.
     * @param int $currentAttempt The original attempt is of a value 1, and retries are
     * 2, 3 and so on.
     * @return void
     */
    private function updateRetryHeaders(
        &$arguments,
        $requestHash,
        $currentAttempt = 1
    ) {
        $valueToAdd = sprintf("gccl-invocation-id/%s", $requestHash);
        $this->updateHeader(
            AgentHeader::AGENT_HEADER_KEY,
            $arguments,
            $valueToAdd
        );

        $valueToAdd = sprintf("gccl-attempt-count/%s", $currentAttempt);
        $this->updateHeader(
            AgentHeader::AGENT_HEADER_KEY,
            $arguments,
            $valueToAdd,
            false
        );
    }

    /**
     * Amends the given header key with new value for a request such that
     * the $request headers aren't modified directly and instead $options array
     * which are applied to the request just before sending it at core level.
     * Thus the $request object remains the same between each retry request at
     * RequestWrappers' level.
     *
     * @param string $headerLine The header line to update.
     * @param array &$arguments The arguments array(passed by reference) used by
     *        execute method of ExponentialBackoff object.
     * @param string $value The value to be ammended in the header line.
     * @param bool $getHeaderFromRequest [optional] A flag which determines if
     *        existing header value is read from $request or from $options. It's
     *        useful to read from $options incase we update multiple values to a
     *        single header key.
     */
    private function updateHeader(
        $headerLine,
        &$arguments,
        $value,
        $getHeaderFromRequest = true
    ) {
        // Fetch request and options
        $request = $this->fetchRequest($arguments);
        $options = $this->fetchOptions($arguments);

        // add empty headers to handle requests where headers aren't passed.
        $options += [
            'headers' => []
        ];

        // Create the modified header
        $headerValue = '';
        if ($getHeaderFromRequest) {
            $headerValues = $request->getHeader($headerLine);
            $headerValues[] = $value;
            $headerValue = implode(' ', $headerValues);
        } else {
            $headerValue = (isset($options['headers']) &&
                isset($options['headers'][$headerLine]))
                ? $options['headers'][$headerLine]
                : '';
            $headerValue .= (' ' . $value);
        }

        // Amend the $option's header value
        $options['headers'][$headerLine] = $headerValue;

        // Set the $argument's options array
        $this->setOptions($arguments, $options);
    }


    /**
     * This helper method fetches Request object from the $argument list.
     * @param mixed $arguments
     * @return Request|null
     */
    private function fetchRequest($arguments)
    {
        $request = null;
        foreach ($arguments as $argument) {
            if ($argument instanceof Request) {
                $request = $argument;
            }
        }
        return $request;
    }

    /**
     * This helper method fetches $options array from the $argument list.
     * @param mixed $arguments
     * @return array
     */
    private function fetchOptions($arguments)
    {
        foreach ($arguments as $argument) {
            if (is_array($argument) && isset($argument['headers'])) {
                return $argument;
            }
        }
        return [];
    }

    /**
     * This helper method sets the $options array in the $argument list
     * @param array &$arguments Argument list as reference
     * @param array $options
     * @return void
     */
    private function setOptions(array &$arguments, array $options)
    {
        foreach ($arguments as &$argument) {
            if (is_array($argument) && isset($argument['headers'])) {
                $argument = $options;
                break;
            }
        }
    }
}
