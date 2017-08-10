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

/**
 * This class handles instrumenting memcache requests using the stackdriver_trace extension.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\Memcache
 *
 * Memcache::load();
 */
class Memcache implements IntegrationInterface
{
    /**
     * Static method to add instrumentation to memcache requests
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        $labelKeys = function ($memcache, $keyOrKeys) {
            $key = is_array($keyOrKeys) ? implode(",", $keyOrKeys) : $keyOrKeys;
            return [
                'labels' => ['key' => $key]
            ];
        };

        // bool Memcache::add ( string $key , mixed $var [, int $flag [, int $expire ]] )
        stackdriver_trace_method('Memcache', 'add', $labelKeys);

        // string Memcache::get ( string $key [, int &$flags ] )
        // array Memcache::get ( array $keys [, array &$flags ] )
        stackdriver_trace_method('Memcache', 'get', $labelKeys);

        // bool Memcache::set ( string $key , mixed $var [, int $flag [, int $expire ]] )
        stackdriver_trace_method('Memcache', 'set', $labelKeys);

        // bool Memcache::delete ( string $key [, int $timeout = 0 ] )
        stackdriver_trace_method('Memcache', 'delete', $labelKeys);

        stackdriver_trace_method('Memcache', 'flush');

        // bool Memcache::replace ( string $key , mixed $var [, int $flag [, int $expire ]] )
        stackdriver_trace_method('Memcache', 'replace', $labelKeys);

        // int Memcache::increment ( string $key [, int $value = 1 ] )
        stackdriver_trace_method('Memcache', 'increment', $labelKeys);

        // int Memcache::decrement ( string $key [, int $value = 1 ] )
        stackdriver_trace_method('Memcache', 'decrement', $labelKeys);

        // bool Memcache::connect ( string $host [, int $port [, int $timeout ]] )
        stackdriver_trace_method('Memcache', 'connect', function ($host) {
            return [
                'labels' => [
                    'host' => $host
                ]
            ];
        });
    }
}
