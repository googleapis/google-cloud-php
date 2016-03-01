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

namespace Google\Gcloud;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * The HttpRequestWrapper is responsible for delivering and signing requests.
 */
class HttpRequestWrapper
{
    /**
     * @var array Credentials used to sign requests.
     */
    private $credentials;

    /**
     * @var callable A handler used to deliver Psr7 requests.
     */
    private $httpHandler;

    /**
     * @var callable A handler used to deliver Psr7 requests specifically for
     * authentication.
     */
    private $authHttpHandler;

    /**
     * @var StreamInterface Points to the keyfile downloaded from the Google
     * Developer's Console.
     */
    private $keyFileStream;

    /**
     * @var array Scopes to be used for the request.
     */
    private $scopes = [];

    /**
     * @param string $keyFile The contents of the service account credentials
     *        .json file retrieved from the Google Developers Console.
     * @param string $keyFilePath The full path to your service account
     *        credentials .json file retrieved from the Google Developers
     *        Console.
     * @param array $scopes Scopes to be used for the request.
     * @param callable $httpHandler A handler used to deliver Psr7 requests.
     * @param callable $authHttpHandler A handler used to deliver Psr7 requests
     *        specifically for authentication.
     */
    public function __construct(
        $keyFile = null,
        $keyFilePath = null,
        array $scopes = [],
        callable $httpHandler = null,
        callable $authHttpHandler = null
    ) {
        $this->httpHandler = $httpHandler ?: HttpHandlerFactory::build();
        $this->authHttpHandler = $authHttpHandler ?: $this->httpHandler;
        $this->scopes = $scopes;

        if ($keyFile || $keyFilePath) {
            $this->keyFileStream = Psr7\stream_for($keyFile ?: fopen($keyFilePath, 'r'));
        }
    }

    /**
     * Deliver the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @param array $options HTTP specific configuration options.
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        $httpHandler = $this->httpHandler;
        $signedRequest = $this->signRequest($request);

        try {
            return $httpHandler($signedRequest, $options);
        } catch (\Exception $ex) {
            $this->handleException($ex);
        }
    }

    /**
     * Sign the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @return RequestInterface
     */
    public function signRequest(RequestInterface $request)
    {
        if (!$this->credentials || $credentials['expiry'] < time()) {
            $this->credentials = $this->fetchCredentials();
        }

        return Psr7\modify_request($request, [
            'set_headers' => [
                'Authorization' => 'Bearer ' . $this->credentials['access_token']
            ]
        ]);
    }

    /**
     * Fetches credentials.
     *
     * @return array
     */
    private function fetchCredentials()
    {
        if ($this->keyFileStream) {
            $credentialsFetcher = CredentialsLoader::makeCredentials($this->scopes, $this->keyFileStream);
        } else {
            $credentialsFetcher = ApplicationDefaultCredentials::getCredentials($this->scopes);
        }

        $credentials = $credentialsFetcher->fetchAuthToken($this->authHttpHandler);
        $credentials['expiry'] = time() + $this->credentials['expires_in'];

        return $credentials;
    }

    /**
     * Maps encountered exceptions to local exceptions.
     *
     * @param \Exception $ex
     * @throws \Exception
     * @todo map to custom exceptions
     */
    private function handleException(\Exception $ex)
    {
        switch ($ex->getCode()) {
            case 409:
                throw new \Exception('Conflict');
            default:
                throw new \Exception('Default');
        }
    }
}
