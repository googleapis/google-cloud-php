<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class EmulatorTraitTest extends TestCase
{
    use GrpcTestTrait;

    private $impl;

    public function set_up()
    {
        $this->impl = TestHelpers::impl(EmulatorTrait::class);
    }

    /**
     * @dataProvider hostnames
     */
    public function testEmulatorGapicConfig($hostname, $expected = null)
    {
        $this->checkAndSkipGrpcTests();

        $expected = $expected ?: $hostname;

        $res = $this->impl->call('emulatorGapicConfig', [$hostname]);
        $this->assertEquals($expected, $res['apiEndpoint']);
        $this->assertNull($res['transportConfig']['grpc']['stubOpts']['credentials']);
    }

    public function hostnames()
    {
        return [
            ['localhost:0001'],
            ['http://localhost:0001', 'localhost:0001'],
        ];
    }

    public function testEmulatorBaseUri()
    {
        $host = 'localhost:9000';
        $this->assertEquals(
            sprintf('http://%s/', $host),
            $this->impl->call('emulatorBaseUri', [$host])
        );
    }

    public function testGetEmulatorBaseUriNoEmulator()
    {
        $res = $this->impl->getEmulatorBaseUri('http://google.com', null);

        $this->assertEquals('http://google.com', $res);
    }

    public function testGetEmulatorBaseUriEmulator()
    {
        $res = $this->impl->getEmulatorBaseUri('http://google.com', 'http://localhost:8080');

        $this->assertEquals('http://localhost:8080/', $res);
    }
}
