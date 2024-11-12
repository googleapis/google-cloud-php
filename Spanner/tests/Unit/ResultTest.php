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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-result
 */
class ResultTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    private const METADATA = [
        'rowType' => [
            'fields' => [
                [
                    'name' => 'f1',
                    'type' => 6
                ]
            ]
        ]
    ];
    private $operation;
    private $session;
    private $transaction;
    private $snapshot;
    private $mapper;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->operation = $this->prophesize(Operation::class);
        $this->session = $this->prophesize(Session::class);
        $this->transaction = $this->prophesize(Transaction::class);
        $this->snapshot = $this->prophesize(Snapshot::class);

        $this->mapper = $this->prophesize(ValueMapper::class);
        $this->mapper->decodeValues(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->will(function ($args) {
            return $args[1];
        });

        $this->operation->createSnapshot(
            $this->session->reveal(),
            Argument::type('array')
        )->willReturn($this->snapshot->reveal());

        $this->operation->createTransaction(
            $this->session->reveal(),
            Argument::type('array')
        )->willReturn($this->transaction->reveal());
    }

    /**
     * @dataProvider streamingDataProvider
     */
    public function testRows($chunks, $expectedValues)
    {
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks) {
                return $this->resultGeneratorJson($chunks);
            },
            'r',
            $this->mapper->reveal()
        );
        $this->assertEquals($expectedValues, iterator_to_array($result->rows()));
    }

    public function testIterator()
    {
        $fixtures = $this->getStreamingDataFixture()['tests'][0];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixtures) {
                return $this->resultGeneratorJson($fixtures['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );

        $this->assertEquals($fixtures['result']['value'], iterator_to_array($result));
    }

    public function testFailsWhenStreamThrowsUnrecoverableException()
    {
        $this->expectException(\Exception::class);

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () {
                throw new \Exception();
            },
            'r',
            $this->mapper->reveal()
        );
        iterator_to_array($result->rows());
    }

    public function testResumesBrokenStream()
    {
        $timesCalled = 0;
        $chunks = [
            [
                'metadata' => self::METADATA,
                'values' => ['a']
            ],
            [
                'values' => ['b'],
                'resumeToken' => 'abc'
            ],
            ['values' => ['c']]
        ];

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks, &$timesCalled) {
                $timesCalled++;

                foreach ($chunks as $key => $chunk) {
                    if ($timesCalled === 1 && $key === 2) {
                        throw new ServiceException('Unavailable', 14);
                    }
                    yield $chunk;
                }
            },
            'r',
            $this->mapper->reveal()
        );

        iterator_to_array($result->rows());
        $this->assertEquals(2, $timesCalled);
    }

    public function testResumesAfterStreamStartFailure()
    {
        $timesCalled = 0;
        $chunks = [
            [
                'metadata' => self::METADATA,
                'values' => ['a']
            ],
            ['values' => ['b']],
            ['values' => ['c']]
        ];

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks, &$timesCalled) {
                $timesCalled++;
                if ($timesCalled === 1) {
                    throw new ServiceException('Unavailable', 14);
                }

                foreach ($chunks as $key => $chunk) {
                    yield $chunk;
                }
            },
            'r',
            $this->mapper->reveal()
        );

        iterator_to_array($result->rows());
        $this->assertEquals(2, $timesCalled);
    }

    public function testRowsRetriesWithoutResumeTokenWhenNotYieldedRows()
    {
        $timesCalled = 0;
        $chunks = [
            [
                'metadata' => self::METADATA,
                'values' => ['a']
            ],
            ['values' => ['b']],
            ['values' => ['c']]
        ];

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks, &$timesCalled) {
                $timesCalled++;
                foreach ($chunks as $key => $chunk) {
                    if ($key === 1 && $timesCalled < 2) {
                        throw new ServiceException('Unavailable', 14);
                    }
                    yield $chunk;
                }
            },
            'r',
            $this->mapper->reveal()
        );

        iterator_to_array($result->rows());
        $this->assertEquals(2, $timesCalled);
    }

    public function testRowsRetriesWithResumeTokenWhenNotYieldedRows()
    {
        $timesCalled = 0;
        $chunks = [
            [
                'metadata' => self::METADATA,
                'values' => ['a'],
                'resumeToken' => 'abc'
            ],
            ['values' => ['b']],
            ['values' => ['c']]
        ];

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks, &$timesCalled) {
                $timesCalled++;
                foreach ($chunks as $key => $chunk) {
                    if ($key === 1 && $timesCalled < 2) {
                        throw new ServiceException('Unavailable', 14);
                    }
                    yield $chunk;
                }
            },
            'r',
            $this->mapper->reveal()
        );

        iterator_to_array($result->rows());
        $this->assertEquals(2, $timesCalled);
    }

    public function testThrowsExceptionWhenCannotRetry()
    {
        $this->expectException(ServiceException::class);

        $chunks = [
            [
                'metadata' => self::METADATA,
                'values' => ['a']
            ],
            ['values' => ['b']]
        ];

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($chunks) {
                foreach ($chunks as $key => $chunk) {
                    if ($key === 1) {
                        throw new ServiceException('Should not retry this.');
                    }
                    yield $chunk;
                }
            },
            'r',
            $this->mapper->reveal()
        );

        iterator_to_array($result->rows());
    }

    public function testColumns()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );
        $expectedColumnNames = ['f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7'];

        $this->assertNull($result->columns());
        $result->rows()->next();
        $this->assertEquals($expectedColumnNames, $result->columns());
    }

    public function testMetadata()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );
        $expectedMetadata = json_decode($fixture['chunks'][0], true)['metadata'];

        $this->assertNull($result->stats());
        $result->rows()->next();
        $this->assertEquals($expectedMetadata, $result->metadata());
    }

    public function testSession()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );

        $this->assertInstanceOf(Session::class, $result->session());
    }

    public function testStats()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );
        $expectedStats = json_decode($fixture['chunks'][0], true)['stats'];

        $this->assertNull($result->stats());
        $result->rows()->next();
        $this->assertEquals($expectedStats, $result->stats());
    }

    public function testTransaction()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'rw',
            $this->mapper->reveal()
        );

        $this->assertInstanceOf(Transaction::class, $result->transaction());
    }

    public function testSnapshot()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $this->mapper->reveal()
        );

        $this->assertInstanceOf(Snapshot::class, $result->snapshot());
    }

    public function testUsesCorrectDefaultFormatOption()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $mapper = $this->prophesize(ValueMapper::class);
        $mapper->decodeValues(
            Argument::any(),
            Argument::any(),
            'associative'
        )->shouldBeCalled();

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $mapper->reveal()
        );

        $rows = $result->rows();
        $rows->current();
    }

    /**
     * @dataProvider formatProvider
     */
    public function testRecievesCorrectFormatOption($format)
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $mapper = $this->prophesize(ValueMapper::class);
        $mapper->decodeValues(
            Argument::any(),
            Argument::any(),
            $format
        )->shouldBeCalled();

        $result = new Result(
            $this->operation->reveal(),
            $this->session->reveal(),
            function () use ($fixture) {
                return $this->resultGeneratorJson($fixture['chunks']);
            },
            'r',
            $mapper->reveal()
        );

        $rows = $result->rows($format);
        $rows->current();
    }

    public function formatProvider()
    {
        return [
            ['nameValuePair'],
            ['associative'],
            ['zeroIndexed']
        ];
    }
}
