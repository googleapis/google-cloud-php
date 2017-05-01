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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group logging
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $formattedName = 'projects/myProjectId/logs/myLog';
    private $logName = 'myLog';
    private $projectId = 'myProjectId';
    private $textPayload = 'aPayload';
    private $jsonPayload = ['a' => 'payload'];
    private $resource = ['type' => 'global'];
    private $microtime = 315532800.000000;
    private $formattedTimestamp = '1980-01-01T00:00:00.000000Z';

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testDelete()
    {
        $this->connection->deleteLog([
            'logName' => $this->formattedName,
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection);

        $this->assertNull($logger->delete());
    }

    public function testGetsEntriesWithNoResults()
    {
        $options = [
            'orderBy' => 'timestamp desc',
            'pageSize' => 50
        ];
        $this->connection->listEntries($options + [
            'resourceNames' => ["projects/$this->projectId"],
            'filter' => "logName = $this->formattedName"
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $logger = $this->getLogger($this->connection);
        $entries = iterator_to_array($logger->entries($options));

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

        $logger = $this->getLogger($this->connection);
        $entries = iterator_to_array($logger->entries());

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

        $logger = $this->getLogger($this->connection);
        $entries = iterator_to_array($logger->entries());

        $this->assertEquals($this->textPayload, $entries[1]->info()['textPayload']);
    }

    public function testGetsEntriesWithAdditionalFilter()
    {
        $filter = 'textPayload = "hello world"';
        $this->connection->listEntries([
            'resourceNames' => ["projects/$this->projectId"],
            'filter' => $filter . " AND logName = $this->formattedName"
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $logger = $this->getLogger($this->connection);
        $entries = iterator_to_array($logger->entries([
            'filter' => $filter
        ]));

        $this->assertEmpty($entries);
    }

    /**
     * @dataProvider entryProvider
     */
    public function testCreatesEntry($data, array $options, array $expected)
    {
        $logger = $this->getLogger($this->connection);
        $logger->setTime($this->microtime);
        $entry = $logger->entry($data, $options);

        $this->assertEquals($expected, $entry->info());
    }

    public function entryProvider()
    {
        $stringTimestamp = '2017-04-21T15:46:37.724986Z';
        return [
            [
                $this->textPayload,
                ['timestamp' => $stringTimestamp],
                [
                    'textPayload' => $this->textPayload,
                    'timestamp' => $stringTimestamp,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
                ]
            ],
            [
                $this->textPayload,
                ['timestamp' => new Timestamp(new \DateTime('1980-01-01'))],
                [
                    'textPayload' => $this->textPayload,
                    'timestamp' => $this->formattedTimestamp,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
                ]
            ],
            [
                $this->textPayload,
                ['timestamp' => new \DateTime('1980-01-01')],
                [
                    'textPayload' => $this->textPayload,
                    'timestamp' => $this->formattedTimestamp,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
                ]
            ],
            [
                $this->jsonPayload,
                [],
                [
                    'jsonPayload' => $this->jsonPayload,
                    'timestamp' => $this->formattedTimestamp,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
                ]
            ]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateEntryThrowsExceptionWithInvalidData()
    {
        $logger = $this->getLogger($this->connection);
        $entry = $logger->entry(123123);
    }

    public function testWritesEntry()
    {
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => $this->formattedTimestamp
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection);

        $this->assertNull($logger->write($this->textPayload, ['resource' => $this->resource]));
    }

    public function testLoggerUsesDefaults()
    {
        $resource = ['type' => 'default'];
        $labels = ['testing' => 'labels'];
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $resource,
                    'labels' => $labels,
                    'timestamp' => $this->formattedTimestamp
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection, $resource, $labels);

        $this->assertNull($logger->write($this->textPayload));
    }

    public function testOverrideLoggerDefaults()
    {
        $newResource = ['type' => 'new'];
        $defaultLabels = ['testing' => 'labels'];
        $newLabels = ['new' => 'labels'];
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $newResource,
                    'labels' => $newLabels,
                    'timestamp' => $this->formattedTimestamp
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection, [], $defaultLabels);

        $this->assertNull(
            $logger->write($this->textPayload, [
                'resource' => $newResource,
                'labels' => $newLabels
            ])
        );
    }

    public function testOverwritesEntryOptionsAndWrites()
    {
        $severity = 'INFO';
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'severity' => $severity,
                    'timestamp' => $this->formattedTimestamp
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection);
        $entry = $logger->entry($this->textPayload, [
            'resource' => $this->resource,
            'severity' => 'DEBUG' // this should be overwritten
        ]);

        $this->assertNull($logger->write($entry, [
            'severity' => $severity,
            'timestamp' => $this->formattedTimestamp
        ]));
    }

    public function testWritesEntries()
    {
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => $this->formattedTimestamp
                ],
                [
                    'jsonPayload' => $this->jsonPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => $this->formattedTimestamp
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $logger = $this->getLogger($this->connection);
        $entry1 = $logger->entry($this->textPayload, ['resource' => $this->resource]);
        $entry2 = $logger->entry($this->jsonPayload, ['resource' => $this->resource]);

        $this->assertNull($logger->writeBatch([$entry1, $entry2]));
    }

    private function getLogger($connection, array $resource = null, array $labels = null)
    {
        $logger = new LoggerStub($connection->reveal(), $this->logName, $this->projectId, $resource, $labels);
        $logger->setTime($this->microtime);

        return $logger;
    }
}

class LoggerStub extends Logger
{
    private $time;

    public function setTime($time)
    {
        $this->time = $time;
    }

    protected function microtime()
    {
        return $this->time ?: microtime(true);
    }
}
