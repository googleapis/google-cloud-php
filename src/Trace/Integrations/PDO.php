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
 * This class handles instrumenting PDO requests using the stackdriver_trace extension.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\PDO
 *
 * PDO::load();
 */
class PDO
{
    /**
     * Static method to add instrumentation to the PDO requests
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        stackdriver_trace_method('PDO', 'exec', function ($scope, $query) {
            return [
                'labels' => ['query' => $query]
            ];
        });
        stackdriver_trace_method('PDO', 'query', function ($scope, $query) {
            return [
                'labels' => ['query' => $query]
            ];
        });
        stackdriver_trace_method('PDO', 'commit');
        stackdriver_trace_method('PDO', '__construct', function ($scope, $dsn) {
            return [
                'labels' => ['dsn' => $dsn]
            ];
        });
        stackdriver_trace_method('PDOStatement', 'execute', function ($scope, $params) {
            return [
                'labels' => ['query' => $scope->queryString]
            ];
        });
    }
}
