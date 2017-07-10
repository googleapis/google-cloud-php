<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace\Integrations;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * This class handles instrumenting Guzzle http synchronous requests using the stackdriver_trace extension.
 * Asynchronous requests are not instrumented because the work may be done outside of PHP via streams so
 * any trace spans would be misleading.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\Guzzle
 *
 * Guzzle::load();
 */
class Guzzle implements IntegrationInterface
{
    /**
     * Static method to add instrumentation to Guzzle http synchronous requests
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        $version = ClientInterface::VERSION;
        switch ($version[0]) {
            case '5':
                self::loadGuzzle5();
                break;
            case '6':
                self::loadGuzzle6();
                break;
            default:
                throw new \Exception("Version '$version' not supported");
        }
    }

    /**
     * Add Guzzle 5 specific integrations
     */
    protected static function loadGuzzle5()
    {
        // public function send(RequestInterface $request)
        stackdriver_trace_method(Client::class, 'send', function ($scope, $request) {
            return [
                'labels' => [
                    'method' => $request->getMethod(),
                    'uri' => $request->getUrl()
                ]
            ];
        });
    }

    /**
     * Add Guzzle 6 specific integrations
     */
    protected static function loadGuzzle6()
    {
        // public function send(RequestInterface $request, array $options = [])
        stackdriver_trace_method(Client::class, 'send', function ($scope, $request) {
            return [
                'labels' => [
                    'method' => $request->getMethod(),
                    'uri' => (string)$request->getUri()
                ]
            ];
        });

        // public function request($method, $uri = '', array $options = [])
        stackdriver_trace_method(Client::class, 'request', function ($scope, $method, $uri) {
            return [
                'labels' => [
                    'method' => $method,
                    'uri' => $uri
                ]
            ];
        });
    }
}
