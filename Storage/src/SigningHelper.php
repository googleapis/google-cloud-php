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
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Storage\Connection\ConnectionInterface;

/**
 * Provides common methods for signing storage URLs.
 *
 * @internal
 */
class SigningHelper
{
    const DEFAULT_URL_SIGNING_VERSION = 'v2';
    const DEFAULT_DOWNLOAD_HOST = 'storage.googleapis.com';

    const V4_ALGO_NAME = 'GOOG4-RSA-SHA256';
    const V4_TIMESTAMP_FORMAT = 'Ymd\THis\Z';
    const V4_DATESTAMP_FORMAT = 'Ymd';

    /**
     * Create or fetch a SigningHelper instance.
     *
     * @return SigningHelper
     */
    public static function getHelper()
    {
        static $helper;
        if (!$helper) {
            $helper = new static;
        }

        return $helper;
    }
    /**
     * Get the credentials for use with signing.
     *
     * @param ConnectionInterface $connection A Storage connection object.
     * @param array $options Configuration options.
     * @return array A list containing a credentials object at index 0 and the
     *        modified options at index 1.
     * @throws \RuntimeException If the credentials type is not valid for signing.
     * @throws \InvalidArgumentException If a keyfile is given and is not valid.
     */
    public static function getSigningCredentials(ConnectionInterface $connection, array $options)
    {
        $keyFilePath = isset($options['keyFilePath'])
            ? $options['keyFilePath']
            : null;

        if ($keyFilePath) {
            if (!file_exists($keyFilePath)) {
                throw new \InvalidArgumentException(sprintf(
                    'Keyfile path %s does not exist.',
                    $keyFilePath
                ));
            }

            $options['keyFile'] = json_decode(file_get_contents($keyFilePath), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException(sprintf(
                    'Keyfile path %s does not contain valid json.',
                    $keyFilePath
                ));
            }
        }

        $rw = $connection->requestWrapper();

        $keyFile = isset($options['keyFile'])
            ? $options['keyFile']
            : null;
        if ($keyFile) {
            $scopes = isset($options['scopes'])
                ? $options['scopes']
                : $rw->scopes();

            $credentials = CredentialsLoader::makeCredentials($scopes, $keyFile);
        } else {
            $credentials = $rw->getCredentialsFetcher();
        }

        if (!($credentials instanceof SignBlobInterface)) {
            throw new \RuntimeException(sprintf(
                'Credentials object is of type `%s` and is not valid for signing.',
                get_class($credentials)
            ));
        }

        unset(
            $options['keyFilePath'],
            $options['keyFile'],
            $options['scopes']
        );

        return [$credentials, $options];
    }

    /**
     * Determine the method name to be used for signing.
     *
     * @param string|null $version The version name.
     * @return string
     * @throws \InvalidArgumentException If the version is not in the valid options.
     */
    public static function getSigningMethodName($version)
    {
        //@codeCoverageIgnoreStart
        if ($version === null && self::DEFAULT_URL_SIGNING_VERSION === 'v2') {
            // raise a little notice to poke users towards v4.
            @trigger_error(
                'You have chosen to generate a Signed URL using the default ' .
                'v2 signing implementation. In the future, v4 Signed URLs ' .
                'will be the default. You may experience breaking changes ' .
                'if you use expirations greater than 7 days in the future.' .
                'To opt-in to the new behavior, specify `$options.version='.
                '`v4`',
                E_USER_DEPRECATED
            );
        }
        //@codeCoverageIgnoreEnd

        $version = $version ?: self::DEFAULT_URL_SIGNING_VERSION;
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

        return $method;
    }

