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
use phpseclib\Crypt\RSA;

/**
 * Class Description
 */
class SigningHelper
{
    const DEFAULT_DOWNLOAD_URL = 'https://storage.googleapis.com';

    /**
     * @var FetchAuthTokenCredential
     */
    private $credentials;

    /**
     * The expiration time, in seconds from epoch.
     *
     * @var int
     */
    private $expires;

    /**
     * @var Signer
     */
    private $signer;

    /**
     * @param FetchAuthTokenInterface $credentials The currently authenticated
     *        credentials.
     * @param Timestamp|\DateTimeInterface|int $expires Specifies when the URL
     *        will expire. May provide an instance of {@see Google\Cloud\Core\Timestamp},
     *        [http://php.net/datetimeimmutable](`\DateTimeImmutable`), or a
     *        UNIX timestamp as an integer.
     */
    public function __construct(FetchAuthTokenInterface $credentials, $expires)
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

        if ($seconds < time()) {
            throw new \InvalidArgumentException('Expiration cannot be in the past.');
        }

        $this->credentials = $credentials;
        $this->expires = $expires;
        $this->signer = new Signer;
    }

    public function v4Sign(array $identity, array $options)
    {
        $options = $this->normalizeOptions($options);
    }

    public function v2Sign($uri, $resource, $generation, array $options)
    {
        $options = $this->normalizeOptions($options);

        // Make sure disallowed headers are not included.
        $illegalHeaders = [
            'x-goog-encryption-key',
            'x-goog-encryption-key-sha256'
        ];

        if ($illegal = array_intersect_key(array_flip($illegalHeaders), $options['headers'])) {
            throw new \InvalidArgumentException(sprintf(
                '%s %s not allowed in Signed URL headers.',
                implode(' and ', array_keys($illegal)),
                count($illegal) === 1 ? 'is' : 'are'
            ));
        }

        // Sort headers by name.
        ksort($options['headers']);

        $headers = [];
        foreach ($options['headers'] as $name => $value) {
            $name = strtolower(trim($name));

            $value = is_array($value)
                ? implode(',', array_map('trim', $value))
                : trim($value);

            // Linebreaks are not allowed in headers.
            // Rather than strip, we throw because we don't want to change the expected value without the user knowing.
            if (strpos($value, PHP_EOL) !== false) {
                throw new \InvalidArgumentException(
                    'Line endings are not allowed in header values. Replace line endings with a single space.'
                );
            }

            // Invalid header names throw exception.
            if (strpos($name, 'x-goog-') !== 0) {
                throw new \InvalidArgumentException(
                    'Header names must begin with `x-goog-`.'
                );
            }

            $headers[] = $name .':'. $value;
        }

        if ($headers) {
            $headers[] = '';
        }

        $toSign = [
            $options['method'],
            $options['contentMd5'],
            $options['contentType'],
            $this->expires,
            implode("\n", $headers) . $resource,
        ];

        // NOTE: While in most cases `PHP_EOL` is preferable to a system-specific character,
        // in this case `\n` is required.
        $string = implode("\n", $toSign);
        $signature = $this->signer->signBlob($this->credentials, $string, $options['forceOpenssl']);
        $encodedSignature = urlencode($signature);

        $query = [];
        $query[] = 'GoogleAccessId=' . $this->credentials->getClientEmail();
        $query[] = 'Expires=' . $this->expires;
        $query[] = 'Signature=' . $encodedSignature;

        if ($options['responseDisposition']) {
            $query[] = 'response-content-disposition=' . urlencode($options['responseDisposition']);
        } elseif ($options['saveAsName']) {
            $query[] = 'response-content-disposition=attachment;filename='
                . urlencode('"' . $options['saveAsName'] . '"');
        }

        if ($options['responseType']) {
            $query[] = 'response-content-type=' . urlencode($options['responseType']);
        }

        if ($generation) {
            $query[] = 'generation=' . $generation;
        }

        return $uri . '?' . implode('&', $query);
    }

    private function normalizeOptions(array $options)
    {
        $options += [
            'method' => 'GET',
            'cname' => self::DEFAULT_DOWNLOAD_URL,
            'contentMd5' => null,
            'contentType' => null,
            'headers' => [],
            'saveAsName' => null,
            'responseDisposition' => null,
            'responseType' => null,
            'keyFile' => null,
            'keyFilePath' => null,
            'allowPost' => false,
            'forceOpenssl' => false
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

        return $options;
    }
}
