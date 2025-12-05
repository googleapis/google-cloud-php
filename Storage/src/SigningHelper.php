<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Storage;

use Google\Auth\CredentialsLoader;
use Google\Auth\SignBlobInterface;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\JsonTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\Connection\RetryTrait;

/**
 * Provides common methods for signing storage URLs.
 *
 * @internal
 */
class SigningHelper
{
    use ArrayTrait;
    use JsonTrait;
    use RetryTrait;

    const DEFAULT_URL_SIGNING_VERSION = 'v2';
    const DEFAULT_DOWNLOAD_HOST = 'storage.googleapis.com';

    const V4_ALGO_NAME = 'GOOG4-RSA-SHA256';
    const V4_TIMESTAMP_FORMAT = 'Ymd\THis\Z';
    const V4_DATESTAMP_FORMAT = 'Ymd';
    const MAX_RETRIES = 5;

    /**
     * Create or fetch a SigningHelper instance.
     *
     * @return SigningHelper
     */
    public static function getHelper()
    {
        static $helper;
        if (!$helper) {
            $helper = new static();
        }

        return $helper;
    }

    /**
     * Sign using the version inferred from `$options.version`.
     *
     * @param ConnectionInterface $connection A connection to the Cloud Storage
     *        API. This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param int|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see StorageObject::signedUrl()} for
     *        details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function sign(ConnectionInterface $connection, $expires, $resource, $generation, array $options)
    {
        $version = $options['version'] ?? self::DEFAULT_URL_SIGNING_VERSION;

        unset($options['version']);

        switch (strtolower($version)) {
            case 'v2':
                $method = 'v2Sign';
                break;

            case 'v4':
                $method = 'v4Sign';
                break;

            default:
                throw new \InvalidArgumentException('Invalid signing version.');
        }

        return call_user_func_array([$this, $method], [
            $connection,
            $expires,
            $resource,
            $generation,
            $options
        ]);
    }

    /**
     * Sign a URL using Google Signed URLs v2.
     *
     * This method will be deprecated in the future.
     *
     * @param ConnectionInterface $connection A connection to the Cloud Storage
     *        API. This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param int|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see StorageObject::signedUrl()} for
     *        details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function v2Sign(ConnectionInterface $connection, $expires, $resource, $generation, array $options)
    {
        list($credentials, $options) = $this->getSigningCredentials($connection, $options);

        $expires = $this->normalizeExpiration($expires);
        list($resource, $bucket) = $this->normalizeResource($resource);
        $options = $this->normalizeOptions($options);
        $headers = $this->normalizeHeaders($options['headers']);

        if ($options['virtualHostedStyle']) {
            $options['bucketBoundHostname'] = sprintf(
                '%s.storage.googleapis.com',
                $bucket
            );
        }

        // Make sure disallowed headers are not included.
        $illegalHeaders = [
            'x-goog-encryption-key',
            'x-goog-encryption-key-sha256'
        ];
        if ($illegal = array_intersect_key(array_flip($illegalHeaders), $headers)) {
            throw new \InvalidArgumentException(sprintf(
                '%s %s not allowed in Signed URL headers.',
                implode(' and ', array_keys($illegal)),
                count($illegal) === 1 ? 'is' : 'are'
            ));
        }

        // Sort headers by name.
        ksort($headers);

        $toSign = [
            $options['method'],
            $options['contentMd5'],
            $options['contentType'],
            $expires,
        ];

        $signedHeaders = [];
        foreach ($headers as $name => $value) {
            $signedHeaders[] = $name . ':' . $value;
        }

        // Push the headers onto the end of the signing string.
        if ($signedHeaders) {
            $toSign = array_merge($toSign, $signedHeaders);
        }

        $toSign[] = $resource;

        $stringToSign = $this->createV2CanonicalRequest($toSign);

        // Use exponential backOff
        $signature = $this->retrySignBlob(fn () => $credentials->signBlob($stringToSign, [
            'forceOpenssl' => $options['forceOpenssl']
        ]));

        // Start with user-provided query params and add required parameters.
        $params = $options['queryParams'];
        $params['GoogleAccessId'] = $credentials->getClientName();
        $params['Expires'] = $expires;
        $params['Signature'] = $signature;

        // urlencode parameter values
        foreach ($params as &$value) {
            $value = rawurlencode($value ?? '');
        }

        $params = $this->addCommonParams($generation, $params, $options);

        $queryString = $this->buildQueryString($params);

        $resource = $this->normalizeUriPath($options['bucketBoundHostname'], $resource);
        return 'https://' . $options['bucketBoundHostname'] . $resource . '?' . $queryString;
    }

    /**
     * Sign a storage URL using Google Signed URLs v4.
     *
     * @param ConnectionInterface $connection A connection to the Cloud Storage
     *        API. This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param int|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see StorageObject::signedUrl()} for
     *        details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function v4Sign(ConnectionInterface $connection, $expires, $resource, $generation, array $options)
    {
        list($credentials, $options) = $this->getSigningCredentials($connection, $options);

        $expires = $this->normalizeExpiration($expires);
        list($resource, $bucket) = $this->normalizeResource($resource);
        $options = $this->normalizeOptions($options);

        $time = $options['timestamp'];
        $requestTimestamp = $time->format(self::V4_TIMESTAMP_FORMAT);
        $requestDatestamp = $time->format(self::V4_DATESTAMP_FORMAT);
        $timeSeconds = $time->format('U');

        $expireLimit = $timeSeconds + 604800;
        if ($expires > $expireLimit) {
            throw new \InvalidArgumentException(
                'V4 Signed URLs may not have an expiration greater than seven days in the future.'
            );
        }

        $clientEmail = $credentials->getClientName();
        $credentialScope = sprintf('%s/auto/storage/goog4_request', $requestDatestamp);
        $credential = sprintf('%s/%s', $clientEmail, $credentialScope);

        if ($options['virtualHostedStyle']) {
            $options['bucketBoundHostname'] = sprintf(
                '%s.storage.googleapis.com',
                $bucket
            );
        }

        // Add headers and query params based on provided options.
        $params = $options['queryParams'];
        $headers = $options['headers'] + [
            'host' => $options['bucketBoundHostname']
        ];

        if ($options['contentType']) {
            $headers['content-type'] = $options['contentType'];
        }

        if ($options['contentMd5']) {
            $headers['content-md5'] = $options['contentMd5'];
        }

        $params = $this->addCommonParams($generation, $params, $options);

        $headers = $this->normalizeHeaders($headers);

        // sort headers by name
        ksort($headers, SORT_NATURAL | SORT_FLAG_CASE);

        // Canonical headers are a list, newline separated, of keys and values,
        // comma separated.
        // Signed headers are a list of keys, separated by a semicolon.
        $canonicalHeaders = [];
        $signedHeaders = [];
        foreach ($headers as $key => $val) {
            $canonicalHeaders[] = sprintf('%s:%s', $key, $val);
            $signedHeaders[] = $key;
        }
        $canonicalHeaders = implode("\n", $canonicalHeaders) . "\n";

        $signedHeaders = implode(';', $signedHeaders);

        // Add required query parameters.
        $params  = [
            'X-Goog-Algorithm' => self::V4_ALGO_NAME,
            'X-Goog-Credential' => $credential,
            'X-Goog-Date' => $requestTimestamp,
            'X-Goog-Expires' => $expires - $timeSeconds,
            'X-Goog-SignedHeaders' => $signedHeaders,
        ] + $params;

        $paramNames = [];
        foreach ($params as $key => $val) {
            $paramNames[] = $key;
        }

        sort($paramNames, SORT_REGULAR);

        $sortedParams = [];
        foreach ($paramNames as $name) {
            $sortedParams[rawurlencode($name)] = rawurlencode($params[$name]);
        }

        $canonicalQueryString = $this->buildQueryString($sortedParams);
        $canonicalResource = $this->normalizeCanonicalRequestResource(
            $resource,
            $options['bucketBoundHostname'],
            $options['virtualHostedStyle']
        );

        $canonicalRequest = [
            $options['method'],
            $canonicalResource,
            $canonicalQueryString,
            $canonicalHeaders,
            $signedHeaders,
            $this->getPayloadHash($headers)
        ];

        $requestHash = $this->createV4CanonicalRequest($canonicalRequest);

        // Construct the string to sign.
        $stringToSign = implode("\n", [
            self::V4_ALGO_NAME,
            $requestTimestamp,
            $credentialScope,
            $requestHash
        ]);

        $signature = bin2hex(base64_decode($this->retrySignBlob(
            fn () => $credentials->signBlob($stringToSign, [
                'forceOpenssl' => $options['forceOpenssl']
            ])
        ) ?? ''));

        // Construct the modified resource name. If a custom hostname is provided,
        // this will remove the bucket name from the resource.
        $resource = $this->normalizeUriPath($options['bucketBoundHostname'], $resource);

        $scheme = $this->chooseScheme(
            $options['scheme'],
            $options['bucketBoundHostname'],
            $options['virtualHostedStyle']
        );

        return sprintf(
            '%s://%s%s?%s&X-Goog-Signature=%s',
            $scheme,
            $options['bucketBoundHostname'],
            $resource,
            $canonicalQueryString,
            $signature
        );
    }

    /**
     * Create an HTTP POST policy using v4 signing.
     *
     * @param ConnectionInterface $connection A Connection to Google Cloud Storage.
     *        This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param array $options Configuration options. See
     *        {@see Bucket::generateSignedPostPolicyV4()} for details.
     * @return array An associative array, containing (string) `uri` and
     *        (array) `fields` keys.
     */
    public function v4PostPolicy(
        ConnectionInterface $connection,
        $expires,
        $resource,
        array $options = []
    ) {
        list($credentials, $options) = $this->getSigningCredentials($connection, $options);

        $expires = $this->normalizeExpiration($expires);
        list($resource, $bucket, $object) = $this->normalizeResource($resource, false);
        $object = trim($object, '/');

        $options = $this->normalizeOptions($options) + [
            'fields' => [],
            'conditions' => [],
            'successActionRedirect' => null,
            'successActionStatus' => null
        ];

        $time = $options['timestamp'];
        $requestTimestamp = $time->format(self::V4_TIMESTAMP_FORMAT);
        $requestDatestamp = $time->format(self::V4_DATESTAMP_FORMAT);
        $expiration = \DateTimeImmutable::createFromFormat('U', (string) $expires);
        $expirationTimestamp = str_replace(
            '+00:00',
            'Z',
            $expiration->format(\DateTime::RFC3339)
        );

        $clientEmail = $credentials->getClientName();
        $credentialScope = sprintf('%s/auto/storage/goog4_request', $requestDatestamp);
        $credential = sprintf('%s/%s', $clientEmail, $credentialScope);

        if ($options['virtualHostedStyle']) {
            $options['bucketBoundHostname'] = sprintf(
                '%s.storage.googleapis.com',
                $bucket
            );
        }

        $fields = array_merge($options['fields'], [
            'key' => $object,
            'x-goog-algorithm' => self::V4_ALGO_NAME,
            'x-goog-credential' => $credential,
            'x-goog-date' => $requestTimestamp
        ]);

        $conditions = $options['conditions'];
        foreach ($options['fields'] as $key => $value) {
            $conditions[] = [$key => $value];
        }

        foreach ($conditions as $key => $value) {
            $key = $key;
            $value = $value;
            $conditions[$key] = $value;
        }

        $conditions = array_merge($conditions, [
            ['bucket' => $bucket],
            ['key' => $object],
            ['x-goog-date' => $requestTimestamp],
            ['x-goog-credential' => $credential],
            ['x-goog-algorithm' => self::V4_ALGO_NAME],
        ]);

        $policy = [
            'conditions' => $conditions,
            'expiration' => $expirationTimestamp
        ];

        $json = str_replace('\\\u', '\\u', json_encode($policy, JSON_UNESCAPED_SLASHES));
        $stringToSign = base64_encode($json);

        $signature = bin2hex(base64_decode($credentials->signBlob($stringToSign, [
            'forceOpenssl' => $options['forceOpenssl']
        ])));

        $fields['x-goog-signature'] = $signature;
        $fields['policy'] = $stringToSign;

        // Construct the modified resource name. If a custom hostname is provided,
        // this will remove the bucket name from the resource.
        $resource = $this->normalizeUriPath($options['bucketBoundHostname'], '/' . $bucket, true);

        $scheme = $this->chooseScheme(
            $options['scheme'],
            $options['bucketBoundHostname'],
            $options['virtualHostedStyle']
        );

        return [
            'url' => sprintf(
                '%s://%s%s',
                $scheme,
                $options['bucketBoundHostname'],
                $resource
            ),
            'fields' => $fields
        ];
    }

