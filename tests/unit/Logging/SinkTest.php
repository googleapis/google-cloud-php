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

namespace Google\Cloud\Tests\Unit\Logging;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Logging\Sink;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group logging
 */
class SinkTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $formattedName;
    public $sinkName = 'mySink';
    public $projectId = 'myProjectId';
    public $sinkData = [
        'destination' => 'wow a destination'
    ];

    public function setUp()
    {
        $this->formattedName = "projects/$this->projectId/sinks/$this->sinkName";
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getSink($connection, array $data = [])
    {
        return new Sink($connection->reveal(), $this->sinkName, $this->projectId, $data);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getSink([
            'sinkName' => $this->formattedName,
        ])
            ->willReturn([
                'name' => $this->sinkName
            ])
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection);

        $this->assertTrue($sink->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getSink([
            'sinkName' => $this->formattedName,
        ])
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection);

        $this->assertFalse($sink->exists());
    }

    public function testDelete()
    {
        $this->connection->deleteSink([
            'sinkName' => $this->formattedName,
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection);

        $this->assertNull($sink->delete());
    }

    public function testUpdatesDataWithCachedData()
    {
        $this->connection->updateSink($this->sinkData + [
            'sinkName' => $this->formattedName,
        ])
            ->willReturn($this->sinkData)
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection, ['destination' => 'another destination']);
        $sink->update($this->sinkData);

        $this->assertEquals($this->sinkData['destination'], $sink->info()['destination']);
    }

    public function testUpdatesDataWithoutCachedData()
    {
        $this->connection->updateSink($this->sinkData + [
            'sinkName' => $this->formattedName,
        ])
            ->willReturn($this->sinkData)
            ->shouldBeCalledTimes(1);
        $this->connection->getSink(Argument::any())
            ->willReturn(['destination' => 'another destination'])
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection);
        $sink->update($this->sinkData);

        $this->assertEquals($this->sinkData['destination'], $sink->info()['destination']);
    }

    public function testGetsInfo()
    {
        $this->connection->getSink(Argument::any())->shouldNotBeCalled();
        $sink = $this->getSink($this->connection, $this->sinkData);

        $this->assertEquals($this->sinkData, $sink->info());
    }

    public function testGetsInfoWithReload()
    {
        $this->connection->getSink([
            'sinkName' => $this->formattedName
        ])
            ->willReturn($this->sinkData)
            ->shouldBeCalledTimes(1);
        $sink = $this->getSink($this->connection);

        $this->assertEquals($this->sinkData, $sink->info());
    }

    public function testGetsName()
    {
        $sink = $this->getSink($this->connection);

        $this->assertEquals($this->sinkName, $sink->name());
    }
}
