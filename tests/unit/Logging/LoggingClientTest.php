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

use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\Metric;
use Google\Cloud\Logging\PsrLogger;
use Google\Cloud\Logging\Sink;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group logging
 */
class LoggingClientTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $formattedProjectId;
    public $sinkName = 'mySink';
    public $metricName = 'myMetric';
    public $projectId = 'myProjectId';
    public $textPayload = 'aPayload';
    public $client;

    public function setUp()
    {
        $this->formattedProjectId = "projects/$this->projectId";
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = new LoggingTestClient(['projectId' => $this->projectId]);
    }

    public function testPsrBatchLogger()
    {
        $psrBatchLogger = LoggingClient::psrBatchLogger('app');
        $this->assertInstanceOf(PsrLogger::class, $psrBatchLogger);
        $r = new \ReflectionObject($psrBatchLogger);
        $p = $r->getProperty('batchEnabled');
        $p->setAccessible(true);
        $this->assertTrue($p->getValue($psrBatchLogger));
        $psrBatchLogger = LoggingClient::psrBatchLogger(
            'app',
            ['clientConfig' => ['projectId' => 'my-project']]);
        $this->assertInstanceOf(PsrLogger::class, $psrBatchLogger);
        $r = new \ReflectionObject($psrBatchLogger);
        $p = $r->getProperty('clientConfig');
        $p->setAccessible(true);
        $this->assertEquals(
            ['projectId' => 'my-project'],
            $p->getValue($psrBatchLogger)
        );
    }

    public function testCreatesSink()
    {
        $destination = 'storage.googleapis.com/my-bucket';
        $this->connection->createSink([
            'parent' => $this->formattedProjectId,
            'name' => $this->sinkName,
            'destination' => $destination,
            'outputVersionFormat' => 'VERSION_FORMAT_UNSPECIFIED'
        ])
            ->willReturn([
                'name' => $this->sinkName,
                'destination' => $destination
            ])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());

        $sink = $this->client->createSink($this->sinkName, $destination);

        $this->assertInstanceOf(Sink::class, $sink);
        $this->assertEquals($this->sinkName, $sink->info()['name']);
    }

    public function testGetsSink()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(Sink::class, $this->client->sink($this->sinkName));
    }

    public function testGetsSinksWithNoResults()
    {
        $this->connection->listSinks(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $sinks = iterator_to_array($this->client->sinks());

        $this->assertEmpty($sinks);
    }

    public function testGetsSinksWithoutToken()
    {
        $this->connection->listSinks(Argument::any())
            ->willReturn([
                'sinks' => [
                    ['name' => $this->sinkName]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $sinks = iterator_to_array($this->client->sinks());

        $this->assertEquals($this->sinkName, $sinks[0]->name());
    }

    public function testGetsSinksWithToken()
    {
        $this->connection->listSinks(Argument::any())
            ->willReturn(
                [
                    'nextPageToken' => 'token',
                    'sinks' => [
                        ['name' => 'someOtherSink']
                    ]
                ],
                    [
                    'sinks' => [
                        ['name' => $this->sinkName]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());
        $sinks = iterator_to_array($this->client->sinks());

        $this->assertEquals($this->sinkName, $sinks[1]->name());
    }

    public function testCreatesMetric()
    {
        $filter = 'logName = myLog';
        $this->connection->createMetric([
            'parent' => $this->formattedProjectId,
            'name' => $this->metricName,
            'filter' => $filter
        ])
            ->willReturn([
                'name' => $this->metricName,
                'filter' => $filter
            ])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());

        $metric = $this->client->createMetric($this->metricName, $filter);

        $this->assertInstanceOf(Metric::class, $metric);
        $this->assertEquals($this->metricName, $metric->info()['name']);
    }

    public function testGetsMetric()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(Metric::class, $this->client->metric($this->metricName));
    }

    public function testGetsMetricsWithNoResults()
    {
        $this->connection->listMetrics(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $metrics = iterator_to_array($this->client->metrics());

        $this->assertEmpty($metrics);
    }

    public function testGetsMetricsWithoutToken()
    {
        $this->connection->listMetrics(Argument::any())
            ->willReturn([
                'metrics' => [
                    ['name' => $this->metricName]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $metrics = iterator_to_array($this->client->metrics());

        $this->assertEquals($this->metricName, $metrics[0]->name());
    }

    public function testGetsMetricsWithToken()
    {
        $this->connection->listMetrics(Argument::any())
            ->willReturn(
                [
                    'nextPageToken' => 'token',
                    'metrics' => [
                        ['name' => 'someOtherMetric']
                    ]
                ],
                    [
                    'metrics' => [
                        ['name' => $this->metricName]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());
        $metrics = iterator_to_array($this->client->metrics());

        $this->assertEquals($this->metricName, $metrics[1]->name());
    }

    public function testGetsEntriesWithNoResults()
    {
        $secondProjectId = 'secondProjectId';
        $this->connection->listEntries([
            'resourceNames' => [
                'projects/' . $this->projectId,
                'projects/' . $secondProjectId
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $entries = iterator_to_array($this->client->entries(['projectIds' => [$secondProjectId]]));

        $this->assertEmpty($entries);
    }

    public function testGetsEntriesWithoutToken()
    {
        $this->connection->listEntries(Argument::any())
            ->willReturn([
                'entries' => [
                    ['textPayload' => $this->textPayload]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $entries = iterator_to_array($this->client->entries());

        $this->assertEquals($this->textPayload, $entries[0]->info()['textPayload']);
    }

    public function testGetsEntriesWithToken()
    {
        $this->connection->listEntries(Argument::any())
            ->willReturn(
                [
                    'nextPageToken' => 'token',
                    'entries' => [
                        ['textPayload' => 'someOtherPayload']
                    ]
                ],
                    [
                    'entries' => [
                        ['textPayload' => $this->textPayload]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());
        $entries = iterator_to_array($this->client->entries());

        $this->assertEquals($this->textPayload, $entries[1]->info()['textPayload']);
    }

    public function testGetsPsrLogger()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(PsrLogger::class, $this->client->psrLogger('myLogger'));
    }

    public function testGetsLogger()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(Logger::class, $this->client->logger('myLogger'));
    }
}

class LoggingTestClient extends LoggingClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