    /**
     * Creates a canonical request hash for a V4 Signed URL.
     *
     * NOTE: While in most cases `PHP_EOL` is preferable to a system-specific
     * character, in this case `\n` is required.
     *
     * @param array $canonicalRequest The canonical request, with each element
     *        representing a line in the request.
     * @return string
     */
    private function createV4CanonicalRequest(array $canonicalRequest)
    {
        $canonicalRequestString = implode("\n", $canonicalRequest);
        return bin2hex(hash('sha256', $canonicalRequestString, true));
    }

    /**
     * Creates a canonical request for a V2 Signed URL.
     *
     * NOTE: While in most cases `PHP_EOL` is preferable to a system-specific
     * character, in this case `\n` is required.
     *
     * @param array $canonicalRequest The canonical request, with each element
     *        representing a line in the request.
     * @return string
     */
    private function createV2CanonicalRequest(array $canonicalRequest)
    {
        return implode("\n", $canonicalRequest);
    }

    /**
     * Choose the correct URL scheme.
     *
     * @param string $scheme The scheme provided by the user or defaults.
     * @param string $bucketBoundHostname The bucketBoundHostname provided by the user or defaults.
     * @param bool $virtualHostedStyle Whether virtual host style is enabled.
     * @return string
     */
    private function chooseScheme($scheme, $bucketBoundHostname, $virtualHostedStyle = false)
    {
        // bucketBoundHostname not used -- always https.
        if ($bucketBoundHostname === self::DEFAULT_DOWNLOAD_HOST) {
            return 'https';
        }

        // virtualHostedStyle enabled -- always https.
        if ($virtualHostedStyle) {
            return 'https';
        }

        // not virtual hosted style, and custom hostname -- use default (http) or user choice.
        return $scheme;
    }

