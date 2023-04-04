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

/**
 * Provides a light wrapper around often used Header related functions.
 */
trait HeaderTrait
{
    /**
     * Amends the given header key with new value for a request such that
     * the $request headers aren't modified directly and instead $options array
     * which are applied to the request just before sending it at core level.
     * Thus the $request object remains the same between each retry request at
     * RequestWrappers' level.
     *
     * @param string $headerLine The header line to update.
     * @param array &$arguments The arguments array(passed by reference) used by
     *        execute method of ExponentialBackoff object.
     * @param string $value The value to be ammended in the header line.
     * @param bool $getHeaderFromRequest [optional] A flag which determines if
     *        existing header value is read from $request or from $options. It's
     *        useful to read from $options incase we update multiple values to a
     *        single header key.
     */
    private function updateHeader(
        $headerLine,
        &$arguments,
        $value,
        $getHeaderFromRequest = true
    ) {
        // Fetch request and options
        $request = $this->fetchRequest($arguments);
        $options = $this->fetchOptions($arguments);

        // add empty headers to handle requests where headers aren't passed.
        $options += [
            'headers' => []
        ];

        // Create the modified header
        $headerValue = '';
        if ($getHeaderFromRequest) {
            $headerValues = $request->getHeader($headerLine);
            $headerValues[] = $value;
            $headerValue = implode(' ', $headerValues);
        } else {
            $headerValue = (isset($options['headers']) &&
                isset($options['headers'][$headerLine]))
                ? $options['headers'][$headerLine]
                : '';
            if (empty($headerValue)) {
                $headerValue = $value;
            } else {
                $headerValue .= (' ' . $value);
            }
        }

        // Amend the $option's header value
        $options['headers'][$headerLine] = $headerValue;

        // Set the $argument's options array
        $this->setOptions($arguments, $options);
    }


    /**
     * This helper method fetches Request object from the $argument list.
     * @param mixed $arguments
     * @return Request|null
     */
    private function fetchRequest($arguments)
    {
        $request = null;
        foreach ($arguments as $argument) {
            if ($argument instanceof Request) {
                $request = $argument;
            }
        }
        return $request;
    }

    /**
     * This helper method fetches $options array from the $argument list.
     * @param mixed $arguments
     * @return array
     */
    private function fetchOptions($arguments)
    {
        foreach ($arguments as $argument) {
            if (is_array($argument) && isset($argument['headers'])) {
                return $argument;
            }
        }
        return [];
    }

    /**
     * This helper method sets the $options array in the $argument list
     * @param array &$arguments Argument list as reference
     * @param array $options
     * @return void
     */
    private function setOptions(array &$arguments, array $options)
    {
        foreach ($arguments as &$argument) {
            if (is_array($argument) && isset($argument['headers'])) {
                $argument = $options;
                break;
            }
        }
    }
}
