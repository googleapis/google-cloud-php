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
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group logging
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $formattedName;
    public $logName = 'myLog';
    public $projectId = 'myProjectId';
    public $textPayload = 'aPayload';
    public $jsonPayload = ['a' => 'payload'];
    public $resource = ['type' => 'global'];

    public function setUp()
    {
        $this->formattedName = "projects/$this->projectId/logs/$this->logName";
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getLogger($connection, array $resource = null, array $labels = null)
    {
        return new Logger($connection->reveal(), $this->logName, $this->projectId, $resource, $labels);
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
    public function testCreatesEntry($data, $type)
    {
        $logger = $this->getLogger($this->connection);
        $entry = $logger->entry($data);

        $this->assertEquals($data, $entry->info()[$type]);
    }

    public function entryProvider()
    {
        return [
            [$this->textPayload, 'textPayload'],
            [$this->jsonPayload, 'jsonPayload']
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
                    'resource' => $this->resource
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
                    'labels' => $labels
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
                    'labels' => $newLabels
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
                    'severity' => $severity
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
            'severity' => $severity
        ]));
    }

    public function testWritesEntries()
    {
        $this->connection->writeEntries([
            'entries' => [
                [
                    'textPayload' => $this->textPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
                ],
                [
                    'jsonPayload' => $this->jsonPayload,
                    'logName' => $this->formattedName,
                    'resource' => $this->resource
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
}
