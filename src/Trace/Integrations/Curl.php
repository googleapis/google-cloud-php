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
 * This class handles instrumenting curl requests using the stackdriver_trace extension.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\Curl
 *
 * Curl::load();
 * ```
 */
class Curl implements IntegrationInterface
{
    /**
     * Static method to add instrumentation to curl requests
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        stackdriver_trace_function('curl_exec', function ($resource) {
            return [
                'labels' => [
                    'uri' => curl_getinfo($resource, CURLINFO_EFFECTIVE_URL)
                ]
            ];
        });
        stackdriver_trace_function('curl_multi_add_handle');
        stackdriver_trace_function('curl_multi_remove_handle');
    }
}
