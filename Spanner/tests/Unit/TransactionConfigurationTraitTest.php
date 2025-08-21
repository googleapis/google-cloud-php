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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\TransactionConfigurationTrait;
use Google\Protobuf\Duration;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 * @group spanner-transaction-configuration-trait
 */
class TransactionConfigurationTraitTest extends TestCase
{
    use GrpcTestTrait;
    use TimeTrait;

    const TRANSACTION = 'my-transaction';

    private $impl;
    private $ts;
    private $duration;
    private $dur = [];
    private $directedReadOptionsIncludeReplicas;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->impl = new TransactionConfigurationTraitImplementation();
        $this->duration = new Duration(['seconds' => 10, 'nanos' => 1]);
        $this->dur = new Duration(['seconds' => 10, 'nanos' => 1]);
        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [
                    'location' => 'us-central1'
                ]
            ]
        ];
    }

    public function testTransactionSelectorBasicSnapshot()
    {
        $args = [];
        $res = $this->impl->transactionSelector($args);
        $this->assertEquals(SessionPoolInterface::CONTEXT_READ, $res[1]);
        $this->assertEquals($res[0]['singleUse']['readOnly'], ['strong' => true]);
    }

    public function testTransactionSelectorExistingId()
    {
        $args = ['transactionId' => self::TRANSACTION];
        $res = $this->impl->transactionSelector($args);
        $this->assertEquals(SessionPoolInterface::CONTEXT_READ, $res[1]);
        $this->assertEquals(self::TRANSACTION, $res[0]['id']);
    }

    public function testTransactionSelectorReadWrite()
    {
        $args = ['transactionType' => SessionPoolInterface::CONTEXT_READWRITE];
        $res = $this->impl->transactionSelector($args);
        $this->assertEquals(SessionPoolInterface::CONTEXT_READWRITE, $res[1]);
        $this->assertEquals($this->impl->configureReadWriteTransactionOptions([]), $res[0]['singleUse']);
    }

    public function testTransactionSelectorReadOnly()
    {
        $args = ['transactionType' => SessionPoolInterface::CONTEXT_READ];
        $res = $this->impl->transactionSelector($args);
        $this->assertEquals(SessionPoolInterface::CONTEXT_READ, $res[1]);
    }

    public function testBegin()
    {
        $args = ['begin' => true];
        $res = $this->impl->transactionSelector($args);
        $this->assertEquals(SessionPoolInterface::CONTEXT_READ, $res[1]);
        $this->assertEquals($res[0]['begin']['readOnly'], ['strong' => true]);
    }

    public function testConfigureReadOnlyTransactionOptionsReturnReadTimestamp()
    {
        $args = ['returnReadTimestamp' => true];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertTrue($res['readOnly']['returnReadTimestamp']);
    }

    public function testConfigureReadOnlyTransactionOptionsStrong()
    {
        $args = ['strong' => true];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertTrue($res['readOnly']['strong']);
    }

    /**
     * @dataProvider timestamps
     */
    public function testConfigureReadOnlyTransactionOptionsMinReadTimestamp($timestamp, $expected = null)
    {
        $time = $this->parseTimeString($timestamp);
        $ts = new Timestamp($time[0], $time[1]);
        $args = ['minReadTimestamp' => $ts, 'singleUse' => true];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertEquals($expected ?: $timestamp, $res['readOnly']['minReadTimestamp']);
    }

    /**
     * @dataProvider timestamps
     */
    public function testConfigureReadOnlyTransactionOptionsReadTimestamp($timestamp)
    {
        $time = $this->parseTimeString($timestamp);
        $ts = new Timestamp($time[0], $time[1]);
        $args = ['readTimestamp' => $ts];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertEquals($timestamp, $res['readOnly']['readTimestamp']);
    }

    public function testConfigureReadOnlyTransactionOptionsMaxStaleness()
    {
        $args = ['maxStaleness' => $this->duration, 'singleUse' => true];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertEquals($this->dur, $res['readOnly']['maxStaleness']);
    }

    public function testConfigureReadOnlyTransactionOptionsExactStaleness()
    {
        $args = ['exactStaleness' => $this->duration];
        $res = $this->impl->configureReadOnlyTransactionOptions($args);
        $this->assertEquals($this->dur, $res['readOnly']['exactStaleness']);
    }

    public function testTransactionSelectorInvalidContext()
    {
        $this->expectException(\BadMethodCallException::class);

        $args = ['transactionType' => 'foo'];
        $this->impl->transactionSelector($args);
    }

    public function testConfigureReadOnlyTransactionOptionsInvalidExactStaleness()
    {
        $this->expectException(\BadMethodCallException::class);

        $args = ['exactStaleness' => 'foo'];
        $this->impl->configureReadOnlyTransactionOptions($args);
    }

    public function testConfigureReadOnlyTransactionOptionsInvalidMaxStaleness()
    {
        $this->expectException(\BadMethodCallException::class);

        $args = ['maxStaleness' => 'foo'];
        $this->impl->configureReadOnlyTransactionOptions($args);
    }

    public function testConfigureReadOnlyTransactionOptionsInvalidMinReadTimestamp()
    {
        $this->expectException(\BadMethodCallException::class);

        $args = ['minReadTimestamp' => 'foo'];
        $this->impl->configureReadOnlyTransactionOptions($args);
    }

    public function testConfigureReadOnlyTransactionOptionsInvalidReadTimestamp()
    {
        $this->expectException(\BadMethodCallException::class);

        $args = ['readTimestamp' => 'foo'];
        $this->impl->configureReadOnlyTransactionOptions($args);
    }

    public function testRequestLevelConfigureDirectedReadOptions()
    {
        $requestOptions = [
            'transaction' => ['singleUse' => true],
            'directedReadOptions' => $this->directedReadOptionsIncludeReplicas
        ];
        $clientOptions = [];
        $res = $this->impl->configureDirectedReadOptions($requestOptions, $clientOptions);
        $this->assertEquals($res, $requestOptions['directedReadOptions']);
    }

    public function testClientLevelConfigureDirectedReadOptions()
    {
        $requestOptions = ['transaction' => ['singleUse' => true]];
        $clientOptions = $this->directedReadOptionsIncludeReplicas;
        $res = $this->impl->configureDirectedReadOptions($requestOptions, $clientOptions);
        $this->assertEquals($res, $clientOptions);
    }

    public function testPrioritizeRequestLevelConfigureDirectedReadOptions()
    {
        $requestOptions = [
            'transaction' => ['singleUse' => true],
            'directedReadOptions' => $this->directedReadOptionsIncludeReplicas
        ];
        $clientOptions = [
            'includeReplicas' => [
                'replicaSelections' => [
                    'location' => 'us-central2'
                ]
            ]
        ];
        $res = $this->impl->configureDirectedReadOptions($requestOptions, $clientOptions);
        $this->assertEquals($res, $requestOptions['directedReadOptions']);
    }

    public function timestamps()
    {
        return [
            ['2017-01-09T18:05:22.534799Z'],
            ['2017-01-09T18:05:22.235534799Z'],
        ];
    }
}

//@codingStandardsIgnoreStart
class TransactionConfigurationTraitImplementation
{
    use TransactionConfigurationTrait {
        transactionSelector as public;
        configureReadWriteTransactionOptions as public;
        configureReadOnlyTransactionOptions as public;
        configureDirectedReadOptions as public;
    }
}
//@codingStandardsIgnoreEnd
