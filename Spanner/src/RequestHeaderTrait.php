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
 * Shared functionality for request headers.
 *
 * @internal
 */
trait RequestHeaderTrait
{
    private static $larHeader = 'x-goog-spanner-route-to-leader';
    private static $resourcePrefixHeader = 'google-cloud-resource-prefix';

    /**
     * Add the `x-goog-spanner-route-to-leader` header value to the request.
     *
     * @param array $args Request arguments.
     * @param bool $value LAR header value.
     * @param string $context Transaction context.
     * @return array
     */
    private function addLarHeader(
        array $args,
        bool $value = true,
        string $context = SessionPoolInterface::CONTEXT_READWRITE
    ) {
        if (!$value) {
            return $args;
        }
        // If value is true and context is READWRITE, set LAR header.
        if ($context === SessionPoolInterface::CONTEXT_READWRITE) {
            $args['headers'][self::$larHeader] = ['true'];
        }
        return $args;
    }

    /**
     * Conditionally unset the LAR header.
     *
     * @param array $args Request arguments.
     * @param bool $value Whether to set or unset the LAR header.
     * @return array
     */
    private function conditionallyUnsetLarHeader(
        array $args,
        bool $value = true
    ) {
        if (!$value) {
            unset($args['headers'][self::$larHeader]);
        }
        return $args;
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args Request arguments.
     * @param string $value Resource prefix header value.
     * @return array
     */
    private function addResourcePrefixHeader(array $args, string $value)
    {
        $args['headers'][self::$resourcePrefixHeader] = [$value];
        return $args;
    }
}
