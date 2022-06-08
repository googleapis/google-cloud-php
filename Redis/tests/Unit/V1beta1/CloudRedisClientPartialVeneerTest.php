<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Redis\Tests\Unit\V1beta1;

use Google\ApiCore\Transport\GrpcTransport;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Redis\V1beta1\CloudRedisClient;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group redis
 * @group gapic
 */
class CloudRedisClientPartialVeneerTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();
    }

    public function testRestTransportFails()
    {
        $this->expectException('InvalidArgumentException');

        new CloudRedisClient([
            'transport' => 'rest'
        ]);
    }

    public function testTransportDefaultsToGrpc()
    {
        $client = new CloudRedisPartial();
        $this->assertFalse(isset($client->initialOptions['transport']));
        $this->assertInstanceOf(GrpcTransport::class, $client->transport());
    }
}

//@codingStandardsIgnoreStart
class CloudRedisPartial extends CloudRedisClient
{
    public $initialOptions;
    public $modifiedOptions;

    public function transport()
    {
        return $this->getTransport();
    }

    protected function modifyClientOptions(array &$options)
    {
        $this->initialOptions = $options;
        parent::modifyClientOptions($options);
    }
}
//@codingStandardsIgnoreEnd
