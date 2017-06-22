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

use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class SnapshotTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    private $timestamp;
    private $snapshot;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->timestamp = new Timestamp(new \DateTime);

        $args = [
            'id' => 'foo',
            'readTimestamp' => $this->timestamp
        ];

        $this->snapshot = new Snapshot(
            $this->prophesize(Operation::class)->reveal(),
            $this->prophesize(Session::class)->reveal(),
            $args
        );
    }

    public function testTypeIsPreAllocated()
    {
        $this->assertEquals(Snapshot::TYPE_PRE_ALLOCATED, $this->snapshot->type());
    }

    public function testTypeIsSingleUse()
    {
        $snapshot = new Snapshot(
            $this->prophesize(Operation::class)->reveal(),
            $this->prophesize(Session::class)->reveal()
        );

        $this->assertEquals(Snapshot::TYPE_SINGLE_USE, $snapshot->type());
    }

    public function testReadTimestamp()
    {
        $this->assertEquals($this->timestamp, $this->snapshot->readTimestamp());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithInvalidTimestamp()
    {
        $args = [
            'readTimestamp' => 'foo'
        ];

        new Snapshot(
            $this->prophesize(Operation::class)->reveal(),
            $this->prophesize(Session::class)->reveal(),
            $args
        );
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSingleUseFailsOnSecondUse()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->execute(Argument::any(), Argument::any(), Argument::any())
            ->shouldBeCalled();

        $snapshot = new Snapshot(
            $operation->reveal(),
            $this->prophesize(Session::class)->reveal()
        );

        $snapshot->execute('foo');
        $snapshot->execute('foo');
    }
}
