<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Upload;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\RequestWrapper;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Upload data to Cloud Storage using a Signed URL
 */
class SignedUrlUploader extends ResumableUploader
{
    /**
     * @param RequestWrapper $requestWrapper
     * @param string|resource|StreamInterface $data
     * @param string $uri
     * @param array $options [optional] {
     *     Optional configuration.
     *
     *     @type array $metadata Metadata on the resource.
     *     @type int $chunkSize Size of the chunks to send incrementally during
     *           a resumable upload. Must be in multiples of 262144 bytes.
     *     @type array $restOptions HTTP client specific configuration options.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0`.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type string $contentType Content type of the resource.
     *     @type string $origin If the target has Cross-Origin Resource Sharing
     *           enabled, the value of the Origin header to be used in upload
     *           requests.
     * }
     */
    public function __construct(
        RequestWrapper $requestWrapper,
        $data,
        $uri,
        array $options = []
    ) {
        if (isset($options['origin'])) {
            $this->headers['Origin'] = $options['origin'];
            unset($options['origin']);
        }

        parent::__construct($requestWrapper, $data, $uri, $options);

        // Signed URLs are pre-authorized via their query-string signature and
        // must not attach ambient OAuth bearer tokens or quota project headers.
        $this->requestOptions['shouldSignRequest'] = false;
    }

    /**
     * Creates the resume URI.
     *
     * @return string
     * @throws \InvalidArgumentException When the configured signed upload URI is
     *         invalid.
     * @throws GoogleException When the response Location header is missing,
     *         invalid, or does not match the configured upload endpoint origin.
     */
    protected function createResumeUri()
    {
        $expectedUri = $this->parseEndpointUri($this->uri, 'Configured upload endpoint');

        $headers = $this->headers + [
            'Content-Type' => $this->contentType,
            'Content-Length' => '0',
            'x-goog-resumable' => 'start'
        ];

        $request = new Request(
            'POST',
            (string) $expectedUri,
            $headers
        );

        $response = $this->requestWrapper->send($request, $this->requestOptions);

        return $this->resumeUri = $this->validateLocationUri(
            $response->getHeaderLine('Location'),
            $expectedUri
        );
    }

    /**
     * Decode the response body
     *
     * @param ResponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return $response->getBody();
    }

    /**
     * Validates that the response Location header matches the configured signed
     * upload URI's scheme, host, port, and userinfo, and returns its canonical
     * string representation.
     *
     * @param string $location
     * @param Uri $expectedUri
     * @return string
     * @throws GoogleException
     */
    private function validateLocationUri(string $location, Uri $expectedUri): string
    {
        try {
            $parsedLocation = $this->parseEndpointUri($location, 'Resume Location URI');
        } catch (\InvalidArgumentException $e) {
            throw new GoogleException($e->getMessage());
        }

        if ($parsedLocation->getScheme() !== $expectedUri->getScheme()
            || $parsedLocation->getHost() !== $expectedUri->getHost()
            || $parsedLocation->getPort() !== $expectedUri->getPort()
        ) {
            $expectedOrigin = $expectedUri->getScheme() . '://' . $expectedUri->getHost();
            if ($expectedUri->getPort() !== null) {
                $expectedOrigin .= ':' . $expectedUri->getPort();
            }

            throw new GoogleException(sprintf(
                'Resume Location URI origin does not match the configured upload endpoint origin (%s).',
                $expectedOrigin
            ));
        }

        if ($parsedLocation->getUserInfo() !== $expectedUri->getUserInfo()) {
            throw new GoogleException(
                'Resume Location URI userinfo does not match the configured upload endpoint.'
            );
        }

        return (string) $parsedLocation;
    }

    /**
     * Parses and validates an HTTP(S) URI without leaking raw URI values in
     * exception messages.
     *
     * @param mixed $uri
     * @param string $label
     * @return Uri
     * @throws \InvalidArgumentException
     */
    private function parseEndpointUri($uri, string $label): Uri
    {
        $uriString = (is_string($uri) || $uri instanceof UriInterface) ? (string) $uri : '';
        if ($uriString === '') {
            throw new \InvalidArgumentException(sprintf('%s must be a non-empty string or UriInterface.', $label));
        }

        if (preg_match('/[\x00-\x1F\x7F]/', $uriString) !== 0) {
            throw new \InvalidArgumentException(sprintf('%s must not contain control characters.', $label));
        }

        $invalidSchemeOrHostMsg = sprintf('%s must include a valid HTTP(S) scheme and host.', $label);
        if (preg_match('/\Ahttps?:\/\//i', $uriString) !== 1) {
            throw new \InvalidArgumentException($invalidSchemeOrHostMsg);
        }

        try {
            $parsedUri = new Uri($uriString);
        } catch (\InvalidArgumentException) {
            // Intentionally drop Guzzle's MalformedUriException to avoid leaking raw URIs/tokens via $previous.
            throw new \InvalidArgumentException(sprintf('%s is not a valid URI.', $label));
        }

        if (!in_array($parsedUri->getScheme(), ['http', 'https'], true) || $parsedUri->getHost() === '') {
            throw new \InvalidArgumentException($invalidSchemeOrHostMsg);
        }

        return $parsedUri;
    }
}
