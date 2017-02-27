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
use Google\Cloud\Logging\Metric;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group logging
 */
class MetricTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $formattedName;
    public $metricName = 'myMetric';
    public $projectId = 'myProjectId';
    public $metricData = [
        'description' => 'wow a description'
    ];

    public function setUp()
    {
        $this->formattedName = "projects/$this->projectId/metrics/$this->metricName";
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getMetric($connection, array $data = [])
    {
        return new Metric($connection->reveal(), $this->metricName, $this->projectId, $data);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getMetric([
            'metricName' => $this->formattedName,
        ])
            ->willReturn([
                'name' => $this->metricName
            ])
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection);

        $this->assertTrue($metric->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getMetric([
            'metricName' => $this->formattedName,
        ])
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection);

        $this->assertFalse($metric->exists());
    }

    public function testDelete()
    {
        $this->connection->deleteMetric([
            'metricName' => $this->formattedName,
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection);

        $this->assertNull($metric->delete());
    }

    public function testUpdatesDataWithCachedData()
    {
        $this->connection->updateMetric($this->metricData + [
            'metricName' => $this->formattedName,
        ])
            ->willReturn($this->metricData)
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection, ['description' => 'another description']);
        $metric->update($this->metricData);

        $this->assertEquals($this->metricData['description'], $metric->info()['description']);
    }

    public function testUpdatesDataWithoutCachedData()
    {
        $this->connection->updateMetric($this->metricData + [
            'metricName' => $this->formattedName,
        ])
            ->willReturn($this->metricData)
            ->shouldBeCalledTimes(1);
        $this->connection->getMetric(Argument::any())
            ->willReturn(['description' => 'another description'])
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection);
        $metric->update($this->metricData);

        $this->assertEquals($this->metricData['description'], $metric->info()['description']);
    }

    public function testGetsInfo()
    {
        $this->connection->getMetric(Argument::any())->shouldNotBeCalled();
        $metric = $this->getMetric($this->connection, $this->metricData);

        $this->assertEquals($this->metricData, $metric->info());
    }

    public function testGetsInfoWithReload()
    {
        $this->connection->getMetric([
            'metricName' => $this->formattedName
        ])
            ->willReturn($this->metricData)
            ->shouldBeCalledTimes(1);
        $metric = $this->getMetric($this->connection);

        $this->assertEquals($this->metricData, $metric->info());
    }

    public function testGetsName()
    {
        $metric = $this->getMetric($this->connection);

        $this->assertEquals($this->metricName, $metric->name());
    }
}
