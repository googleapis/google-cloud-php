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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;
    use ResultTestTrait;

    private $metadata = [
        'rowType' => [
            'fields' => [
                [
                    'name' => 'f1',
                    'type' => 6
                ]
            ]
        ]
    ];

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
    }

    /**
     * @dataProvider streamingDataProvider
     */
    public function testRows($chunks, $expectedValues)
    {
        $result = iterator_to_array($this->getResultClass($chunks)->rows());

        $this->assertEquals($expectedValues, $result);
    }

    public function testIterator()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = iterator_to_array($this->getResultClass($fixture['chunks']));

        $this->assertEquals($fixture['result']['value'], $result);
    }

    public function testResumesBrokenStream()
    {
        $timesCalled = 0;
        $chunks = [
            [
                'metadata' => $this->metadata,
                'values' => ['a']
            ],
            [
                'values' => ['b'],
                'resumeToken' => 'abc'
            ],
            [
                'values' => ['c']
            ]
        ];

        $result = $this->getResultClass(
            null,
            'r',
            null,
            function () use ($chunks, &$timesCalled) {
                $timesCalled++;

                foreach ($chunks as $key => $chunk) {
                    if ($timesCalled === 1 && $key === 2) {
                        throw new ServiceException('Unavailable', 14);
                    }
                    yield $chunk;
                }

            }
        );
        iterator_to_array($result->rows());
        $this->assertEquals(2, $timesCalled);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\ServiceException
     */
    public function testThrowsExceptionWhenCannotRetry()
    {
        $chunks = [
            [
                'metadata' => $this->metadata,
                'values' => ['a']
            ],
            [
                'values' => ['b']
            ]
        ];

        $result = $this->getResultClass(
            null,
            'r',
            null,
            function () use ($chunks) {
                foreach ($chunks as $key => $chunk) {
                    if ($key === 1) {
                        throw new ServiceException('Should not retry this.');
                    }
                    yield $chunk;
                }

            }
        );
        iterator_to_array($result->rows());
    }

    public function testColumns()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = $this->getResultClass($fixture['chunks']);
        $expectedColumnNames = ['f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7'];

        $this->assertNull($result->columns());
        $result->rows()->next();
        $this->assertEquals($expectedColumnNames, $result->columns());
    }

    public function testMetadata()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = $this->getResultClass($fixture['chunks']);
        $expectedMetadata = json_decode($fixture['chunks'][0], true)['metadata'];

        $this->assertNull($result->stats());
        $result->rows()->next();
        $this->assertEquals($expectedMetadata, $result->metadata());
    }

    public function testSession()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = $this->getResultClass($fixture['chunks']);

        $this->assertInstanceOf(Session::class, $result->session());
    }

    public function testStats()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = $this->getResultClass($fixture['chunks']);
        $expectedStats = json_decode($fixture['chunks'][0], true)['stats'];

        $this->assertNull($result->stats());
        $result->rows()->next();
        $this->assertEquals($expectedStats, $result->stats());
    }

    public function testTransaction()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = $this->getResultClass($fixture['chunks'], 'rw');

        $this->assertNull($result->transaction());
        $result->rows()->next();
        $this->assertInstanceOf(Transaction::class, $result->transaction());
    }

    public function testSnapshot()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][1];
        $result = $this->getResultClass($fixture['chunks']);

        $this->assertNull($result->snapshot());
        $result->rows()->next();
        $this->assertInstanceOf(Snapshot::class, $result->snapshot());
    }

    public function testUsesCorrectDefaultFormatOption()
    {
        $mapper = $this->prophesize(ValueMapper::class);
        $mapper->decodeValues(
            Argument::any(),
            Argument::any(),
            'nameValuePair'
        );
        $result = $this->getResultClass([], 'r', $mapper->reveal());

        $rows = $result->rows();
        $rows->current();
    }

    /**
     * @dataProvider formatProvider
     */
    public function testRecievesCorrectFormatOption($format)
    {
        $mapper = $this->prophesize(ValueMapper::class);
        $mapper->decodeValues(
            Argument::any(),
            Argument::any(),
            $format
        );
        $result = $this->getResultClass([], 'r', $mapper->reveal());

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
