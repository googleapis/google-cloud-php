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
 * This class handles instrumenting mysql requests using the stackdriver_trace extension.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\Mysql
 *
 * Mysql::load();
 */
class Mysql
{
    /**
     * Static method to add instrumentation to mysql requests
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        stackdriver_trace_function('mysqli_query', function ($mysqli, $query) {
            return [
                'labels' => ['query' => $query]
            ];
        });
        stackdriver_trace_function('mysqli_prepare');
        stackdriver_trace_function('mysqli_commit');
        stackdriver_trace_function('mysqli_connect', function ($host) {
            return [
                'labels' => ['host' => $host]
            ];
        });
        stackdriver_trace_function('mysqli_stmt_execute');

        stackdriver_trace_method('mysqli', 'query', function ($mysqli, $query) {
            return [
                'labels' => ['query' => $query]
            ];
        });
        stackdriver_trace_method('mysqli', 'prepare');
        stackdriver_trace_method('mysqli', 'commit');
        stackdriver_trace_method('mysqli', '__construct', function ($mysqli, $host) {
            return [
                'labels' => ['host' => $host]
            ];
        });
        stackdriver_trace_method('mysqli', 'mysqli');
        stackdriver_trace_method('mysqli_stmt', 'execute');
    }
}