    /**
     * If `X-Goog-Content-SHA256` header is provided, use that as the payload.
     * Otherwise, `UNSIGNED-PAYLOAD`.
     *
     * @param array $headers
     * @return string
     */
    private function getPayloadHash(array $headers)
    {
        if (!isset($headers['x-goog-content-sha256'])) {
            return 'UNSIGNED-PAYLOAD';
        }

        return $headers['x-goog-content-sha256'];
    }

    /**
     * Normalizes and validates an expiration.
     *
     * @param Timestamp|\DateTimeInterface|int $expires The expiration
     * @return int
     * @throws \InvalidArgumentException If an invalid value is given.
     */
    private function normalizeExpiration($expires)
    {
        if ($expires instanceof Timestamp) {
            $seconds = $expires->get()->format('U');
        } elseif ($expires instanceof \DateTimeInterface) {
            $seconds = $expires->format('U');
        } elseif (is_numeric($expires)) {
            $seconds = (int) $expires;
        } else {
            throw new \InvalidArgumentException('Invalid expiration.');
        }

        return $seconds;
    }

    /**
     * Normalizes and encodes the resource identifier.
     *
     * @param string $resource The resource identifier. In form
     *        `[/]$bucket/$object`.
     * @return array A list, where index 0 is the resource path, with pieces
     *        encoded and prefixed with a forward slash, index 1 is the bucket
     *        name, and index 2 is the object name, relative to the bucket.
     */
    private function normalizeResource($resource, $urlencode = true)
    {
        $pieces = explode('/', trim($resource, '/'));

        if ($urlencode) {
            array_walk($pieces, function (&$piece) {
                $piece = rawurlencode($piece);
            });
        }

        $bucket = $pieces[0];

        $relative = $pieces;
        array_shift($relative);

        return [
            '/' . implode('/', $pieces),
            $bucket,
            '/' . implode('/', $relative),
        ];
    }

