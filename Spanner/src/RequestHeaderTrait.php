<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Shared methods for Leader Aware Routing (LAR).
 */
trait RequestHeaderTrait
{
    /**
     * Add the `x-goog-spanner-route-to-leader` header value to the request.
     *
     * @param array $args
     * @param bool $value
     * @param string $context
     * @return array
     */
    private function addLarHeader(
        array $args,
        bool $value = true,
        string $context = SessionPoolInterface::CONTEXT_READWRITE
    ) {
        // If value is false, set LAR header to false and return.
        if (!$value) {
            return $this->conditionallyUnsetLarHeader($args, $value);
        }
        // If value is true and context is READWRITE, set LAR header.
        if ($context === SessionPoolInterface::CONTEXT_READWRITE) {
            $args['headers']['x-goog-spanner-route-to-leader'] = $value;
        }
        return $args;
    }

    /**
     * Conditionally unset the LAR header.
     *
     * @param array $args
     * @param bool $value
     * @return array
     */
    private function conditionallyUnsetLarHeader(
        array $args,
        bool $value = true
    ) {
        if (!$value) {
            unset($args['headers']['x-goog-spanner-route-to-leader']);
        }
        return $args;
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args
     * @param string $value
     * @return array
     */
    private function addResourcePrefixHeader(array $args, $value)
    {
        $args['headers']['google-cloud-resource-prefix'] = [$value];
        return $args;
    }
}
