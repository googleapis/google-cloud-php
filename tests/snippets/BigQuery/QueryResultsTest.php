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

namespace Google\Cloud\Tests\Snippets\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class QueryResultsTest extends SnippetTestCase
{
    const JOB_ID = 1;
    const PROJECT = 'my-awesome-project';

    private $info;
    private $reload;
    private $connection;
    private $qr;

    public function setUp()
    {
        $this->info = [
            'totalBytesProcessed' => 3,
            'jobComplete' => false,
            'jobReference' => [
                'jobId' => 'job'
            ],
            'rows' => [
                [
                    'f' => [
                        ['v' => 'abcd']
                    ]
                ]
            ],
            'schema' => [
                'fields' => [
                    [
                        'name' => 'name',
                        'type' => 'STRING'
                    ]
                ]
            ]
        ];
        $this->reload = [];

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->qr = \Google\Cloud\Dev\stub(QueryResults::class, [
            $this->connection->reveal(),
            self::JOB_ID,
            self::PROJECT,
            $this->info,
            $this->reload,
            new ValueMapper(false)
        ]);
    }

    public function testRows()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'rows');
        $snippet->addLocal('queryResults', $this->qr);

        $this->info['jobComplete'] = true;
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $this->qr->reload();

        $res = $snippet->invoke();
        $this->assertEquals('abcd', trim($res->output()));
    }

    public function testIsComplete()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'isComplete');
        $snippet->addLocal('queryResults', $this->qr);

        $this->info['jobComplete'] = true;
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Query complete!', $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'identity');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke();
        $this->assertEquals(self::PROJECT, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'info');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke();
        $this->assertEquals($this->info['totalBytesProcessed'], $res->output());
    }

    public function testReload()
    {
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['jobComplete' => true] + $this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(QueryResults::class, 'reload');
        $snippet->addLocal('queryResults', $this->qr);
        $snippet->replace('sleep(1);', '');

        $res = $snippet->invoke();
        $this->assertEquals('Query complete!', $res->output());
    }
}
