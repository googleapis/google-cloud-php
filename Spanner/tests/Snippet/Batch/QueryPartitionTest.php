<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Snippet\Batch;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 */
class QueryPartitionTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use PartitionSharedSnippetTestTrait;
    use RequestHandlingTestTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $requestHandler;
    private $serializer;
    private $className = QueryPartition::class;
    private $sql = 'SELECT 1=1';
    private $time;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->time = time();
        $this->partition = new QueryPartition($this->token, $this->sql, $this->options);
    }

    public function testClass()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'createSession',
            null,
            ['name' => self::SESSION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $this->time)->format(Timestamp::FORMAT)
            ]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'partitionQuery',
            null,
            [
                'partitions' => [
                    ['partitionToken' => 'foo']
                ]
            ]
        );

        $client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->requestHandler->reveal(), $this->serializer, false),
            self::DATABASE
        ]);

        $snippet = $this->snippetFromClass(QueryPartition::class);
        $snippet->setLine(3, '');
        $snippet->addLocal('batch', $client);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(QueryPartition::class, $res->returnVal());
    }

    public function testSql()
    {
        $snippet = $this->snippetFromMethod(QueryPartition::class, 'sql');
        $snippet->addLocal('partition', $this->partition);

        $res = $snippet->invoke('sql');
        $this->assertEquals($this->sql, $res->returnVal());
    }
}
