<?php
/**
 * Copyright 2020 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Unit\GapicBackoff;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Core\Testing\GrpcTestTrait;

/**
 * @group spanner
 * @group spanner-gapic-backoff
 */
class GapicBackoffTest extends TestCase
{
    use GrpcTestTrait;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();
    }

    /**
     * @param array $config
     * @return \Google\Cloud\Core\GrpcRequestWrapper
     */
    private function getWrapper($config)
    {
        $config += [
            'apiEndpoint' => '127.0.0.1:10',
            'hasEmulator' => true,
        ];

        $spanner = new SpannerClient($config);
        $connection = $spanner->instance('nonexistent')->database('nonexistent')->connection();
        return $connection->requestWrapper();
    }

    public function provideDisabledBackoffConfigs()
    {
        return [
            [[]],
            [['useDiscreteBackoffs' => false]],
        ];
    }

    /**
     * @dataProvider provideDisabledBackoffConfigs
     * @param array $config
     */
    public function testBackoffDisabledByDefault($config)
    {
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]]);
        $expected = [
            'retriesEnabled' => false,
        ];
        $this->assertEquals($expected, $response->options['retrySettings']);
    }

    public function testBackoffEnabledManually()
    {
        $config = [
            'useDiscreteBackoffs' => true,
        ];
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]]);
        $expected = [];
        $this->assertEquals($expected, $response->options['retrySettings']);
    }

    public function testUserConfigsAreNotRuined()
    {
        $retrySettings = [
            'retriesEnabled' => false,
            'noRetriesRpcTimeoutMillis' => 1234,
        ];
        $config = [
            'useDiscreteBackoffs' => true,
            'grpcOptions' => [
                'retrySettings' => $retrySettings,
            ],
        ];
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]]);
        $this->assertEquals($retrySettings, $response->options['retrySettings']);
    }
}
