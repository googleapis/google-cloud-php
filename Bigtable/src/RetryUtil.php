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

use Google\ApiCore\ApiException;
use Grpc;

class RetryUtil
{
    /**
     * @var array
     */
    public static $retryableStatusCodes = [
        Grpc\DEADLINE_EXCEEDED => Grpc\DEADLINE_EXCEEDED,
        Grpc\ABORTED => Grpc\ABORTED,
        Grpc\STATUS_UNAVAILABLE => Grpc\STATUS_UNAVAILABLE
    ];

    private static $defaultRetryFunction;

    public function isRetryable($code)
    {
        return isset(self::$retryableStatusCodes[$code]);
    }

    public static function getDefaultRetryFunction()
    {
        if (self::$defaultRetryFunction === null) {
            self::$defaultRetryFunction = function (ApiException $ex) {
                return self::isRetryable($ex->getCode());
            };
        }
        return self::$defaultRetryFunction;
    }

    public static function getMaxRetries($options)
    {
        if (isset($options['retries'])) {
            return $options['retries'];
        }
        return null;
    }
}
