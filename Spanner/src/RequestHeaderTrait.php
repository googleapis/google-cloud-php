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
     * @param string $context
     * @param bool $value
     * @return array
     */
    private function addLarHeader(
        array $args,
        string $context = SessionPoolInterface::CONTEXT_READWRITE,
        bool $value = true
    ) {
        if ($value &&  !($context === SessionPoolInterface::CONTEXT_READ)) {
            $args['headers']['x-goog-spanner-route-to-leader'] = $value;
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
