<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Grpc;

use InvalidArgumentException;

/**
 * Provides basic array helper methods.
 */
trait CallTrait
{
    private static function setCustomHeader($callable, $headerDescriptor, $userHeaders = null)
    {
        $inner = function () use ($callable, $headerDescriptor, $userHeaders) {
            $params = func_get_args();
            if (count($params) != self::CALLABLE_PARAM_COUNT ||
                !is_array($params[self::CALLABLE_METADATA_INDEX])
            ) {
                throw new InvalidArgumentException('Metadata argument is not found.');
            } else {
                $metadata = $params[self::CALLABLE_METADATA_INDEX];
                $headers = [];
                // Check $userHeaders first, and then merge $headerDescriptor headers, to ensure
                // that $headerDescriptor headers such as x-goog-api-client cannot be overwritten
                // by the $userHeaders.
                if (!is_null($userHeaders)) {
                    $headers = $userHeaders;
                }
                if (!is_null($headerDescriptor)) {
                    $headers = array_merge($headers, $headerDescriptor->getHeader());
                }
                $params[self::CALLABLE_METADATA_INDEX] = array_merge($headers, $metadata);
                return call_user_func_array($callable, $params);
            }
        };
        return $inner;
    }
}