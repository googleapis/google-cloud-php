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
     * Adds/Modifys header values properly, i.e. replaces the each value's
     * name with new value if it already exist, else adds the value to header
     * line.
     *
     * @param Request $request The request object to modify.
     * @param string $headerKey The header key to append upon.
     * @param array $values The values to append to the header key.
     * @param string $delimiter Delimiter to separate the each value of $values
     * @return Request
     */
    private function appendOrModifyHeaders(
        Request $request,
        string $headerKey,
        array $values,
        string $delimiter = '/'
    ) {
        $headerValues = [];
        $headerLine = $request->getHeaderLine($headerKey);
        $splitHeaders = explode(' ', $headerLine);
        foreach ($splitHeaders as $value) {
            $elements = explode('/', $value);
            $headerValues[$elements[0]] = $elements[1];
        }
        foreach ($values as $value) {
            $elements = explode('/', $value);
            $headerValues[$elements[0]] = $elements[1];
        }
        foreach ($headerValues as $key => &$value) {
            $value = $key . '/' . $value;
        }
        $finalHeaderString = implode(' ', $headerValues);
        $request = Utils::modifyRequest($request, [
            'set_headers' => [
                $headerKey => $finalHeaderString
            ]
        ]);
        return $request;
    }
}
