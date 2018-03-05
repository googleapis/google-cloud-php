<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Perf;

use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrLogger;
use PHPUnit\Framework\TestCase;

/**
 * @group logging
 */
class LoggingPerfTest extends TestCase
{
    /* @var PsrLogger */
    private $restClient;
    /* @var PsrLogger */
    private $grpcClient;

    public function setUp()
    {
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $this->restLogger = LoggingClient::psrBatchLogger(
            'perf-rest',
            [
                'clientConfig' => [
                    'keyFilePath' => $keyFilePath,
                    'transport' => 'rest'
                ]
            ]
        );
        $this->grpcLogger = LoggingClient::psrBatchLogger(
            'perf-grpc',
            [
                'clientConfig' => [
                    'keyFilePath' => $keyFilePath,
                    'transport' => 'grpc'
                ]
            ]
        );
    }

    public function testPerf()
    {
        $num = 20000;
        $start = microtime(true);
        for ($i = 0; $i < $num; $i++) {
            $this->restLogger->info('x');
        }
        $end = microtime(true);
        $restResult = $end - $start;
        echo PHP_EOL . 'rest took ' . $restResult . ' seconds for sending '
            . $num . ' logs';
        $start = microtime(true);
        for ($i = 0; $i < $num; $i++) {
            $this->grpcLogger->info('x');
        }
        $end = microtime(true);
        $grpcResult = $end - $start;
        echo PHP_EOL . 'grpc took ' . $grpcResult . ' seconds for sending '
            . $num . ' logs';
        $this->assertLessThan($restResult, $grpcResult, 'grpc should be faster');
    }
}
