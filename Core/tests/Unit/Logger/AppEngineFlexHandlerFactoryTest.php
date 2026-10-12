<?php
/**
 * Copyright 2019 Google LLC
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
namespace Google\Cloud\Core\Tests\Unit\Logger;

use Google\Cloud\Core\Logger\AppEngineFlexHandler;
use Google\Cloud\Core\Logger\AppEngineFlexHandlerFactory;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Google\Cloud\Core\Logger\AppEngineFlexHandlerV2;
use Google\Cloud\Core\Logger\AppEngineFlexHandlerV3;

/**
 * @group core
 * @group logger
 */
class AppEngineFlexHandlerFactoryTest extends TestCase
{
    public function testBuildMonologV1Handler()
    {
        $this->skipIfNotMonologVersion(1);

        $this->assertInstanceOf(AppEngineFlexHandler::class, AppEngineFlexHandlerFactory::build());
    }

    public function testBuildMonologV2Handler()
    {
        $this->skipIfNotMonologVersion(2);

        $this->assertInstanceOf(AppEngineFlexHandlerV2::class, AppEngineFlexHandlerFactory::build());
    }

    public function testBuildMonologV3Handler()
    {
        $this->skipIfNotMonologVersion(3);

        $this->assertInstanceOf(AppEngineFlexHandlerV3::class, AppEngineFlexHandlerFactory::build());
    }

    private function skipIfNotMonologVersion($expected)
    {
        $version = defined('Monolog\Logger::API') ? Logger::API : 1;

        if ($expected !== $version) {
            $this->markTestSkipped("Monolog {$expected} only");
        }
    }
}
