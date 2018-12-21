<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

use Google\Rpc\Code;

/**
 * Utility class for retries.
 */
class RetryUtil
{
    /**
     * @var array
     */
    public static $retryableStatusCodes = [
       Code::DEADLINE_EXCEEDED => Code::DEADLINE_EXCEEDED,
       Code::ABORTED => Code::ABORTED,
       Code::UNAVAILABLE => Code::UNAVAILABLE
    ];

    /**
     * @var callable
     */
    private static $defaultRetryFunction;

    /**
     * Checks if code is retryable or not.
     *
     * @param int $code Code to check.
     * @return boolean
     */
    public static function isRetryable($code)
    {
        return isset(self::$retryableStatusCodes[$code]);
    }

    /**
     * Helper method to get default retry function.
     *
     * @return callable
     */
    public static function getDefaultRetryFunction()
    {
        if (self::$defaultRetryFunction === null) {
            self::$defaultRetryFunction = function ($ex) {
                return self::isRetryable($ex->getCode());
            };
        }
        return self::$defaultRetryFunction;
    }

    /**
     * Return value of `retries` in provided array if set.
     *
     * @param array $options
     * @return int
     */
    public static function getMaxRetries($options)
    {
        if (isset($options['retries'])) {
            return $options['retries'];
        }
        return null;
    }
}