    /**
     * Sign a URL using Google Signed URLs v2.
     *
     * This method will be deprecated in the future.
     *
     * @param SignBlobInterface $credentials A credentials instance which
     *        supports signing strings.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param string|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see Google\Cloud\Storage\StorageObject::signedUrl()} for
     *        details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function v2Sign(SignBlobInterface $credentials, $expires, $resource, $generation, array $options)
    {
        $expires = $this->normalizeExpiration($expires);
        $resource = $this->normalizeResource($resource);
        $options = $this->normalizeOptions($options);
        $headers = $this->normalizeHeaders($options['headers']);

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
            $signedHeaders[] = $name .':'. $value;
        }

        // Push the headers onto the end of the signing string.
        if ($signedHeaders) {
            $toSign = array_merge($toSign, $signedHeaders);
        }

        $toSign[] = $resource;

        // NOTE: While in most cases `PHP_EOL` is preferable to a system-specific character,
        // in this case `\n` is required.
        $stringToSign = $this->createV2CanonicalRequest($toSign);

        // Sign the string using the provided credentials.
        $signature = $credentials->signBlob($stringToSign, [
            'forceOpenssl' => $options['forceOpenssl']
        ]);

        // Signature is returned base64-encoded. URL-encode that.
        $encodedSignature = urlencode($signature);

        // Start with user-provided query params and add required parameters.
        $params = $options['queryParams'];
        $params['GoogleAccessId'] = $credentials->getClientName();
        $params['Expires'] = $expires;
        $params['Signature'] = $encodedSignature;

        if ($options['responseType']) {
            $params['response-content-type'] = urlencode($options['responseType']);
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

        $queryString = http_build_query($params, null, '&', PHP_QUERY_RFC3986);

        $resource = $this->normalizeUriPath($options['cname'], $resource);
        return 'https://' . $options['cname'] . $resource . '?' . $queryString;
    }

    /**
     * Sign a storage URL using Google Signed URLs v4.
     *
     * @param SignBlobInterface $credentials A credentials instance which
     *        supports signing strings.
     * @param Timestamp|\DateTimeInterface|int $expires The signed URL
     *        expiration.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param string|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see Google\Cloud\Storage\StorageObject::signedUrl()} for
     *        details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function v4Sign(SignBlobInterface $credentials, $expires, $resource, $generation, array $options)
    {
        $expires = $this->normalizeExpiration($expires);
        $resource = $this->normalizeResource($resource);
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

        // Add headers and query params based on provided options.
        $params = $options['queryParams'];
        $headers = $options['headers'] + [
            'host' => $options['cname']
        ];

        if ($options['contentType']) {
            $headers['content-type'] = $options['contentType'];
        }

        if ($options['contentMd5']) {
            $headers['content-md5'] = $options['contentMd5'];
        }

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
        $params['X-Goog-Algorithm'] = self::V4_ALGO_NAME;
        $params['X-Goog-Credential'] = $credential;
        $params['X-Goog-Date'] = $requestTimestamp;
        $params['X-Goog-Expires'] = $expires - $timeSeconds;
        $params['X-Goog-SignedHeaders'] = $signedHeaders;

        // Sort query string params by name.
        ksort($params, SORT_NATURAL | SORT_FLAG_CASE);

        // Create a query string, encoding spaces as `%20` rather than `+`.
        $canonicalQueryString = http_build_query($params, null, '&', PHP_QUERY_RFC3986);

        $canonicalRequest = [
            $options['method'],
            $resource,
            $canonicalQueryString,
            $canonicalHeaders,
            $signedHeaders,
            'UNSIGNED-PAYLOAD'
        ];

        // Create a request hash to be signed.
        $requestHash = $this->createV4CanonicalRequest($canonicalRequest);

        // Construct the string to sign.
        $stringToSign = implode("\n", [
            self::V4_ALGO_NAME,
            $requestTimestamp,
            $credentialScope,
            $requestHash
        ]);

        // Sign the string using the given credentials.
        $signature = bin2hex(base64_decode($credentials->signBlob($stringToSign, [
            'forceOpenssl' => $options['forceOpenssl']
        ])));

        // Construct the modified resource name. If a custom cname is provided,
        // this will remove the bucket name from the resource.
        $resource = $this->normalizeUriPath($options['cname'], $resource);
        return sprintf(
            'https://%s%s?%s&X-Goog-Signature=%s',
            $options['cname'],
            $resource,
            $canonicalQueryString,
            $signature
        );
    }

    /**
     * Creates a canonical request hash for a V4 Signed URL.
     *
     * @param array $canonicalRequest The canonical request, with each element
     *        representing a line in the request.
     * @return string
     */
    protected function createV4CanonicalRequest(array $canonicalRequest)
    {
        return bin2hex(hash('sha256', implode("\n", $canonicalRequest), true));
    }

