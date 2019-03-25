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

use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\Signer;
use Google\Cloud\Core\Timestamp;

/**
 * Provides common methods for signing storage URLs.
 *
 * @internal
 */
class SigningHelper
{
    const DEFAULT_DOWNLOAD_HOST = 'storage.googleapis.com';

    const V4_ALGO_NAME = 'GOOG4-RSA-SHA256';

    /**
     * @var Signer
     */
    private $signer;

    /**
     *
     * @param Signer $signer [optional] A code signer instance.
     */
    public function __construct(Signer $signer = null)
    {
        $this->signer = $signer ?: new Signer;
    }

    /**
     * Sign a URL using Google Signed URLs v2.
     *
     * This method will be deprecated in the future.
     *
     * @param string $resource The URI to the storage resource, preceded by a
     *     leading slash.
     * @param string|null $generation The resource generation.
     * @param array $options Configuration options. See
     *     {@see Google\Cloud\Storage\StorageObject::signedUrl()} for details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *     credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *     and OpenSSL is not available.
     */
    public function v2Sign(FetchAuthTokenInterface $credentials, $expires, $resource, $generation, array $options)
    {
        $expires = $this->normalizeExpiration($expires);
        $resource = $this->normalizeResource($resource);
        $options = $this->normalizeOptions($options);

        // Sort headers by name.
        ksort($options['headers']);

        $toSign = [
            $options['method'],
            $options['contentMd5'],
            $options['contentType'],
            $expires,
        ];

        $headers = [];
        foreach ($options['headers'] as $name => $value) {
            $name = strtolower(trim($name));
            $headers[] = $name .':'. $value;
        }

        // Push the headers onto the end of the signing string.
        if ($headers) {
            $toSign = array_merge($toSign, $headers);
        }

        $toSign[] = $resource;

        // NOTE: While in most cases `PHP_EOL` is preferable to a system-specific character,
        // in this case `\n` is required.
        $stringToSign = $this->createV2CanonicalRequest($toSign);

        // Sign the string using the provided credentials.
        $signature = $this->signer->signBlob($credentials, $stringToSign, $options['forceOpenssl']);

        // Signature is returned base64-encoded. URL-encode that.
        $encodedSignature = urlencode($signature);

        // Start with user-provided query params and add required parameters.
        $params = $options['queryParams'];
        $params['GoogleAccessId'] = $credentials->getClientEmail();
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
     * @param FetchAuthTokenInterface $credentials The currently authenticated
     *        credentials.
     * @param Timestamp|\DateTimeInterface|int $expires Specifies when the URL
     *        will expire. May provide an instance of {@see Google\Cloud\Core\Timestamp},
     *        [http://php.net/datetimeimmutable](`\DateTimeImmutable`), or a
     *        UNIX timestamp as an integer.
     * @param string $resource The URI to the storage resource, preceded by a
     *        leading slash.
     * @param string|null $generation The resource generation.
     * @param array $options Configuration options. See
     *        {@see Google\Cloud\Storage\StorageObject::signedUrl()} for details.
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException If required data could not be gathered from
     *        credentials.
     * @throws \RuntimeException If OpenSSL signing is required by user input
     *        and OpenSSL is not available.
     */
    public function v4Sign(FetchAuthTokenInterface $credentials, $expires, $resource, $generation, array $options)
    {
        $expires = $this->normalizeExpiration($expires);
        $resource = $this->normalizeResource($resource);
        $options = $this->normalizeOptions($options);

        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $requestTimestamp = $now->format('Ymd\THis\Z');
        $requestDatestamp = $now->format('Ymd');

        $expireLimit = time() + 604800;
        if ($expires > $expireLimit) {
            throw new \InvalidArgumentException(
                'V4 Signed URLs may not have an expiration greater than seven days in the future.'
            );
        }

        $clientEmail = $credentials->getClientEmail();
        $credentialScope = sprintf('%s/auto/storage/goog4_request', $requestDatestamp);
        $credential = sprintf('%s/%s', $clientEmail, $credentialScope);

        // Add headers and query params based on provided options.
        $params = $options['queryParams'];
        $headers = $options['headers'] + [
            'host' => $options['cname']
        ];

        if ($options['contentType']) {
            $headers['Content-Type'] = $options['contentType'];
        }

        if ($options['contentMd5']) {
            $headers['Content-MD5'] = $options['contentMd5'];
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

        // sort headers by name
        ksort($headers, SORT_NATURAL | SORT_FLAG_CASE);

        // Canonical headers are a list, newline separated, of keys and values,
        // comma separated.
        // Signed headers are a list of keys, separated by a semicolon.
        $canonicalHeaders = [];
        $signedHeaders = [];
        foreach ($headers as $key => $val) {
            $canonicalHeaders[] = sprintf('%s:%s', strtolower($key), strtolower($val));
            $signedHeaders[] = strtolower($key);
        }
        $canonicalHeaders = implode("\n", $canonicalHeaders) . "\n";
        $signedHeaders = implode(';', $signedHeaders);

        // Add required query parameters.
        $params['X-Goog-Algorithm'] = self::V4_ALGO_NAME;
        $params['X-Goog-Credential'] = $credential;
        $params['X-Goog-Date'] = $requestTimestamp;
        $params['X-Goog-Expires'] = $expires - time();
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
        $signature = bin2hex(base64_decode($this->signer->signBlob(
            $credentials,
            $stringToSign,
            $options['forceOpenssl']
        )));

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
            'queryParams' => []
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

        $headers = [];
        foreach ($options['headers'] as $name => $value) {
            // Linebreaks are not allowed in headers.
            // Rather than strip, we throw because we don't want to change the expected value without the user knowing.
            if (is_string($value) && strpos($value, PHP_EOL) !== false) {
                throw new \InvalidArgumentException(
                    'Line endings are not allowed in header values. Replace line endings with a single space.'
                );
            }

            // collapse arrays of values into a comma-separated list.
            if (is_array($value)) {
                $options['headers'][$name] = implode(',', array_map('trim', $value));
            }
        }

        // For backwards compatibility, strip protocol from cname.
        $cnameParts = explode('//', $options['cname']);
        if (count($cnameParts) > 1) {
            $options['cname'] = $cnameParts[1];
        }

        $options['cname'] = trim($options['cname'], '/');

        return $options;
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
