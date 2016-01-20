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
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;

// @todo finish!
class HttpRequestWrapper
{
    public function __construct(array $config = [])
    {
        $config = $config + [
            'httpHandler' => null,
            'keyFilePath' => null,
            'keyFile' => null
        ];

        $this->httpHandler = $config['httpHandler'] ?: HttpHandlerFactory::build();

        // @todo address this
        $credentialsFetcher = ApplicationDefaultCredentials::getCredentials($config['scope']);
        $this->token = $credentialsFetcher->fetchAuthToken()['access_token'];
    }

    public function send($method, $uri = null, $body = null, $headers = [], array $options = [])
    {
        $httpHandler = $this->httpHandler;

        $request = new Request(
            $method,
            $uri,
            $headers + ['Authorization' => 'Bearer ' . $this->token],
            $body
        );

        try {
            return $httpHandler($request, $options);
        } catch (\Exception $ex) {
            var_dump((string)$ex->getResponse()->getBody());
            $this->handleException($ex);
        }
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