    /**
     * Creates a canonical request for a V2 Signed URL.
     *
     * @param array $canonicalRequest The canonical request, with each element
     *        representing a line in the request.
     * @return string
     */
    protected function createV2CanonicalRequest(array $canonicalRequest)
    {
        return implode("\n", $canonicalRequest);
    }

    /**
     * Normalizes and validates an expiration.
     *
     * @param Timestamp|\DateTimeInterface|int $expires The expiration
     * @return int
     * @throws \InvalidArgumentException If an invalid value is given.
     */
    protected function normalizeExpiration($expires)
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
     *        `[/]$bucket/$object]`.
     * @return string The resource, with pieces encoded and prefixed with a
     *        forward slash.
     */
    protected function normalizeResource($resource)
    {
        $pieces = explode('/', trim($resource, '/'));
        array_walk($pieces, function (&$piece) {
            $piece = rawurlencode($piece);
        });
        return '/' . implode('/', $pieces);
    }

    /**
     * Fixes the user input options, filters and validates data.
     *
     * @param array $options Signed URL configuration options.
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function normalizeOptions(array $options)
    {
        $options += [
            'method' => 'GET',
            'cname' => self::DEFAULT_DOWNLOAD_HOST,
            'contentMd5' => null,
            'contentType' => null,
            'headers' => [],
            'saveAsName' => null,
            'responseDisposition' => null,
            'responseType' => null,
            'keyFile' => null,
            'keyFilePath' => null,
            'allowPost' => false,
            'forceOpenssl' => false,
            'queryParams' => [],
            'timestamp' => null
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
        unset($options['allowPost']);

        // For backwards compatibility, strip protocol from cname.
        $cnameParts = explode('//', $options['cname']);
        if (count($cnameParts) > 1) {
            $options['cname'] = $cnameParts[1];
        }

        $options['cname'] = trim($options['cname'], '/');

        // If a timestamp is provided, use it in place of `now` for v4 URLs only..
        if ($options['timestamp']) {
            if (!($options['timestamp'] instanceof \DateTimeInterface)) {
                if (!is_string($options['timestamp'])) {
                    throw new \InvalidArgumentException(
                        'User-provided timestamps must be a string or instance of `\DateTimeInterface`.'
                    );
                }

                $options['timestamp'] = \DateTimeImmutable::createFromFormat(
                    self::V4_TIMESTAMP_FORMAT,
                    $options['timestamp'],
                    new \DateTimeZone('UTC')
                );

                if (!$options['timestamp']) {
                    throw new \InvalidArgumentException(sprintf(
                        'Given timestamp string is in an invalid format. Provide timestamp formatted as follows: `' .
                        self::V4_TIMESTAMP_FORMAT .
                        '`. Note that timestamps MUST be in GMT.'
                    ));
                }
            }
        } else {
            $options['timestamp'] = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        }

        return $options;
    }

    protected function normalizeHeaders(array $headers)
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
                $headerValue = str_replace(PHP_EOL, "", $headerValue);

                // collapse multiple whitespace chars to a single space.
                $headerValue = preg_replace('/\s+/', ' ', $headerValue);
            }

            $out[$name] = implode(', ', $value);
        }

        return $out;
    }

    /**
     * Returns a resource formatted for use in a URI.
     *
     * If the cname is other than the default, will omit the bucket name.
     *
     * @param string $cname The cname provided by the user, or the default
     *     value.
     * @param string $resource The GCS resource path (i.e. /bucket/object).
     * @return string
     */
    protected function normalizeUriPath($cname, $resource)
    {
        if ($cname !== self::DEFAULT_DOWNLOAD_HOST) {
            $resourceParts = explode('/', trim($resource, '/'));
            array_shift($resourceParts);

            // Resource is a Bucket.
            if (empty($resourceParts)) {
                $resource = '/';
            } else {
                $resource = '/' . implode('/', $resourceParts);
            }
        }

        return $resource;
    }
}
