<?php

/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;

/**
 * Provides a light wrapper around often used request modification functions.
 *
 * @internal
 */
trait RequestTrait
{
    /**
     * Adds/Modifys header changes properly, i.e. replaces the each change's
     * name with new change if it already exist, else adds the change to header
     * line.
     *
     * Examples:
     * If headers = [
     *     'line1' => 'key1/value1 key2/value2'
     * ]
     *
     * Then the output headers for the respective following changes are as
     * follows:-
     *
     * When $headerLineName = 'line1', then
     *
     *     For $changes = ['key3/value3'] results in $headers =
     *     ['line1' => 'key1/value1 key2/value2 key3/value3']
     *
     *     For $changes = ['key1/value3'] results in $headers =
     *     ['line1' => 'key1/value3 key2/value2']
     *
     * When $headerLineName doesn't exist in headers, then $changes are just
     * added to the $headers under $headerLineName as key.
     *
     * @param Request $request The request object to modify.
     * @param string $headerLineName The header key to append upon.
     * @param array $changes The changes to append to the header key.
     * @param string $delimiter Delimiter to separate the each change of $changes
     * @return Request
     */
    private function appendOrModifyHeaders(
        Request $request,
        string $headerLineName,
        array $changes,
        string $delimiter = '/'
    ) {
        $headerLine = $request->getHeaderLine($headerLineName);

        // An associative array to contain final header values as
        // $headerValueKey => $headerValue
        $headerElements = [];

        // Adding existing values
        $headerLineValues = explode(' ', $headerLine);
        foreach ($headerLineValues as $value) {
            $key = explode($delimiter, $value)[0];
            $headerElements[$key] = $value;
        }

        // Adding changes with replacing value if $key already present
        foreach ($changes as $change) {
            $key = explode($delimiter, $change)[0];
            $headerElements[$key] = $change;
        }

        // Creating new request with header changes
        $request = Utils::modifyRequest($request, [
            'set_headers' => [
                $headerLineName => implode(' ', $headerElements)
            ]
        ]);

        return $request;
    }
}
