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

namespace Google\Cloud\Tests\Unit\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\ValueMapper;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class QueryResultsTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $projectId = 'myProjectId';
    public $jobId = 'myJobId';
    public $queryData = [
        'jobComplete' => true,
        'rows' => [
            ['f' => [['v' => 'Alton']]]
        ],
        'schema' => [
            'fields' => [
                [
                    'name' => 'first_name',
                    'type' => 'STRING'
                ]
            ]
        ]
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getQueryResults($connection, array $data = [])
    {
        return new QueryResults(
            $connection->reveal(),
            $this->jobId,
            $this->projectId,
            $data,
            [],
            new ValueMapper(false)
        );
    }

    /**
     * @expectedException \Google\Cloud\Core\Exception\GoogleException
     */
    public function testGetsRowsThrowsExceptionWhenQueryNotComplete()
    {
        $this->queryData['jobComplete'] = false;
        unset($this->queryData['rows']);
        $this->connection->getQueryResults()->shouldNotBeCalled();
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);
        $queryResults->rows()->next();
    }

    public function testGetsRowsWithNoResults()
    {
        $this->connection->getQueryResults()->shouldNotBeCalled();
        unset($this->queryData['rows']);
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);
        $rows = iterator_to_array($queryResults->rows());

        $this->assertEmpty($rows);
    }

    public function testGetsRowsWithoutToken()
    {
        $this->connection->getQueryResults()->shouldNotBeCalled();
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);
        $rows = iterator_to_array($queryResults->rows());

        $this->assertEquals('Alton', $rows[0]['first_name']);
    }

    public function testGetsRowsWithToken()
    {
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->queryData)
            ->shouldBeCalledTimes(1);
        $queryResults = $this->getQueryResults(
            $this->connection,
            $this->queryData + ['pageToken' => 'abcd']
        );
        $rows = iterator_to_array($queryResults->rows());

        $this->assertEquals('Alton', $rows[1]['first_name']);
    }

    public function testIsCompleteTrue()
    {
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);

        $this->assertTrue($queryResults->isComplete());
    }

    public function testIsCompleteFalse()
    {
        $this->queryData['jobComplete'] = false;
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);

        $this->assertFalse($queryResults->isComplete());
    }

    public function testGetsInfo()
    {
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);

        $this->assertEquals($this->queryData, $queryResults->info());
    }

    public function testReloadsInfo()
    {
        $this->connection->getQueryResults(Argument::any())
            ->willReturn(['jobComplete' => true])
            ->shouldBeCalledTimes(1);
        $queryResults = $this->getQueryResults($this->connection, $this->queryData);

        $this->assertEquals(['jobComplete' => true], $queryResults->reload());
    }

    public function testGetsIdentity()
    {
        $queryResults = $this->getQueryResults($this->connection);

        $this->assertEquals($this->jobId, $queryResults->identity()['jobId']);
        $this->assertEquals($this->projectId, $queryResults->identity()['projectId']);
    }
}