    /**
     * Fixes the user input options, filters and validates data.
     *
     * @param array $options Signed URL configuration options.
     * @return array
     * @throws \InvalidArgumentException
     */
    private function normalizeOptions(array $options)
    {
        $options += [
            'allowPost' => false,
            'cname' => null, //@deprecated
            'bucketBoundHostname' => self::DEFAULT_DOWNLOAD_HOST,
            'contentMd5' => null,
            'contentType' => null,
            'forceOpenssl' => false,
            'headers' => [],
            'keyFile' => null,
            'keyFilePath' => null,
            'credentialsFetcher' => null,
            'method' => 'GET',
            'queryParams' => [],
            'responseDisposition' => null,
            'responseType' => null,
            'saveAsName' => null,

            // note that in almost every case this default will be overridden.
            'scheme' => 'http',
            'timestamp' => null,
            'virtualHostedStyle' => false,
        ];

        $allowedMethods = ['GET', 'PUT', 'POST', 'DELETE'];
        $options['method'] = strtoupper($options['method']);
        if (!in_array($options['method'], $allowedMethods)) {
            throw new \InvalidArgumentException('$options.method must be one of `GET`, `PUT` or `DELETE`.');
        }

        if ($options['method'] === 'POST' && !$options['allowPost']) {
            throw new \InvalidArgumentException(
                'Invalid method. To create an upload URI, use StorageObject::signedUploadUrl().'
            );
        }

        // Rewrite deprecated `cname` to new `bucketBoundHostname`.
        if ($options['cname'] && $options['bucketBoundHostname'] === self::DEFAULT_DOWNLOAD_HOST) {
            $options['bucketBoundHostname'] = $options['cname'];
        }

        // strip protocol from hostname.
        $hostnameParts = explode('//', $options['bucketBoundHostname']);
        if (count($hostnameParts) > 1) {
            $options['bucketBoundHostname'] = $hostnameParts[1];
        }

        $options['bucketBoundHostname'] = trim($options['bucketBoundHostname'], '/');

        // If a timestamp is provided, use it in place of `now` for v4 URLs only..
        // This option exists for testing purposes, and should not generally be provided by users.
        if ($options['timestamp']) {
            if (!($options['timestamp'] instanceof \DateTimeInterface)) {
                if (!is_string($options['timestamp'])) {
                    throw new \InvalidArgumentException(
                        'User-provided timestamps must be a string or instance of `\DateTimeInterface`.'
                    );
                }

                $options['timestamp'] = \DateTimeImmutable::createFromFormat(
                    \DateTime::RFC3339,
                    $options['timestamp'],
                    new \DateTimeZone('UTC')
                );

                if (!$options['timestamp']) {
                    throw new \InvalidArgumentException(
                        'Given timestamp string is in an invalid format. Provide timestamp formatted as follows: `' .
                        \DateTime::RFC3339 .
                        '`. Note that timestamps MUST be in UTC.'
                    );
                }
            }
        } else {
            $options['timestamp'] = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        }

        unset(
            $options['cname'],
            $options['allowPost']
        );

        return $options;
    }

