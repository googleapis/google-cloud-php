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

namespace Google\Cloud;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;

// @todo finish!
class HttpRequestWrapper
{
    private $credentials;
    private $httpHandler;
    private $scope;
    private $keyFileStream;

    public function __construct(array $config = [])
    {
        if (!array_key_exists('scope', $config)) {
            return \InvalidArgumentException('A scope is required.');
        }

        $config = $config + [
            'httpHandler' => null,
            'keyFilePath' => null,
            'keyFile' => null
        ];

        $this->scope = $config['scope'];
        $this->httpHandler = $config['httpHandler'] ?: HttpHandlerFactory::build();

        if ($config['keyFile'] || $config['keyFilePath']) {
            $keyFile = $config['keyFile'] ?: fopen($config['keyFilePath'], 'r');
            $this->keyFileStream = Psr7\stream_for($keyFile);
        }
    }

    public function send(RequestInterface $request, array $options = [])
    {
        $httpHandler = $this->httpHandler;

        $signedRequest = $this->signRequest($request);

        try {
            return $httpHandler($signedRequest, $options);
        } catch (\Exception $ex) {
            var_dump((string)$ex->getResponse()->getBody());
            $this->handleException($ex);
        }
    }

    private function signRequest(RequestInterface $request)
    {
        if (!$this->credentials) {
            $this->credentials = $this->fetchCredentials();
        }

        $expiry = $this->credentials['created_at'] + $this->credentials['expires_in'];

        if ($expiry < time()) {
            $this->credentials = $this->fetchCredentials();
        }

        return Psr7\modify_request($request, [
            'set_headers' => [
                'Authorization' => 'Bearer ' . $this->credentials['access_token']
            ]
        ]);
    }

    private function fetchCredentials()
    {
        if ($this->keyFileStream) {
            $credentialsFetcher = CredentialsLoader::makeCredentials($this->scope, $this->keyFileStream);
        } else {
            $credentialsFetcher = ApplicationDefaultCredentials::getCredentials($this->scope);
        }

        $credentials = $credentialsFetcher->fetchAuthToken($this->httpHandler);
        $credentials['created_at'] = time();

        return $credentials;
    }

    // @todo map to custom exceptions
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
