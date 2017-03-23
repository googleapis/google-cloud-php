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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Spanner\Result;

/**
 * @group spanner
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    public function testIterator()
    {
        $result = new Result([], [
            ['name' => 'John']
        ]);

        $res = iterator_to_array($result);
        $this->assertEquals(1, count($res));
        $this->assertEquals('John', $res[0]['name']);
    }

    public function testMetadata()
    {
        $result = new Result(['metadata' => 'foo'], []);
        $this->assertEquals('foo', $result->metadata());
    }

    public function testRows()
    {
        $rows = [
            ['name' => 'John']
        ];

        $result = new Result([], $rows);

        $this->assertEquals($rows, $result->rows());
    }

    public function testFirstRow()
    {
        $rows = [
            ['name' => 'John'],
            ['name' => 'Dave']
        ];

        $result = new Result([], $rows);

        $this->assertEquals($rows[0], $result->firstRow());
    }

    public function testStats()
    {
        $result = new Result(['stats' => 'foo'], []);
        $this->assertEquals('foo', $result->stats());
    }

    public function testInfo()
    {
        $info = ['foo' => 'bar'];
        $result = new Result($info, []);

        $this->assertEquals($info, $result->info());
    }

    public function testTransaction()
    {
        $result = new Result([], [], [
            'transaction' => 'foo'
        ]);

        $this->assertEquals('foo', $result->transaction());

        $result = new Result([], []);

        $this->assertNull($result->transaction());
    }

    public function testSnapshot()
    {
        $result = new Result([], [], [
            'snapshot' => 'foo'
        ]);

        $this->assertEquals('foo', $result->snapshot());

        $result = new Result([], []);

        $this->assertNull($result->snapshot());
    }
}