    /**
     * Cleans and normalizes header values.
     *
     * Arrays of values are collapsed into a comma-separated list, trailing and
     * leading spaces are removed, newlines are replaced by empty strings, and
     * multiple whitespace chars are replaced by a single space.
     *
     * @param array $headers Input headers
     * @return array
     */
    private function normalizeHeaders(array $headers)
    {
        $out = [];
        foreach ($headers as $name => $value) {
            $name = strtolower(trim($name));
            // collapse arrays of values into a comma-separated list.
            if (!is_array($value)) {
                $value = [$value];
            }

            foreach ($value as &$headerValue) {
                // strip trailing and leading spaces.
                $headerValue = trim($headerValue);

                // replace newlines with empty strings.
                $headerValue = str_replace(PHP_EOL, '', $headerValue);

                // collapse multiple whitespace chars to a single space.
                $headerValue = preg_replace('/[\s]+/', ' ', $headerValue);
            }

            $out[$name] = implode(', ', $value);
        }

        return $out;
    }

    /**
     * Returns a resource formatted for use in a URI.
     *
     * If the bucketBoundHostname is other than the default, will omit the bucket name.
     *
     * @param string $bucketBoundHostname The bucketBoundHostname provided by the user, or the default
     *     value.
     * @param string $resource The GCS resource path (i.e. /bucket/object).
     * @return string
     */
    private function normalizeUriPath($bucketBoundHostname, $resource, $withTrailingSlash = false)
    {
        if ($bucketBoundHostname !== self::DEFAULT_DOWNLOAD_HOST) {
            $resourceParts = explode('/', trim($resource, '/'));
            array_shift($resourceParts);

            // Resource is a Bucket.
            if (empty($resourceParts)) {
                $resource = '/';
            } else {
                $resource = '/' . implode('/', $resourceParts);
            }
        }

        $resource = rtrim($resource, '/');

        return $withTrailingSlash
            ? $resource . '/'
            : $resource;
    }

