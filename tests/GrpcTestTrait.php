<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests;

use Google\Protobuf\Any;
use Google\Rpc\Status;

/**
 * Provides checks for whether to run gRPC tests
 */
trait GrpcTestTrait
{
    /**
     * @param \Google\Rpc\Code $code
     * @param String $message
     * @return Status
     */
    public static function createStatus($code, $message)
    {
        $status = new Status();
        $status->setCode($code);
        $status->setMessage($message);
        return $status;
    }

    /**
     * @param $value \Google\Protobuf\Internal\Message;
     * @return Any
     */
    public static function createAny($value)
    {
        $any = new Any();
        $any->setValue($value->serializeToString());
        return $any;
    }

    public static function checkAndSkipGrpcTests()
    {
        if (!extension_loaded('grpc')) {
            self::markTestSkipped('Must have the grpc extension installed to run this test.');
        }
        if (defined('HHVM_VERSION')) {
            self::markTestSkipped('gRPC is not supported on HHVM.');
        }
    }

    public static function shouldSkipGrpcTests()
    {
        return !extension_loaded('grpc') || defined('HHVM_VERSION');
    }
}
