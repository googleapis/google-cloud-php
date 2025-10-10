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
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class SnapshotTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    private $timestamp;
    private $snapshot;
    private $directedReadOptionsIncludeReplicas;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->timestamp = new Timestamp(new \DateTime());

        $args = [
            'id' => 'foo',
            'readTimestamp' => $this->timestamp
        ];

        $this->snapshot = new Snapshot(
            $this->prophesize(Operation::class)->reveal(),
            $this->prophesize(Session::class)->reveal(),
            $args
        );
        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [
                    'location' => 'us-central1'
                ]
            ]
        ];
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

    public function testWithInvalidTimestamp()
    {
        $this->expectException(InvalidArgumentException::class);

        $args = [
            'readTimestamp' => 'foo'
        ];

        new Snapshot(
            $this->prophesize(Operation::class)->reveal(),
            $this->prophesize(Session::class)->reveal(),
            $args
        );
    }

    public function testSingleUseFailsOnSecondUse()
    {
        $this->expectException(\BadMethodCallException::class);

        $operation = $this->prophesize(Operation::class);
        $result = $this->prophesize(Result::class);
        $operation->execute(Argument::any(), Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($result);

        $snapshot = new Snapshot(
            $operation->reveal(),
            $this->prophesize(Session::class)->reveal()
        );

        $snapshot->execute('foo');
        $snapshot->execute('foo');
    }

    public function testExecuteDirectedReadOptions()
    {
        $operation = $this->prophesize(Operation::class);
        $result = $this->prophesize(Result::class);
        $operation->execute(Argument::any(), Argument::any(), Argument::withEntry(
            'directedReadOptions',
            $this->directedReadOptionsIncludeReplicas
        ))->shouldBeCalled()->willReturn($result);
        $operation->execute(Argument::any(), Argument::any(), Argument::withEntry(
            'headers',
            ['x-goog-spanner-route-to-leader' => ['true']]
        ))->shouldNotBeCalled();

        $snapshot = new Snapshot(
            $operation->reveal(),
            $this->prophesize(Session::class)->reveal(),
            ['directedReadOptions' => $this->directedReadOptionsIncludeReplicas]
        );

        $snapshot->execute('foo');
    }

    public function testReadDirectedReadOptions()
    {
        $keySet = new KeySet([
            'keys' => [1337]
        ]);
        $columns = ['ID', 'title', 'content'];

        $operation = $this->prophesize(Operation::class);
        $result = $this->prophesize(Result::class);
        $operation->read(Argument::any(), Argument::any(), Argument::any(), Argument::any(), Argument::withEntry(
            'directedReadOptions',
            $this->directedReadOptionsIncludeReplicas
        ))->shouldBeCalled()->willReturn($result);
        $operation->read(Argument::any(), Argument::any(), Argument::any(), Argument::any(), Argument::withEntry(
            'headers',
            ['x-goog-spanner-route-to-leader' => ['true']]
        ))->shouldNotBeCalled();

        $snapshot = new Snapshot(
            $operation->reveal(),
            $this->prophesize(Session::class)->reveal(),
            ['directedReadOptions' => $this->directedReadOptionsIncludeReplicas]
        );

        $snapshot->read('foo', $keySet, $columns);
    }
}