    /**
     * Normalize the resource provided to the canonical request string.
     *
     * @param string $resource
     * @param string $bucketBoundHostname
     * @param boolean $virtualHostedStyle
     * @return string
     */
    private function normalizeCanonicalRequestResource($resource, $bucketBoundHostname, $virtualHostedStyle = false)
    {
        if ($bucketBoundHostname === self::DEFAULT_DOWNLOAD_HOST && !$virtualHostedStyle) {
            return $resource;
        }

        $pieces = explode('/', trim($resource, '/'));
        array_shift($pieces);
        return '/' . implode('/', $pieces);
    }

    /**
     * Get the credentials for use with signing.
     *
     * @param ConnectionInterface $connection A Storage connection object.
     *        This object is created by StorageClient,
     *        and should not be instantiated outside of this client.
     * @param array $options Configuration options.
     * @return array A list containing a credentials object at index 0 and the
     *        modified options at index 1.
     * @throws \RuntimeException If the credentials type is not valid for signing.
     * @throws \InvalidArgumentException If a keyfile is given and is not valid.
     */
    private function getSigningCredentials(ConnectionInterface $connection, array $options)
    {
        $keyFilePath = $options['keyFilePath'] ?? null;

        if ($keyFilePath) {
            if (!file_exists($keyFilePath)) {
                throw new \InvalidArgumentException(sprintf(
                    'Keyfile path %s does not exist.',
                    $keyFilePath
                ));
            }

            $options['keyFile'] = self::jsonDecode(file_get_contents($keyFilePath), true);
        }

        $rw = $connection->requestWrapper();

        $keyFile = $options['keyFile'] ?? null;
        if ($keyFile) {
            $scopes = $options['scopes'] ?? $rw->scopes();

            $credentials = CredentialsLoader::makeCredentials($scopes, $keyFile);
        } elseif (isset($options['credentialsFetcher'])) {
            $credentials = $options['credentialsFetcher'];
        } else {
            $credentials = $rw->getCredentialsFetcher();
        }

        //@codeCoverageIgnoreStart
        if (!($credentials instanceof SignBlobInterface)) {
            throw new \RuntimeException(sprintf(
                'Credentials object is of type `%s` and is not valid for signing.',
                get_class($credentials)
            ));
        }
        //@codeCoverageIgnoreEnd

        unset(
            $options['keyFilePath'],
            $options['keyFile'],
            $options['credentialsFetcher'],
            $options['scopes']
        );

        return [$credentials, $options];
    }

    /**
     * Add parameters common to all signed URL versions.
     *
     * @param int|null $generation
     * @param array $params
     * @param array $options
     * @return array
     */
    private function addCommonParams($generation, array $params, array $options)
    {
        if ($options['responseType']) {
            $params['response-content-type'] = $options['responseType'];
        }

        if ($options['responseDisposition']) {
            $params['response-content-disposition'] = $options['responseDisposition'];
        } elseif ($options['saveAsName']) {
            $params['response-content-disposition'] = 'attachment; filename='
                . '"' . $options['saveAsName'] . '"';
        }

        if ($generation) {
            $params['generation'] = $generation;
        }

        return $params;
    }

    /**
     * Create a query string from an array.
     *
     * Note that this method does NOT urlencode keys or values.
     *
     * @param array $input
     * @return string
     */
    private function buildQueryString(array $input)
    {
        $q = [];
        foreach ($input as $key => $val) {
            $q[] = $key . '=' . $val;
        }

        return implode('&', $q);
    }

    /**
     * Retry logic for signBlob
     *
     * @param callable $signBlobFn  A callable that perform the actual signBlob operation.
     * @param string $resourceName The resource name for logging or retry strategy determination.
     * @param array $args Arguments for the operations, include preconditions
     * @return string The signature genarated by signBlob.
     * @throws ServiceException If non-retryable error occur.
     * @throws \RuntimeException If retries are exhausted.
     */
    private function retrySignBlob(callable $signBlobFn, string $resourceName = 'signBlob', array $args = [])
    {
        $attempt = 0;
        // Generate a retry decider function using the RetryTrait logic.
        $retryDecider = $this->getRestRetryFunction($resourceName, 'execute', $args);
        while (true) {
            ++$attempt;
            try {
                // Attempt the operation
                return $signBlobFn();
            } catch (\Exception $exception) {
                if (!$retryDecider($exception, $attempt, self::MAX_RETRIES)) {
                    // Non-retryable error
                    throw $exception;
                }
            }
        }
    }
}
