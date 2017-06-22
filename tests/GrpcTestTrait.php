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

/**
 * Provides checks for whether to run gRPC tests
 */
trait GrpcTestTrait
{
    public function checkAndSkipGrpcTests()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('gRPC is not supported on HHVM.');
        }
    }

    public function shouldSkipGrpcTests()
    {
        return !extension_loaded('grpc') || defined('HHVM_VERSION');
    }
}
