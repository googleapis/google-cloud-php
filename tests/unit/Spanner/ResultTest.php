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

use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Transaction;

/**
 * @group spanner
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    use ResultTestTrait;

    /**
     * @dataProvider streamingDataProvider
     */
    public function testRows($chunks, $expectedValues)
    {
        $result = iterator_to_array($this->getResultClass($chunks));

        $this->assertEquals($expectedValues, $result);
    }

    public function testIterator()
    {
        $fixture = $this->getStreamingDataFixture()['tests'][0];
        $result = iterator_to_array($this->getResultClass($fixture['chunks']));

        $this->assertEquals($fixture['result']['value'], $result);
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
}
